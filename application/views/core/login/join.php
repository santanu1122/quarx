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

<!-- main content -->

<div class="quarx-small-device">

    <div class="raw100"><p>We're going to need a little bit of information in order to get your profile built. Please complete the following.</p></div>

    <form id="quarx-join-form" method="post" action="<?= site_url('login/submit'); ?>">

        <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>" />

        <div class="raw100">
            <input id="u_name" type="text" data-deefault="Username" name="username" onkeyup="validationCheck(this.value, '<?= site_url('ajax/unc'); ?>/')" />
        </div>

        <div class="raw100">
            <input id="password" type="password" name="password" data-deefault="Password"  />
        </div>
        <div class="raw100">
            <input id="confirm" type="password" name="confirm" data-deefault="Confirm Password" />
        </div>

        <div class="raw100">
            <input id="user_email" data-type="Email" type="text" name="email" data-deefault="Email" />
        </div>
        <div class="raw100">
            <input id="full_name" type="text" name="full_name" data-deefault="Full Name" />
        </div>

        <div class="raw100">
            <input id="location" type="text" name="location" data-deefault="Location" />
        </div>

        <div class="raw100 raw-block-35"></div>

        <div class="raw100">
            <button id="saveBtn" type="submit">Submit</button>
        </div>

    </form>

</div>

<?php $this->carabiner->display("quarx-join-js"); ?>

<?php //End of File ?>