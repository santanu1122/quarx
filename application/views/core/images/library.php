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
        <input id="pic_alt_tag" value="Alt Tag" />
        <input id="pic_title_tag" value="Title Tag" />
    </div>
</div>

<div id="dialog-update-alt" title="Image Manager" class="dialogBox">
    <div class="dialogbox_body">
        <a href="#" onclick="changeMe()" data-role="button" data-theme="d">Change Collection</a>
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
                        <?php

                            if ( ! isset($img_collection_name)) echo '<option value="0">Collections</option>';
                            else echo '<option value="'.$this->crypto->encrypt($img_collection_id).'">Viewing: '.$img_collection_name.'</option>';

                        ?>
                    </select>
                </div>
            </div>
            <div class="raw100 raw-left library-container">

                <!-- populated by ajax -->

            </div>
        </div>
    </div>
</div>

<!-- javascript -->

<script type="text/javascript">

    function deleteMe(id, plugin) {
        $( "#dialog-img" ).dialogboxInput({
            buttons: {
                Ok: function() {
                    $.ajax({
                        url: "<?= site_url('images/delete_img'); ?>",
                        type: 'GET',
                        data: 'id='+id,
                        success: function(msg) {
                            loadImages("<?= $img_collection_id ?: 'null'; ?>");
                        }
                    });
                },
                Cancel: function() {
                    inputDialogDestroy( "#dialog-img" );
                }
            }
        });
    }

    function setTags(id) {
        $('#dialog-alt').attr('data-imageId', id);

        $( "#dialog-alt" ).dialogboxInput({
            web_link: $('#'+id).attr('data-web-link'),
            buttons: {
                Ok: function() {
                    var alt = $('#pic_alt_tag').val(),
                        title = $('#pic_title_tag').val();

                    $.ajax({
                        url: "<?= site_url('images/set_alt_title'); ?>",
                        type: 'POST',
                        data: { pic_id: id, pic_alt: alt, pic_title: title, <?= $this->security->get_csrf_token_name(); ?>: '<?= $this->security->get_csrf_hash(); ?>' },
                        success: function(msg) {
                            inputDialogDestroy( "#dialog-alt" );

                            $('#'+id).attr('onclick', 'updateTags('+id+')');

                            $('#dialog-alt').attr('data-imageId', '');

                            loadImages("<?= $img_collection_id ?: 'null'; ?>");
                        }
                    });
                },
                Cancel: function() {
                    $('#dialog-alt').attr('data-imageId', '');
                    inputDialogDestroy( "#dialog-alt" );
                }
            }
        });
    }

    function updateTags(id) {
        var alt = $('#pic_alt_tag').val(),
            title = $('#pic_title_tag').val();

        $.ajax({
            url: "<?= site_url('images/get_alt_title'); ?>",
            type: 'GET',
            data: { pic_id: id },
            success: function(data) {
                var imgDetails = jQuery.parseJSON(data),
                    current_alt = imgDetails.alt_tag,
                    current_title = imgDetails.title_tag;

                $('#update_pic_alt_tag').val(current_alt);
                $('#update_pic_title_tag').val(current_title);

                $('#dialog-update-alt').attr('data-imageId', id);

                $( "#dialog-update-alt" ).dialogboxInput({
                    web_link: $('#'+id).attr('data-web-link'),
                    buttons: {
                        Ok: function() {
                            var alt = $('#update_pic_alt_tag').val(),
                                title = $('#update_pic_title_tag').val();

                            $.ajax({
                                url: "<?= site_url('images/set_alt_title'); ?>",
                                type: 'POST',
                                data: { pic_id: id, pic_alt: alt, pic_title: title, <?= $this->security->get_csrf_token_name(); ?>: '<?= $this->security->get_csrf_hash(); ?>' },
                                success: function(msg) {
                                    console.log(msg);
                                    $('#'+id).attr('onclick', 'updateTags('+id+')');

                                    inputDialogDestroy( "#dialog-update-alt" );

                                    $('#dialog-update-alt').attr('data-imageId', '');

                                    loadImages("<?= $img_collection_id ?: 'null'; ?>");
                                }
                            });
                        },
                        Cancel: function() {
                            $('#dialog-update-alt').attr('data-imageId', '');
                            inputDialogDestroy( "#dialog-update-alt" );
                        }
                    }
                });
            }
        });
    }

    function changeMe() {
        if($('#dialog-update-alt').attr('data-imageId') > ''){
            window.location = "<?= site_url('images/change'); ?>"+"/"+$('#dialog-update-alt').attr('data-imageId');
        }

        if($('#dialog-alt').attr('data-imageId') > ''){
            window.location = "<?= site_url('images/change'); ?>"+"/"+$('#dialog-alt').attr('data-imageId');
        }
    }

    function populateCollections() {
        $.ajax({
            url: "<?= site_url('images/get_collections'); ?>",
            type: 'GET',
            cache: false,
            dataType: 'html',
            success: function(data) {
                $('#collections').append(data).selectmenu('refresh', true);
            }
        });
    }

    function loadImages(collectionId) {
        $.ajax({
            url: "<?= site_url('images/get_collection_images'); ?>/"+collectionId,
            type: 'GET',
            cache: false,
            dataType: 'html',
            success: function(data) {
                $('.library-container').html(data);
                setTimeout(function(){ quarxThumbnailImageResize(); }, 150);
            }
        });
    }

    $(document).ready(function() {
        populateCollections();
        loadImages("<?= $img_collection_id ?: 'null'; ?>");

        $('#collections').bind('change', function(){
            var collectionId = $(this).val();
            window.location = '<?= site_url("images/library"); ?>'+'/'+collectionId;
        });
    });

</script>

<!-- End of File -->