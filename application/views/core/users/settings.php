<?php

/**
 * Quarx
 *
 * A modular application framework built on CodeIgniter
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

<div class="quarx-device">

    <div class="raw-padding-20">

        <h2>Notification Settings</h2>
        <form id="quarxUserSettings" method="post" action="<?= site_url("users/settings_update"); ?>">
            <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>" />

            <div class="raw50">
                <input data-theme="a" id="quarxNotificationSetting" type="checkbox" <?= $notifications_setting; ?> value="1" name="quarxNotificationSetting" />
                <label for="quarxNotificationSetting">Notifications On</label>
            </div>

        </form>

        <script type="text/javascript">

            $("#quarxNotificationSetting").click(function(){
                $("#quarxUserSettings").submit();
            });

        </script>

        <?php $this->module_tools->get_module_settings(); ?>

    </div>

</div>

<!-- End of File -->