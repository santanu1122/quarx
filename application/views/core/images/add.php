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

<!-- javascript -->

<script type="text/javascript">

    function populateCollections(){
        $.ajax({
            url: "<?= site_url('images/get_collections'); ?>",
            type: 'GET',
            cache: false,
            dataType: 'html',
            success: function(data) {
                var optional = '<option value="0">Collections (Optional)</option>';
                $('#collections').html(optional+data).selectmenu('refresh', true);
            }
        });
    }

    function newCollectionBox(){
        $( "#dialog-newColl" ).dialogboxInput({
            web_link: false,
            buttons: {
                Ok: function() {
                    $.ajax({
                        url: "<?= site_url('images/new_collection'); ?>",
                        type: 'POST',
                        cache: false,
                        data: {
                            collection_name: $('#collectionName').val(),
                            <?= $this->security->get_csrf_token_name(); ?>: '<?= $this->security->get_csrf_hash(); ?>'
                        },
                        success: function(data) {
                            inputDialogDestroy("#dialog-newColl");
                            populateCollections();
                        }
                    });
                },
                Cancel: function() {
                    inputDialogDestroy("#dialog-newColl");
                }
            }
        });
    }

    $(document).ready(function(e) {
        $('#quarx-new-collection').bind('click', function(){
            newCollectionBox();
        });

        $('#addBtn').click(function(){
            _quarx_loading();
        });

        populateCollections();
    });

</script>

<!-- End of File -->