<?php /*
    Filename:   add.php
    Location:   /application/views/images/
    Author:     Matt Lantz
*/ ?>

<script type="text/javascript" src="<?php echo $root; ?>js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo $root; ?>js/jquery-ui.min.js"></script>
<link type="text/css" href="<?php echo $root; ?>css/jquery-ui.css" rel="stylesheet" />
<link type="text/css" href="<?php echo $root; ?>css/style.css" rel="stylesheet" />

<script type="text/javascript">
        
    function populatePictures(){
        $.ajax({
            type: "GET",
            url: "<?php echo site_url('pictures/image_feed/'.$plugin); ?>",
            dataType: "html",
            success: function(data){
                $('#imgBox').html(data);
            }
        });
    }

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
        populatePictures();
        
        <?php if(isset($_GET['error'])){ ?>
            feedback('error');
        <?php } ?>

        <?php if(isset($_GET['success'])){ ?>
            feedback('success');
        <?php } ?>
    });

</script>

<div id="imageError" class="errorBox">
    <p>Sorry, there was an error, your image may have been larger than 4MB and 1300px x 1300px</p>
</div>

<div id="imageSuccess" class="updateBox">
    <p>Upload Complete.</p>
</div>

<div class="wide_box align-center">

    <div class="refresh" onclick="window.location=window.location"></div>
    <br />
    <button onclick="window.location='<?php echo site_url('pictures/add/'.$plugin.'?type='.$type); ?>'" class="green buttons tall wide90" style="margin: 5px 0;">Upload an Image</button>    
    <div id="imgBox" class="wide_box"></div>

</div>


<!-- End of File -->