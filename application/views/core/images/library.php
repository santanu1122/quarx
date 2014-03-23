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
        <div class="raw25 raw-left">
            <?php $this->load->view("core/images/common/menu"); ?>
        </div>
        <div class="raw2 raw-left raw-block-10 mHide"></div>
        <div class="raw73 raw-left">
            <div class="raw100 raw-left">
                <div class="quarx-img-box">
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