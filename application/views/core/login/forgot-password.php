<?php

/**
 * Quarx
 *
 * A modular CMS application
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

<!-- main content -->

<div class="raw100"><!-- content -->

    <div class="quarx-small-device">

        <div class="raw100 raw-left">
        	<p>Please enter the following to get a new password sent to you.</p>
        </div>

        <div class="raw100 quarx-form raw-left">

            <form action="<?= site_url('login/password'); ?>" method="post">

                <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>" />

                <div class="raw100 raw-left">
                    <div class="raw33 raw-left">
                        <p>Username</p>
                    </div>
                    <div class="raw66 raw-left">
                        <input name="username" type="text" />
                    </div>
                </div>
                <div class="raw100 raw-left">
                    <div class="raw33 raw-left">
                        <p>Email</p>
                    </div>
                    <div class="raw66 raw-left">
                        <input name="email" type="text" />
                    </div>
                </div>
                <div class="raw100 raw-left">
                    <input type="submit" value="New Password" />
                </div>
    		</form>

        </div>

    </div>

</div><!--/content -->

<?php /* End of File */ ?>