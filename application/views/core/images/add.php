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

<div id="dialog-newColl" class="dialogBox" title="New Collection">
    <div class="dialogbox_body">
        <input onfocus="this.value=''" data-theme="a" id="collectionName" type="text" value="Collection Name" />
    </div>
</div>

<!-- main content -->

<div class="quarx-img-box">

    <div class="raw100 raw-left align-center">

        <div id="image_upload_box" class="quarx-align-center">

            <?php $this->load->view("core/images/common/menu"); ?>

            <a id="quarx-new-collection" href="#" data-role="button" data-icon="plus" data-theme="a">New Collection</a>

            <p>Please select an image to upload</p>

            <form id="addImageForm" action="<?= site_url('images/add_image'); ?>" method="post" enctype="multipart/form-data">
                <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>" />
                <input type="file" name="userfile" />

                <p>Then select a Collection</p>

                <select id="collections" name="collection" data-theme="a">
                    <!-- place other collections here -->
                </select>

                <input id="addBtn" data-theme="c" type="submit" value="Upload" />
            </form>

        </div>

    </div>

</div>

<script type="text/javascript">

    var _collectionID = 'null',
    _quarxCollectionManager = false;

</script>

<?php $this->carabiner->display("quarx-images-js"); ?>

<!-- End of File -->