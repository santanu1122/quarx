<?php /*
    Filename:   img_feed.php
    Location:   /application/views/images/
*/ ?>

<script type="text/javascript" src="<?php echo $root; ?>js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo $root; ?>js/jquery-ui.min.js"></script>
<script type="text/javascript" src="<?php echo $root; ?>js/quarxfunc.js"></script>
<link rel="stylesheet" href="<?php echo site_url(); ?>css/style.css" lang="EN" dir="ltr" rel="stylesheet" >
<link rel="stylesheet" href="<?php echo site_url(); ?>css/jquery-ui.css" lang="EN" dir="ltr" rel="stylesheet" >

<script type="text/javascript">

    $(document).ready(function() {
        $('.draggable').draggable();
        $('.droppable').droppable(); 
        setTimeout(function(){ thumbnailImageResize(); }, 150);
    });

    function deleteMe(id, plugin) {
        $( "#dialog:ui-dialog" ).dialog( "destroy" );
    
        $( "#dialog-img" ).dialog({
            modal: true,
            buttons: {
                Ok: function() {
                    $.ajax({
                        url: "<?php echo site_url('pictures/delete_img'); ?>",
                        type: 'GET',
                        data: 'id='+id+'&plugin='+plugin,
                        success: function(msg) {
                            <?php if($type !== 'embeded'){ ?>    
                            window.location="<?php echo site_url('pictures?type=slider&plugin='); ?>"+plugin;
                            <?php }else{ ?>
                            window.location=window.location;
                            <?php } ?>
                        }
                    });
                },
                Cancel: function() {
                    $( this ).dialog( "close" );
                }
            }
        });
    }

    function setTags(id) {
        $( "#dialog:ui-dialog" ).dialog( "destroy" );
    
        $( "#dialog-alt" ).dialog({
            modal: true,
            buttons: {
                Save: function() {
                    var alt = $('#pic_alt_tag').val(),
                        title = $('#pic_title_tag').val();

                    $.ajax({
                        url: "<?php echo site_url('pictures/set_alt_title'); ?>",
                        type: 'POST',
                        data: { pic_id: id, pic_alt: alt, pic_title: title, <?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>' },
                        success: function(msg) {
                            $('#dialog-alt').dialog( "destroy" );
                            $('#'+id).attr('onclick', 'updateTags('+id+')');
                            <?php if($type === 'embeded'){ ?>
                            window.location = window.location;
                            <?php }else{ ?>
                            populatePictures();
                            <?php } ?>
                        }
                    });
                },
                Cancel: function() {
                    $( this ).dialog( "close" );
                }
            }
        });
    }

    function updateTags(id) {
        var alt = $('#pic_alt_tag').val(),
            title = $('#pic_title_tag').val();

            $.ajax({
                url: "<?php echo site_url('pictures/get_alt_title'); ?>",
                type: 'GET',
                data: { pic_id: id },
                success: function(data) {
                    var imgDetails = jQuery.parseJSON(data),
                        current_alt = imgDetails.alt_tag,
                        current_title = imgDetails.title_tag;
                    
                    $('#update_pic_alt_tag').val(current_alt);
                    $('#update_pic_title_tag').val(current_title);

                    $( "#dialog:ui-dialog" ).dialog( "destroy" );
    
                    $( "#dialog-update-alt" ).dialog({
                        modal: true,
                        buttons: {
                            Save: function() {
                                var alt = $('#update_pic_alt_tag').val(),
                                    title = $('#update_pic_title_tag').val();

                                $.ajax({
                                    url: "<?php echo site_url('pictures/set_alt_title'); ?>",
                                    type: 'POST',
                                    data: { pic_id: id, pic_alt: alt, pic_title: title, <?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>' },
                                    success: function(msg) {
                                        $('#'+id).attr('onclick', 'updateTags('+id+')');
                                        $('#dialog-update-alt').dialog( "destroy" );

                                        <?php if($type === 'embeded'){ ?>
                                        window.location = window.location;
                                        <?php }else{ ?>
                                        populatePictures();
                                        <?php } ?>
                                    }
                                });
                            },
                            Cancel: function() {
                                $( this ).dialog( "close" );
                            }
                        }
                    });
                }
            });

        
    }

</script>

<div id="dialog-img" title="Delete Confirmation" style="display: none;">
    <p>Are you sure you want to delete this image?</p>
</div>

<div id="dialog-alt" title="Alt and Title Tags" style="display: none;">
    <input id="pic_alt_tag" value="Alt Tag" style="width: 90%; padding: 4px; margin-left: 12px;" />
    <input id="pic_title_tag" value="Title Tag" style="width: 90%; padding: 4px; margin-left: 12px;" />
</div>

<div id="dialog-update-alt" title="Edit Alt and Title Tags" style="display: none;">
    <input id="update_pic_alt_tag" value="" style="width: 90%; padding: 4px; margin-left: 12px;" />
    <input id="update_pic_title_tag" value="" style="width: 90%; padding: 4px; margin-left: 12px;" />
</div>

<div class="wide_box" style="width: 575px; margin: 0 auto;">
    <?php if($type !== 'embeded'){ ?> 
    <div class="padded10">
    <?php } ?>

        <?php if(count($image) === 0){ ?>
            <h1 id="add_img_text" class="muted" style="text-align: center; margin: 100px auto 0px;">Add Images</h1>
        <?php } ?>

        <?php foreach($image as $pic): ?>
                            
            <div class="quartre_box">
                <div class="imgThumbHolder">
                    <div class="delBox" onclick="deleteMe(<?php echo $pic->img_id; ?>, '<?php echo $plugin; ?>', '<?php echo $type; ?>')">
                        <span class="ui-icon ui-icon-closethick"></span>
                    </div>
                    <div class="thumbShot">
                        <img onclick="<?php if($pic->img_alt_tag == ''){ echo 'setTags('.$pic->img_id.')'; }else{ echo 'updateTags('.$pic->img_id.')'; } ?>" id="<?php echo $pic->img_id ?>" src="<?php echo $pic->img_thumb_location; ?>" alt="<?php echo $pic->img_alt_tag; ?>" title="<?php echo $pic->img_title_tag; ?>" />
                    </div>
                </div>
            </div>
        
        <?php endforeach; ?>

    <?php if($type !== 'embeded'){ ?> 
    </div>
    <?php } ?>
</div>