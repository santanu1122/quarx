<?php /*
    Filename:   main.php
    Location:   /application/views/images/
*/ ?>

<div id="dialog-img" title="Delete Confirmation" class="dialogBox">
    <div class="dialogbox_body">
        <p>Are you sure you want to delete this image collection?</p>
    </div>
</div>

<div id="dialog-newColl" class="dialogBox" title="New Collection">
    <div class="dialogbox_body">
        <input onfocus="this.value=''" data-theme="a" id="collectionName" type="text" value="Collection Name" />
    </div>
</div>

<?php if(isset($_GET['error'])){ ?>
<div id="imageError" class="errorBox">
    <p>Sorry, there was an error, are you sure this collection is empty?</p>
</div>
<?php } ?>

<div class="raw100 align-center">
    <a id="newCollectionBtn" href="#" data-role="button" data-icon="plus" data-theme="a">New Collection</a>

    <?php foreach ($collection as $c) : ?>
        <a href="#" onclick="deleteMe(<?php echo $c->collection_id; ?>)" data-role="button" data-theme="e" data-icon="delete"><?php echo $c->collection_name; ?></a>
    <?php endforeach; ?>
</div>

<script type="text/javascript">

    function feedback(type) {
        if(type === "error"){
            $("#imageError").fadeIn();
            setTimeout(function(){ $("#imageError").fadeOut(); }, 2500);
        }else{
            $("#imageSuccess").fadeIn();
            setTimeout(function(){ $("#imageSuccess").fadeOut(); }, 2500);
        }
    }
    
    $(document).ready(function(e) {
        <?php if(isset($_GET['error'])){ ?>
            feedback('error');
        <?php } ?>

        <?php if(isset($_GET['success'])){ ?>
            feedback('success');
        <?php } ?>

        $('#newCollectionBtn').bind('click', function(){
            newCollectionBox();
        });
    });

    function newCollectionBox(){
        $( "#dialog-newColl" ).dialogboxInput({
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
                            window.location = "<?php echo site_url('image/manager'); ?>";
                        }
                    });
                },
                Cancel: function() {
                    inputDialogDestroy("#dialog-newColl");
                }
            }
        });
    }

    function deleteMe(id) {
        $( "#dialog-img" ).dialogboxInput({
            buttons: {
                Ok: function() {
                    $.ajax({
                        url: "<?php echo site_url('image/delete_collection'); ?>",
                        type: 'POST',
                        data: { idTag: id,
                                <?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>' 
                        },
                        success: function(msg) {
                            if(msg == 'true'){
                                window.location = "<?php echo site_url('image/manager'); ?>";   
                            }

                            if(msg == 'false'){
                                window.location = "<?php echo site_url('image/manager'); ?>"+"?error";   
                            }
                        }
                    });
                },
                Cancel: function() {
                    inputDialogDestroy( "#dialog-img" );
                }
            }
        });
    }

</script>

<!-- End of File -->