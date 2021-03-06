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

<!-- main content -->

<div class="raw100">

    <div class="quarx-small-device">

        <p class="align-left">It looks like you already have Quarx installed. Are you looking to edit the current setup?</p>
        <br />

        <a data-role="button" data-theme="a" href="<?= site_url('admin/edit'); ?>">Edit Quarx Setup</a>

        <?php

            if ( ! isset($atomic) && ! @file_get_contents('../.atomic.json')) echo  '<a data-role="button" data-theme="a" href="'.site_url('admin/atomic').'">Add the Atomic Framework</a>';
            if ( ! isset($atomic) && @file_get_contents('../.atomic.json')) echo '<a data-role="button" data-theme="a" href="'.site_url('admin/connect').'">Connect to the Atomic Framework</a>';
            if (count(scandir('application/controllers/setup'))) echo '<a data-role="button" data-theme="a" href="'.site_url('admin/cleanup').'">Remove the Installer</a>';

        ?>

        <div class="raw-block-25 raw100"></div>

        <div class="raw100">
            <a data-role="button" data-theme="a" href="<?= site_url('login'); ?>">Return To Quarx</a>
        </div>

    </div>
</div>

<?php $this->carabiner->display("quarx-admin-js"); ?>

<?php /* End of File */ ?>