<?php

/**
 * Quarx
 *
 * A modular CMS built on CodeIgniter
 *
 * @package     Quarx
 * @author      Matt Lantz
 * @copyright   Copyright (c) 2013 Matt Lantz
 * @license     http://ottacon.co/quarx/license
 * @link        http://quarx.ottacon.co
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

<!-- notifications -->

<div id="quarx-msg-box" class="<?php echo $state; ?>">
    <p><?php echo $message; ?></p>
</div>

<!-- main content -->

<?php $this->load->view("core/image/common/menu"); ?>

<div class="quarx-img-box">
    
    <div class="raw100 align-center">
    
        <div class="align-center">
            <?php if(isset($error)){ foreach($error as &$item){ echo $item; } } ?>
            
            <a id="quarx-new-collection-change" href="#" data-role="button" data-icon="plus" data-theme="a" data-iconpos="notext"></a>

            <form id="addImageForm" action="<?php echo site_url('image/change_collection'); ?>" method="post" enctype="multipart/form-data">
                <input type="hidden" name="imageId" value="<?php echo $imageId; ?>" />
 
                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />

                <select id="collections" data-theme="a" name="collections">
                    <option value="0">Collections</option>
                    <!-- place other collections here -->
                </select>

                <input data-theme="c" type="submit" value="Update Collection" />
            </form>

        </div>  
    </div>  

</div>

<!-- javascript -->

<script type="text/javascript">

    function populateCollections(){
        $.ajax({
            url: "<?php echo site_url('image/get_collections'); ?>",
            type: 'GET',
            cache: false,
            dataType: 'html',
            success: function(data) {
                $('#collections').html(data).selectmenu('refresh', true);
            }
        });
    }

    function newCollectionBox(){
        $( "#dialog-newColl" ).dialogboxInput({
            web_link: false,
            buttons: {
                Ok: function() {
                    $.ajax({
                        url: "<?php echo site_url('image/new_collection'); ?>",
                        type: 'POST',
                        cache: false,
                        data: { 
                            collection_name: $('#collectionName').val(),
                            <?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>'
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
        $("#quarx-msg-box").fadeIn().delay(2500).fadeOut("slow");

        $('input:submit').button();

        $('#quarx-new-collection-change').bind('click', function(){
            newCollectionBox();
        });

        populateCollections();
    });

</script>

<!-- End of File -->