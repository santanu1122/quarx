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

<div class="quarx-small-device">

    <form id="pwChanger" class="raw100 raw-margin-top-30" method="post" action="<?php echo site_url('users/password/update'); ?>">
        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />

        <div class="raw100 raw-left">
            <div class="raw100 raw-left">
                <div class="raw50 raw-left"><p>New Password</p></div>
                <div class="raw50 raw-left"><input id="password" type="password" name="password" size="20" /></div>
            </div>
            <div class="raw100 raw-left">
                <div class="raw50 raw-left"><p>New Password Again</p></div>
                <div class="raw50 raw-left"><input id="confirm" type="password" name="confirm" size="20" /></div>
            </div>
            <div class="raw100 raw-left">
                <div class="raw100 raw-left"><input id="changeBtn" type="submit" value="Change" /></div>
            </div>
        </div>
    </form>

</div>

<?php /* End of File */ ?>