<?php /*
    Filename:   installed.php
    Location:   /application/views/core/setup
*/ ?>

<script type="text/javascript">
    $(document).ready(function(){
        $('#msgBox').fadeIn();
        setTimeout(function(){ $('#msgBox').fadeOut(); }, 2200);    
    });
</script>

<?php if(isset($_GET['s'])){ ?>
    <div id="msgBox" class="updateBox">
        <p>Your connection was successful.</p>
    </div>
<?php } ?>

<?php if(isset($_GET['av'])){ ?>
    <div id="msgBox" class="updateBox">
        <p>You've successfully deployed the atomic framework.</p>
    </div>
<?php } ?>

<?php if(isset($_GET['e'])){ ?>
    <div id="msgBox" class="errorBox">
        <p>Your connecton was not successful.</p>
    </div>
<?php } ?>

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

    <a data-role="button" data-theme="a" href="<?php echo site_url('login'); ?>">Return To Quarx</a>

</div>
    
<?php /* End of File */ ?>