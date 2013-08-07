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

<div class="raw100">
    <div id="quarx-msg-box" class="<?php echo $state; ?>">
        <p><?php echo $message; ?></p>
    </div>
</div> 

<!-- main content -->

<?php $this->load->view("core/image/common/menu"); ?>

<div class="quarx-img-box">
    
    <div class="raw100 align-center">
    
        <div class="align-center">
            <?php if(isset($error)){ foreach($error as &$item){ echo $item; } } ?>
            
            <a id="quarx-new-collection" href="#" data-role="button" data-icon="plus" data-theme="a" data-iconpos="notext"></a>

            <p>Please select an image to upload</p>

            <form id="addImageForm" action="<?php echo site_url('image/add_image'); ?>" method="post" enctype="multipart/form-data">
                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                
                <input type="file" name="userfile" size="30" data-role="none" style="margin-bottom: 30px;" />

                <select id="collections" name="collection" data-theme="a">
                    <option value="0">Collections</option>
                    <!-- place other collections here -->
                </select>

                <input id="addBtn" data-theme="c" type="submit" value="Upload" />
            </form>

                <div id="quarx-state" class="raw100"><p>Uploading Image...</p></div>

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
        
        $("#quarx-msg-box").show().delay(2500).fadeOut("slow");

        $('#quarx-new-collection').bind('click', function(){
            newCollectionBox();
        });

        $('#addImageForm').submit(function(){
            $('#addBtn').hide();
            $('#quarx-state').show();
        });

        populateCollections();
    });

</script>

<!-- End of File -->