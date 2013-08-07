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

<!-- notifications -->

<div id="quarx-msg-box" class="<?php echo $status; ?>">
    <p><?php echo $message; ?></p>
</div>

<!-- main content -->

<div class="raw100">

    <p class="align-left">It looks like you already have Quarx installed. Are you looking to edit the current setup?</p>
    <br />

    <a data-role="button" data-theme="a" href="<?php echo site_url('setup/edit'); ?>">Edit Quarx Setup</a>
    
    <?php if(!isset($atomic) && !@file_get_contents('../.atomic.json')){ ?>
    <a data-role="button" data-theme="a"  href="<?php echo site_url('setup/deploy_atomic'); ?>">Add the Atomic Framework</a>
    <?php } ?>

    <?php if(!isset($atomic) && @file_get_contents('../.atomic.json')){ ?>
    <a data-role="button" data-theme="a" href="<?php echo site_url('setup/connect_to_atomic'); ?>">Connect to the Atomic Framework</a>
    <?php } ?>

    <div class="raw-block-25 raw100"></div>

    <div class="raw100">
        <a data-role="button" data-theme="a" href="<?php echo site_url('login'); ?>">Return To Quarx</a>
    </div>
</div>

<!-- javascript -->

<script type="text/javascript">
    $(document).ready(function(){
        $('#quarx-msg-box').fadeIn();
        setTimeout(function(){ $('#quarx-msg-box').fadeOut(); }, 2200);    
    });
</script>
    
<?php /* End of File */ ?>