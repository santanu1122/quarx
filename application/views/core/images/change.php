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

<div id="dialog-newColl" class="dialogBox" title="New Collection">
    <div class="dialogbox_body">
        <input onfocus="this.value=''" data-theme="a" id="collectionName" type="text" value="Collection Name" />
    </div>
</div>

<!-- main content -->

<?php $this->load->view("core/images/common/menu"); ?>

<div class="quarx-img-box">

    <div class="raw100 raw-left align-center">
        <div class="align-center">
            <a id="quarx-new-collection" href="#" data-role="button" data-icon="plus" data-theme="a">New Collection</a>

            <form id="addImageForm" action="<?= site_url('images/change_collection'); ?>" method="post" enctype="multipart/form-data">
                <input type="hidden" name="imageId" value="<?= $this->crypto->encrypt($imageId); ?>" />
                <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>" />

                <select id="collections" data-theme="a" name="collections">
                    <option value="0">Collections</option>
                    <!-- place other collections here -->
                </select>
                <div class="raw100 raw-left">
                    <input data-theme="c" type="submit" value="Update Collection" />
                </div>
            </form>

        </div>
    </div>

</div>

<script type="text/javascript">

    var _collectionID = 'null';

</script>

<?php $this->carabiner->display("quarx-images-js"); ?>

<!-- End of File -->