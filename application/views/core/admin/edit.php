<?php

/**
 * Quarx
 *
 * A modular application structure built on CodeIgniter
 *
 * @package     Quarx
 * @author      Matt Lantz
 * @copyright   Copyright (c) 2013 - 2014 Matt Lantz
 * @license     https://ottacon.co/docs/quarx/license.html
 * @link        https://github.com/mlantz/quarx
 * @since       Version 1.0
 *
 */

?>

<!-- dialogs -->

<div id="dialog-account_info" class="dialogBox" title="Account Information">
    <p>The advanced accounts are simply a means of adding more fields to the currect accounts. If you selected this durring installation you can easily turn it off. But, don't be afraid, because even if you turn it off, none of the information is lost, its only hidden.</p>
</div>

<div id="dialog-master_info" class="dialogBox" title="Master Information">
    <p>Master access is a tool for those who wish to only give their users access to special things or, solely thier profiles. When master access is turned on, only those with master level accounts can access modules.</p>
</div>

<div id="dialog-joining_info" class="dialogBox" title="Joining Information">
    <p>In some cases you may wish for users to be able to join your web app. In this make sure this option is enabled in order to let them make an account from the login screen.</p>
</div>

<div id="dialog-autoAuth_info" class="dialogBox" title="Auto-Authorizing Information">
    <p>Auto Authorizing is a portion of the enabled joining component. It allows people to be automatically authorized when they request an account, or if you prefer you can keep that level of control on a personal level, by turning auto-authorization off.</p>
</div>

<!-- content -->

<div class="raw100">
    <div class="quarx-small-device">

        <p class="align-left">There are a variety of options in your current Quarx version.</p>
        <br />
        <form method="post" enctype="multipart/form-data" action="<?= site_url('admin/edit/update'); ?>">
                <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>" />

                <div class="raw100 raw-left">
                    <div class="raw80 raw-left">
                        <input data-theme="a" id="accountStatus" type="checkbox" <?= $accountStatus; ?> value="1" name="advancedAccounts" />
                        <label for="accountStatus">Advanced Accounts</label>
                    </div>
                    <div class="raw20 raw-left align-center">
                        <button id="account_info" data-inline="true" data-role="button" data-icon="info" data-iconpos="notext"></button>
                    </div>
                </div>

                <div class="raw100 raw-left">
                    <div class="raw80 raw-left">
                        <input data-theme="a" id="masterAccess" type="checkbox" <?= $masterAccess; ?> value="1" name="masterAccess" />
                        <label for="masterAccess">Master Access</label>
                    </div>
                    <div class="raw20 raw-left align-center">
                        <button id="master_info" data-inline="true" data-role="button" data-icon="info" data-iconpos="notext"></button>
                    </div>
                </div>

                <div class="raw100 raw-left">
                    <div class="raw80 raw-left">
                        <input data-theme="a" id="enableJoining" type="checkbox" <?= $joining; ?> value="1" name="enableJoining" />
                        <label for="enableJoining">Enable Joining</label>
                    </div>
                    <div class="raw20 raw-left align-center">
                        <button id="joining_info" data-inline="true" data-role="button" data-icon="info" data-iconpos="notext"></button>
                    </div>
                </div>

                <?php

                    if ($joiningIsEnabled)
                    {
                        echo '<div class="raw100 raw-left">';
                        echo '<div class="raw80 raw-left">';
                        echo '<input data-theme="a" id="autoAuth" type="checkbox" '.$auto_auth.' value="1" name="autoAuth" />';
                        echo '<label for="autoAuth">Auto-Authorizing</label>';
                        echo '</div>';
                        echo '<div class="raw20 raw-left align-center">';
                        echo '<button class="icon" id="autoAuth_info" data-inline="true" data-role="button" data-icon="info" data-iconpos="notext"></button>';
                        echo '</div>';
                        echo '</div>';
                    }

                ?>

                <div class="raw100 raw-left raw-block-35"></div>

                <div class="raw100 raw-left">
                    <input data-role="button" data-theme="a" type="submit" value="Save Settings" />
                </div>
                <div class="raw100 raw-left">
                    <a data-role="button" data-theme="a" href="<?= site_url('login'); ?>">Return To Quarx</a>
                </div>
            </form>
        </div>

    </div>
</div>

<?php $this->carabiner->display("quarx-admin-js"); ?>

<script type="text/javascript">

    $(function(){
        $("button").parent().css("marginTop", "16px");
    });

</script>

<?php /* End of File */ ?>