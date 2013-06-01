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

<!-- notifcations -->

<div id="imageError" class="errorBox">
    <p>Sorry, there was an error, your image may have been larger than 4MB and 1300px x 1300px</p>
</div>

<div id="imageSuccess" class="updateBox">
    <p>Upload Complete.</p>
</div>

<!-- main content -->

<div class="raw100 align-center">
    <a href="<?php echo site_url('image/add'); ?>" data-theme="a" data-role="button">Upload an Image</a>
    <a href="<?php echo site_url('image/collections'); ?>" data-theme="a" data-role="button">View Collections</a> 
    <a href="<?php echo site_url('image/manager'); ?>" data-theme="a" data-role="button">Manage Collections</a>
</div>

<!-- javascript -->

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
    });

</script>

<!-- End of File -->