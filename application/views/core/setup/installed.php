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

<?php if(isset($_GET['v'])){ ?>
    <div id="msgBox" class="updateBox">
        <p>Your Quarx update was successful.</p>
    </div>
<?php } ?>

<?php if(isset($_GET['av'])){ ?>
    <div id="msgBox" class="updateBox">
        <p>You've successfully deployed the atomic framework.</p>
    </div>
<?php } ?>

<?php if(isset($_GET['d'])){ ?>
    <div id="msgBox" class="updateBox">
        <p>Your disconnect was successful.</p>
    </div>
<?php } ?>

<?php if(isset($_GET['e'])){ ?>
    <div id="msgBox" class="errorBox">
        <p>Your connecton was not successful.</p>
    </div>
<?php } ?>

<style type="text/css">
a.green:hover{
    color: #fff;
}
</style>

<div class="wide_box">

    <div class="wide300 centered">

        <h1>Quarx Setup.</h1>
        <br />
        <p class="align-left wide300">It looks like you already have Quarx installed. Are you looking to edit the current setup?</p>
        <br />
        <a class="button big padded10" href="<?php echo site_url('login'); ?>">Return To Quarx</a>
        <br />
        <a class="button big padded10" href="<?php echo site_url('setup/edit'); ?>">Edit Quarx Setup</a>
        <br />
        
        <?php if(file_get_contents('../.atomic.json')){ ?>
        <a class="button big <?php if($plugin_updates_available == false){ echo 'padded10'; }else{ echo 'green'; } ?>"  <?php if($plugin_updates_available == true){ echo 'style="padding: 8px 3px;"'; } ?>  href="<?php echo site_url('setup/plugins'); ?>">
            <?php if($plugin_updates_available == false){ echo ''; }else{ echo 'Update '; } ?>Quarx Plugins</a>
        <br />
        <?php } ?>
        
        <?php if(!isset($atomic) && !file_get_contents('../.atomic.json')){ ?>
        <a class="button big padded10" href="<?php echo site_url('setup/deploy_atomic'); ?>">Add the Atomic Framework</a>
        <br />
        <?php } ?>

        <?php if(!isset($atomic) && file_get_contents('../.atomic.json')){ ?>
        <a class="button big padded10" href="<?php echo site_url('setup/connect_to_atomic'); ?>">Connect to the Atomic Framework</a>
        <br />
        <?php } ?>
        
        <?php if($latest_quarx_version > $current_quarx_version){ ?>
        <a class="button big green" style="padding: 8px 3px;" href="<?php echo site_url('setup/update'); ?>">Update Quarx</a>
        <?php } ?>
    </div>

</div>
    
<?php /* End of File */ ?>