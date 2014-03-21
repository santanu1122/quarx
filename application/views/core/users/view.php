<?php

/**
 * Quarx
 *
 * A modular CMS application
 *
 * @package     Quarx
 * @author      Matt Lantz
 * @copyright   Copyright (c) 2013 Matt Lantz
 * @license     http://ottacon.co/quarx/license.html
 * @link        http://ottacon.co/quarx
 * @since       Version 1.0
 *
 */

?>

<!-- dialogs -->

<div id="dialog-confirm" class="dialogBox" title="Delete Confirmation">
    <p>Are you sure you want to delete this account?</p>
</div>

<div id="dialog-enable" class="dialogBox" title="Enable Confirmation">
    <p>Are you sure you want to enable this account?</p>
</div>

<div id="dialog-master" class="dialogBox" title="Master User Confirmation">
    <p>Are you sure you want to give this account master status?</p>
</div>

<div id="dialog-downgrade" class="dialogBox" title="Standard User Confirmation">
    <p>Are you sure you want to revoke this accounts master status?</p>
</div>

<div id="dialog-authorize" class="dialogBox" title="Authorization Confirmation">
    <p>Are you sure you want to authorize this account?</p>
</div>

<div id="dialog-disable" class="dialogBox" title="Disable Confirmation">
    <p>Are you sure you want to disable this account? This will not delete the account or its information.</p>
</div>

<!-- content -->

<div class="quarx-device">
    <div class="raw100">
        <div class="raw100">
            <form id="quarx-member-search" method="post" action="<?php echo site_url('users/search-for'); ?>">
                <input id="quarx-search" name="search" class="quarx-search-bar deefault" data-deefault="Enter a member name, email or location" />
                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
            </form>

            <div class="raw100">
                <div class="quarx-gridrow quarx-bordered">
                    <div class="quarx-grid20"><h3>Username</h3></div>
                    <div class="quarx-grid20 mHide"><h3>Email</h3></div>
                    <div class="quarx-grid20 mHide"><h3>Full Name</h3></div>
                    <div class="quarx-grid20 mHide"><h3>Last Login</h3></div>
                    <div class="quarx-grid20 mHide"><h3></h3></div>
                </div>

                    <?php

                        foreach($profiles as $user)
                        {
                            $authorization = $user->account_status;
                            $authorization_indicator = ($user->account_status == 'inactive' ? "unauthorized" : "");

                            echo '<div class="quarx-account-info-row quarx-gridrow quarx-bordered '.$authorization_indicator.'">';
                                echo '<div class="quarx-account-controls">';
                                    echo '<div id="quarx-control-box" class="raw100">';

                                    if ($authorization == 'enabled')
                                    {
                                        echo '<div class="quarx-grid20"><button class="quarx-green" onclick="window.location=\''.site_url('users/editor').'/'.$this->crypto->encrypt($user->id).'\'">Edit</button></div>';
                                        echo '<div class="quarx-grid20 mHide"><button class="quarx-yellow" onclick="disable(\''.$this->crypto->encrypt($user->id).'\', \''.site_url('users/modify_user/disable').'\')">Disable</button></div>';
                                    }

                                    if ($authorization == 'disabled') echo '<div class="quarx-grid20 mHide"><button class="quarx-green" onclick="enable(\''.$this->crypto->encrypt($user->id).'\', \''.site_url('users/modify_user/enable').'\')">Enable</button></div>';

                                    echo '<div class="quarx-grid20 mHide"><button class="quarx-red" onclick="deleteConfirm(\''.$this->crypto->encrypt($user->id).'\', \''.site_url('users/delete_user').'\')">Delete</button></div>';

                                    if($user->permission > 1 ) echo '<div class="quarx-grid20 mHide"><button class="quarx-blue" onclick="masterConfirm(\''.$this->crypto->encrypt($user->id).'\', \''.site_url('users/modify_user/master').'\')">Master</button></div>';
                                    if($user->permission == 1 ) echo '<div class="quarx-grid20 mHide"><button class="quarx-blue" onclick="standardConfirm(\''.$this->crypto->encrypt($user->id).'\', \''.site_url('users/modify_user/standard').'\')">Standard</button></div>';

                                    if ($authorization == "inactive")
                                    {
                                        echo '<div class="quarx-grid20"><button class="quarx-green" onclick="window.location=\''.site_url('users/editor').'/'.$this->crypto->encrypt($user->id).'\'">View</button></div>';
                                        echo '<div class="quarx-grid20"><button class="quarx-green" onclick="authorize(\''.$this->crypto->encrypt($user->id).'\', \''.site_url('users/modify_user/authorize').'\')">Authorize</button></div>';
                                    }

                                    echo '<div class="quarx-grid20 raw-right"><button class="closer" data-icon="delete">Close</button></div>';

                                    echo '</div>';
                                echo '</div>';

                                echo '<div class="quarx-account-info">';
                                    echo '<div class="quarx-grid20"><p><a href="'.site_url('users/editor').'/'.$this->crypto->encrypt($user->id).'">'.$this->tools->length_check($user->username, 20).'</a></p></div>';
                                    echo '<div class="quarx-grid20 mHide"><p>'.$this->tools->val_trim($this->tools->length_check($user->email), 15).'</p></div>';
                                    echo '<div class="quarx-grid20 mHide"><p>'.$this->tools->val_trim($this->tools->length_check($user->full_name), 20).'</p></div>';
                                    echo '<div class="quarx-grid20 mHide"><p>'.$this->tools->val_trim($this->tools->length_check($user->last_login), 20).'</p></div>';
                                    echo '<div class="quarx-grid20 mHide">';

                                        if ($authorization == 'enabled') echo '<img src="'.site_url().'/img/active.png" title="active" class="raw15 raw-padding-5" />';
                                        if ($authorization == 'disabled') echo '<img src="'.site_url().'/img/inactive.png" title="active" class="raw15 raw-padding-5" />';
                                        if ($authorization == 'inactive') echo '<img src="'.site_url().'/img/lock.png" title="active" class="raw12 raw-padding-5" />';

                                    echo '<img src="'.site_url().'/img/settings.png" title="Edit Account" class="quarx-action-btn raw20 raw-padding-5 quarx-right-float quarx-clickable" />';
                                echo '</div>';
                            echo '</div>';
                            echo '</div>';
                        }

                    ?>


                </div>

                <div class="raw100 raw-left">
                    <?= $this->pagination->create_links(); ?>
                </div>

            </div>
            <?php

                if (count($profiles) == 0)
                {
                    echo '<div class="raw100 raw-left quarx-muted quarx-align-center raw-margin-top-40">';
                        echo '<h2>You should add some users.</h2>';
                    echo '</div>';
                }

            ?>
        </div>
    </div>

<?php $this->carabiner->display('quarx-users-js'); ?>

<!-- End of File -->