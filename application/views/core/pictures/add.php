<?php /*
    Filename:   add.php
    Location:   /application/views/images/
    Author:     Matt Lantz
*/ ?>

<script type="text/javascript" src="<?php echo $root; ?>js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo $root; ?>js/jquery-ui.min.js"></script>
<link type="text/css" href="<?php echo $root; ?>css/jquery-ui.css" lang="EN" dir="ltr" rel="stylesheet" />
<link type="text/css" href="<?php echo $root; ?>css/style.css" lang="EN" dir="ltr" rel="stylesheet" />

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
    
    $(document).ready(function(e) {
        $('input:submit').button();
        
        <?php if(isset($_GET['error'])){ ?>
            feedback('error');
        <?php } ?>

        <?php if(isset($_GET['success'])){ ?>
            feedback('success'); 
            $('#addImageForm').hide();
        <?php } ?>
    });

</script>

<div id="imageError" class="errorBox">
    <p>Sorry, there was an error.</p>
</div>

<div id="imageSuccess" class="updateBox">
    <p>Upload Complete.</p>
</div>

<div class="wide_box">
    
    <div class="wide_box" style="text-align: center;">
    
        <div class="align-center">
            <?php if(isset($error)){ foreach($error as &$item){ echo $item; } } ?>
            
            <div class="wide_box" style="background: #333; margin-bottom: 40px;">
                <h1 style="line-height: 50px; color: #fff;">Select an image to upload</h1>
            </div>

            <form id="addImageForm" action="<?php echo site_url('pictures/add_image/'.$plugin); ?>" method="post" enctype="multipart/form-data">
                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                
                <input type="file" name="userfile" size="30" style="margin-bottom: 50px;" />
                
                <?php if( isset($_GET['galid']) ){ ?>
                <input type="hidden" name="galid" value="<?php echo $_GET['galid']; ?>" />
                <?php } ?>

                <input type="hidden" name="type" value="<?php echo $_GET['type']; ?>" />

                <br />
                <input class="green wide100" type="submit" value="Upload" />
            </form>

            <!-- <button onclick="window.history.back()" class="red buttons wide100">Cancel</button> -->

        </div>  
    </div>  

</div>

<!-- End of File -->