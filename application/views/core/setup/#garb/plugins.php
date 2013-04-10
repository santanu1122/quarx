<?php /*
    Filename:   plugins.php
    Location:   /application/views/core/setup
*/ ?>

<script type="text/javascript">
    $(document).ready(function(){
        $('#msgBox').fadeIn();
        setTimeout(function(){ $('#msgBox').fadeOut(); }, 2200);

        $("a.delete").click(function(event) {
            event.preventDefault();
            deletePlugin($(this).attr('href'));

        });
    });

    function deletePlugin(location){
        $( "#dialog:ui-dialog" ).dialog( "destroy" );
    
        $( "#dialog-plugin" ).dialog({
            modal: true,
            buttons: {
                Ok: function() {
                    window.location = location;
                },
                Cancel: function() {
                    $( this ).dialog( "close" );
                }
            }
        });
    }
</script>

<style type="text/css">
    .half_buttons{
        padding: 5px 0;
    }

    .red.half_buttons:hover, .green.half_buttons:hover{
        color: #eee;
    }
</style>

<?php if(isset($_GET['i'])){ ?>
    <div id="msgBox" class="updateBox">
        <p>Your installation was successful.</p>
    </div>
<?php } ?>

<?php if(isset($_GET['us'])){ ?>
    <div id="msgBox" class="updateBox">
        <p>Your plugin update was successful.</p>
    </div>
<?php } ?>

<?php if(isset($_GET['u'])){ ?>
    <div id="msgBox" class="updateBox">
        <p>Your uninstallation was successful.</p>
    </div>
<?php } ?>

<?php if(isset($_GET['e'])){ ?>
    <div id="msgBox" class="errorBox">
        <p>Your installation was not successful.</p>
    </div>
<?php } ?>

<?php if(isset($_GET['eu'])){ ?>
    <div id="msgBox" class="errorBox">
        <p>Your plugin update was not successful.</p>
    </div>
<?php } ?>

<div id="dialog-plugin" title="Delete Confirmation" style="display: none;">
    <p>Are you sure you want to delete this plugin? All information will be lost.</p>
</div>

<div class="wide_box">

    <div class="wide300 centered">
        <h1>Plugin Manager</h1>
        <br />
        <p class="align-left wide300">Looking to add some dynamic plugins to Quarx? Please select from the available plugins below.</p>
        <br />
        <br />
    </div>

</div>
<div style="width: 900px; margin: 0 auto; clear: both;">
    <div class="half_box">
        <?php foreach ($plugin as $item) : ?>
            <?php $menu_array .= $item->plugin_name.'-'.$plugin->plugin_id_tag.', '; ?>
        <?php endforeach; ?>

        <h2>Available Plugins</h2>
            <br />
            <br />
            <br />
        <?php foreach ($available_plugin as $item) : ?>
            <?php if(!strstr($menu_array, $item->plugin_name.'-'.$item->plugin_id_tag)){ ?>
                
            <div class="gridrow">
                <?php if($item->plugin_name == 'members'){ ?>
                    <a class="button half_buttons green" href="<?php echo site_url('install/members'); ?>">Install Members</a>
                <?php }else{ ?>
                    <a class="button half_buttons green" href="<?php echo site_url('install/plugin/'.$item->plugin_name.'/'.$item->id); ?>">Install <?php echo $item->plugin_title ?></a>
                <?php } ?>
            </div>
                
            <?php }?>
                
        <?php endforeach; ?>

    </div>
    <div class="half_box">
        <h2>Currently Installed Plugins</h2>
        <br />
        <div class="gridrow">
            <div class="grid33">    
                <h2>Disable/Enable</h2>
            </div>
            <div class="grid33">    
                <h2>Uninstall</h2>
            </div>
            <div class="grid33">    
                <h2>Update</h2>
            </div>
        </div>
        <?php foreach ($plugin as $item) : ?>
            <div class="gridrow">
                <?php if($item->plugin_active == 'yes'){ ?>
                <div class="grid33">
                    <a class="button half_buttons yellow" style="width: 96%;" href="<?php echo site_url('install/disable/'.$item->plugin_name); ?>"><?php echo $item->plugin_title ?></a>
                </div>
                <?php }else{ ?>
                <div class="grid33">
                    <a class="button half_buttons green" style="width: 96%;" href="<?php echo site_url('install/enable/'.$item->plugin_name); ?>"><?php echo $item->plugin_title ?></a>
                </div>
                <?php } ?>
                <div class="grid33">
                    <a class="delete button half_buttons red" style="width: 96%;" href="<?php echo site_url('install/uninstall/'.$item->plugin_name); ?>"><?php echo $item->plugin_title ?></a>
                </div>
                <?php if($item->plugin_version < latest_plugin_version($item->plugin_id_tag)){ ?>
                <div class="grid33">
                    <a class="button half_buttons green" style="width: 96%;" href="<?php echo site_url('install/update/'.$item->plugin_name.'/'.$item->plugin_id_tag); ?>"><?php echo $item->plugin_title ?></a>
                </div>
                <?php } ?>
            </div>
        <?php endforeach; ?>

    </div>
</div>
    
<?php /* End of File */ ?>