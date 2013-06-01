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

<div id="imageError" class="errorBox">
    <p>Sorry, there was an error.</p>
</div>

<div id="imageSuccess" class="updateBox">
    <p>Upload Complete.</p>
</div>

<!-- main content -->

<div class="raw100">
    
    <div class="raw100 align-center">
    
        <div class="align-center">
            <?php if(isset($error)){ foreach($error as &$item){ echo $item; } } ?>
            
            <a id="newCollectionChange" href="#" data-role="button" data-icon="plus" data-theme="a" data-iconpos="notext"></a>

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

    function feedback(type) {
        if(type === "error"){
            $("#imageError").fadeIn();
            setTimeout(function(){ $("#imageError").fadeOut(); }, 2500);
        }else{
            $("#imageSuccess").fadeIn();
            setTimeout(function(){ $("#imageSuccess").fadeOut(); parent.closeIFrame(); $('#addImageForm').show(); }, 2500);
        }
    }

    function populateCollections(){
        $.ajax({
            url: "<?php echo site_url('image/get_collections'); ?>",
            type: 'GET',
            cache: false,
            dataType: 'html',
            success: function(data) {
                $('#collections').append(data).selectmenu('refresh', true);
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
        $('input:submit').button();
        
        <?php if(isset($_GET['error'])){ ?>
            feedback('error');
        <?php } ?>

        <?php if(isset($_GET['success'])){ ?>
            feedback('success'); 
            $('#addImageForm').hide();
        <?php } ?>

        $('#newCollectionChange').bind('click', function(){
            newCollectionBox();
        });

        populateCollections();
    });

</script>

<!-- End of File -->