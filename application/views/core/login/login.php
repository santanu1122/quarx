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

<div class="raw100">

    <div class="quarx-small-device">
        <div class="quarx-form raw100">

            <form method="post" action="<?= site_url('login/validate'); ?>" data-ajax="false">
                <div class="raw100 raw-left quarx-mobile-table">

                    <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>" />

                    <div class="raw100 raw-left">
                        <div class="raw50 raw-left">
                            <p>Username</p>
                        </div>
                        <div class="raw50 raw-left">
                            <input type="text" name="username" />
                        </div>
                    </div>
                    <div class="raw100 raw-left">
                        <div class="raw50 raw-left">
                            <p>Password</p>
                        </div>
                        <div class="raw50 raw-left">
                            <input type="password" name="password" />
                        </div>
                    </div>
                    <div class="raw100 raw-left">
                        <div class="raw50 raw-left">
                            <p>Remember Me <br /> ( 2 weeks )</p>
                        </div>
                        <div class="raw50 raw-left">
                            <input type="checkbox" id="rememberMe" name="remember_me" value="1" />
                            <label for="rememberMe">Yes please.</label>
                        </div>
                    </div>
                    <div class="raw100 raw-left">
                        <input type="submit" value="Log In" />
                    </div>
                </div>
            </form>

        </div>

        <div class="raw100 raw-left">
            <a data-role="button" href="<?= site_url('login/forgot'); ?>">Forgot My Password</a>
        </div>

<?php

    if ($joiningIsEnabled) {

        echo '<div class="raw100 raw-left raw-block-25"></div>';
        echo '<div class="raw100 raw-left">';
        echo '<a data-role="button" href="'.site_url('login/join').'">Click Here to Join</a>';
        echo '</div>';
    }
?>

    </div>

</div>

<?php /* End of File */ ?>