<?php /*
    Filename:   img_feed.php
    Location:   /application/views/images/
*/ ?>

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

<div class="raw100">
    <select id="collections" data-theme="a">
        <?php if(isset($img_collection_name)){ ?>
            <option value="<?php echo $img_collection_id; ?>">Viewing: <?php echo $img_collection_name; ?></option>
        <?php }else{ ?>
            <option value="0">Collections</option>
        <?php } ?>
    </select>
</div>

<div class="imgCollectionBox">

        <?php if(count($image) === 0){ ?>
            <h1 id="add_img_text" class="muted" style="text-align: center; margin: 100px auto 0px;">Add Images</h1>
        <?php } ?>

        <?php foreach($image as $pic): ?>
                            
            <div class="imageBox">
                <div class="imgThumbHolder">
                    <div class="delBox" onclick="deleteMe(<?php echo $pic->img_id; ?>)">
                        <span class="delIcon"></span>
                    </div>
                    <div class="thumbShot">
                        <img data-web-link="<?php echo $pic->img_medium_location; ?>" onclick="<?php if($pic->img_alt_tag == ''){ echo 'setTags('.$pic->img_id.')'; }else{ echo 'updateTags('.$pic->img_id.')'; } ?>" id="<?php echo $pic->img_id ?>" src="<?php echo $pic->img_thumb_location; ?>" alt="<?php echo $pic->img_alt_tag; ?>" title="<?php echo $pic->img_title_tag; ?>" />
                    </div>
                </div>
            </div>
        
        <?php endforeach; ?>

</div>

<script type="text/javascript">

    $(document).ready(function() { 
        setTimeout(function(){ thumbnailImageResize(); }, 450);
        populateCollections();

        $('#collections').bind('change', function(){
            var collectionId = $(this).val();
            window.location = '<?php echo site_url("image/collections"); ?>'+'/'+collectionId;
        });
    });

    function deleteMe(id, plugin) {
        $( "#dialog-img" ).dialogboxInput({
            buttons: {
                Ok: function() {
                    $.ajax({
                        url: "<?php echo site_url('image/delete_img'); ?>",
                        type: 'GET',
                        data: 'id='+id,
                        success: function(msg) {
                            window.location=window.location;
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
                        url: "<?php echo site_url('image/set_alt_title'); ?>",
                        type: 'POST',
                        data: { pic_id: id, pic_alt: alt, pic_title: title, <?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>' },
                        success: function(msg) {
                            inputDialogDestroy( "#dialog-alt" );

                            $('#'+id).attr('onclick', 'updateTags('+id+')');

                            $('#dialog-alt').attr('data-imageId', '');

                            window.location = window.location;
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
            url: "<?php echo site_url('image/get_alt_title'); ?>",
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
                                url: "<?php echo site_url('image/set_alt_title'); ?>",
                                type: 'POST',
                                data: { pic_id: id, pic_alt: alt, pic_title: title, <?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>' },
                                success: function(msg) {
                                    $('#'+id).attr('onclick', 'updateTags('+id+')');
                                    
                                    inputDialogDestroy( "#dialog-update-alt" );

                                    $('#dialog-update-alt').attr('data-imageId', '');

                                    window.location = window.location;
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

    function changeMe(){
        if($('#dialog-update-alt').attr('data-imageId') > ''){
            window.location = "<?php echo site_url('image/change'); ?>"+"/"+$('#dialog-update-alt').attr('data-imageId');
        }

        if($('#dialog-alt').attr('data-imageId') > ''){
            window.location = "<?php echo site_url('image/change'); ?>"+"/"+$('#dialog-alt').attr('data-imageId');
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

</script>