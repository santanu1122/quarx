<?php /*
    Filename:   add.php
    Location:   /application/views/images/
*/ ?>

<style type="text/css">

.dialogBox{
    min-width: 260px;
    max-width: 260px;
    top: 0;
    margin: 40px auto;
    position: absolute;
    z-index: 10000;
    background: #FFF;
    border: 1px solid #bbb;
    border-radius: 15px;
    box-shadow: 0 0 15px #111;
    display: none;
}

.dialogbox_header{
    width: 260px;
    background: #222;
    border-top-left-radius: 15px;
    border-top-right-radius: 15px;
    height: 50px;
    margin: -12px 0 0 0;
    text-align: center;
}

.dialogbox_body{
    padding: 0 20px 20px 20px;
}

.dialogbox_header h1{
    color: #FFF;
    line-height: 50px;
    font-size: 18px;
}

</style>

<div id="dialog-newColl" class="dialogBox" title="New Collection">
    <div class="dialogbox_body">
        <input onfocus="this.value=''" data-theme="a" id="collectionName" type="text" value="Collection Name" />
    </div>
</div>

<div id="imageError" class="errorBox">
    <p>Sorry, there was an error.</p>
</div>

<div id="imageSuccess" class="updateBox">
    <p>Upload Complete.</p>
</div>

<div class="raw100">
    
    <div class="raw100 align-center">
    
        <div class="align-center">
            <?php if(isset($error)){ foreach($error as &$item){ echo $item; } } ?>
            
            <a id="newCollection" href="#" data-role="button" data-icon="plus" data-theme="a" data-iconpos="notext"></a>

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

                <div id="state" class="raw100"><p>Uploading Image...</p></div>

        </div>  
    </div>  

</div>

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
        
        <?php if(isset($_GET['error'])){ ?>
            feedback('error');
        <?php } ?>

        <?php if(isset($_GET['success'])){ ?>
            feedback('success'); 
            $('#addImageForm').hide();
        <?php } ?>

        $('#newCollection').bind('click', function(){
            newCollectionBox();
        });

        $('#addImageForm').submit(function(){
            $('#addBtn').hide();
            $('#state').show();
        });

        populateCollections();
    });

</script>

<!-- End of File -->