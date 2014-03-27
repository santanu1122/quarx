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

<div class="raw100">
    <div class="quarx-device">

        <div class="raw50 raw-left">

        <div class="raw100 raw-left mHide">

            <?php

                $profile_image = $root.'uploads/img/thumb/default.jpg';
                if ($profile->img !== "" && ! is_null($profile->img)) $profile_image = $profile->img;
                echo '<div class="quarx-profile-image" style="background-image: url('.$this->image_tools->change_img_size($profile_image, "medium").');"></div>';

            ?>

        </div>

        <?php

            $map = '<div class="raw100 raw-left mHide">';
            $map .= '<div class="quarx-google-map">';
                $map .= '<div id="quarx-map" class="quarx-google-map-inner">';
                    $map .= '<h3 class="raw-padding-40">Please enter your postal/zip code, then click <u>here</u> </h3>';
                $map .= '</div>';
            $map .= '</div>';
            $map .= '</div>';

            if ($this->quarx->get_option("account_type") == 'advanced accounts') echo $map;

        ?>

        </div>

        <div class="raw50 raw-left">

            <div id="quarx-form-holder" class="raw100 quarx-form">
                <form id="quarx-add-account" method="post" enctype="multipart/form-data" action="<?= site_url('users/update_user_profile'); ?>">

                    <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>" />

                    <!-- // These are the hidden fields with the lat and lng values -->
                    <input id="latBox" type="hidden" name="latitude" value="<?= $profile->lat; ?>" />
                    <input id="lngBox" type="hidden" name="longitude" value="<?= $profile->lng; ?>" />

                    <input type="hidden" name="id" value="<?= $this->crypto->encrypt($profile->id); ?>" />

                    <!-- // Get to  the actual form! -->
                    <div class="raw100 raw-left">
                        <div class="raw33 raw-left">
                            <p>Username</p>
                        </div>
                        <div class="raw66 raw-left">
                            <p><?= $profile->username; ?></p>
                        </div>
                    </div>
                    <div class="raw100 raw-left">
                        <div class="raw33 raw-left">
                            <p>Email</p>
                        </div>
                        <div class="raw66 raw-left">
                            <input data-type="Email" class="vital" type="text" name="email" value="<?= $profile->email; ?>" />
                        </div>
                    </div>
                    <div class="raw100 raw-left">
                        <div class="raw33 raw-left">
                            <p>Full Name</p>
                        </div>
                        <div class="raw66 raw-left">
                            <input class="vital" type="text" name="full_name" value="<?= $profile->full_name; ?>" />
                        </div>
                    </div>

<?php if ($this->quarx->get_option("account_type") == 'advanced accounts'){ ?>

                    <div class="raw100 raw-left">
                        <div class="raw33 raw-left">
                            <p>Address</p>
                        </div>
                        <div class="raw66 raw-left">
                            <input type="text" name="address" value="<?= $profile->address; ?>" />
                        </div>
                    </div>
                    <div class="raw100 raw-left">
                        <div class="raw33 raw-left">
                            <p>City</p>
                        </div>
                        <div class="raw66 raw-left">
                            <input type="text" name="city" value="<?= $profile->city; ?>" />
                        </div>
                    </div>
                    <div class="raw100 raw-left">
                        <div class="raw33 raw-left">
                            <p>State/Province</p>
                        </div>
                        <div class="raw66 raw-left">
                            <input type="text" name="state_prov" value="<?= $profile->state; ?>" />
                        </div>
                    </div>
                    <div class="raw100 raw-left">
                        <div class="raw33 raw-left">
                            <p>Zip/Postal Code</p>
                        </div>
                        <div class="raw66 raw-left">
                            <input id="location" type="text" name="location" value="<?= $profile->location; ?>" onblur="locateMe('<?= $root; ?>', this.value, '')" />
                        </div>
                    </div>
                    <div class="raw100 raw-left">
                        <div class="raw33 raw-left">
                            <p>Country</p>
                        </div>
                        <div class="raw66 raw-left">
                            <input type="text" name="country" value="<?= $profile->country; ?>" />
                        </div>
                    </div>
                    <div class="raw100 raw-left">
                        <div class="raw33 raw-left">
                            <p>Phone</p>
                        </div>
                        <div class="raw66 raw-left">
                            <input type="text" name="phone" value="<?= $profile->phone; ?>" />
                        </div>
                    </div>
                    <div class="raw100 raw-left">
                        <div class="raw33 raw-left">
                            <p>Fax</p>
                        </div>
                        <div class="raw66 raw-left">
                            <input type="text" name="fax" value="<?= $profile->fax; ?>" />
                        </div>
                    </div>
                    <div class="raw100 raw-left">
                        <div class="raw33 raw-left">
                            <p>Website</p>
                        </div>
                        <div class="raw66 raw-left">
                            <input type="text" name="website" value="<?= $profile->website; ?>" />
                        </div>
                    </div>
                    <div class="raw100 raw-left">
                        <div class="raw33 raw-left">
                            <p>Company</p>
                        </div>
                        <div class="raw66 raw-left">
                            <input type="text" name="company" value="<?= $profile->company; ?>" />
                        </div>
                    </div>

<?php } else { ?>

                    <div class="raw100 raw-left">
                        <div class="raw33 raw-left">
                            <p>Location</p>
                        </div>
                        <div class="raw66 raw-left">
                            <input id="location" type="text" name="location" value="<?= $profile->location; ?>" onblur="locateMe('<?= $root; ?>', this.value, '')" />
                        </div>
                    </div>

<?php } ?>

                    <div class="raw100 raw-left">
                        <div class="raw33 raw-left">
                            <p>Profile Image</p>
                        </div>
                        <div class="raw66 raw-left">
                            <input type="file" name="userfile" size="20" />
                        </div>
                    </div>
                    <div class="raw100 raw-left">
                        <div class="raw32 raw-left">
                            <input id="saveBtn" type="submit" data-theme="d" value="Save" />
                        </div>

                        <?php

                            if ($profile->account_status == "enabled")
                            {
                                echo '<div class="raw2 raw-left raw-block-10"></div>';
                                echo '<div class="raw32 raw-left">';
                                    echo '<button id="disableBtn" data-theme="b" onclick="disable(\''.$this->crypto->encrypt($profile->id).'\', \''.site_url('users/modify_user/disable').'\')">Disable</button>';
                                echo '</div>';
                            }
                            else if ($profile->account_status == "inactive")
                            {
                                echo '<div class="raw2 raw-left raw-block-10"></div>';
                                echo '<div class="raw32 raw-left">';
                                    echo '<button id="authorizeBtn" data-theme="c" onclick="authorize(\''.$this->crypto->encrypt($profile->id).'\', \''.site_url('users/modify_user/authorize').'\')">Authorize</button>';
                                echo '</div>';
                            }
                            else if ($profile->account_status == "disabled")
                            {
                                echo '<div class="raw2 raw-left raw-block-10"></div>';
                                echo '<div class="raw32 raw-left">';
                                    echo '<button id="enableBtn" data-theme="c" onclick="enable(\''.$this->crypto->encrypt($profile->id).'\', \''.site_url('users/modify_user/enable').'\')">Enable</button>';
                                echo '</div>';
                            }

                        ?>

                        <div class="raw2 raw-left raw-block-10"></div>
                        <div class="raw32 raw-left">
                            <button id="deleteBtn" data-theme="e" onclick="deleteConfirm('<?= $this->crypto->encrypt($profile->id); ?>', '<?= site_url('users/delete_user') ?>')">Delete</button>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php

    if ($this->quarx->get_option("account_type") == 'advanced accounts')
    {
        echo '<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=false"></script>';
        echo '<script type="text/JavaScript" src="'.$root.'js/googlemaps.js"></script>';
    }

    $this->carabiner->display("quarx-users-js");

?>

<script type="text/javascript">

    $("#saveBtn").click(function(){
        _quarx_loading();
    });

<?php

    if ($this->quarx->get_option("account_type") == 'advanced accounts' )
    {
        echo 'if ($("#latBox").val() > 0) { _locateMeAlt(); }';
    }

?>

</script>

<?php //End of File ?>