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

<!-- dialogs -->

<div id="dialog-img" title="Delete Confirmation" class="dialogBox">
    <div class="dialogbox_body">
        <p>Are you sure you want to delete this image?</p>
    </div>
</div>

<div id="dialog-alt" title="Image Manager" class="dialogBox">
    <div class="dialogbox_body">
        <a href="#" onclick="changeMe()" data-role="button" data-theme="d">Change Collection</a>
        <a href="#" onclick="viewFull()" data-role="button" data-theme="d">View This Image</a>
        <input class="deefault" id="pic_alt_tag" data-deefault="Alt Tag" />
        <input class="deefault" id="pic_title_tag" data-deefault="Title Tag" />
    </div>
</div>

<div id="dialog-update-alt" title="Image Manager" class="dialogBox">
    <div class="dialogbox_body">
        <a href="#" onclick="changeMe()" data-role="button" data-theme="d">Change Collection</a>
        <a href="#" onclick="viewFull()" data-role="button" data-theme="d">View This Image</a>
        <input id="update_pic_alt_tag" value="" />
        <input id="update_pic_title_tag" value="" />
    </div>
</div>

<!-- content -->

<div class="raw100 raw-left">
    <div class="quarx-device">
        <div class="raw100 raw-left">
            <div class="raw100 raw-left">
                <div class="quarx-img-box">
                    <?php $this->load->view("core/images/common/menu"); ?>
                    <select id="collections" data-theme="a">
                        <!-- populated by ajax -->
                    </select>
                </div>
            </div>
            <div class="raw100 raw-left library-container raw-margin-top-40">
                <!-- populated by ajax -->
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

    var _collectionID = "<?= $img_collection_id ?: 'null'; ?>",
        _collectionAppend = true;

</script>

<?php $this->carabiner->display("quarx-images-js"); ?>

<!-- End of File -->