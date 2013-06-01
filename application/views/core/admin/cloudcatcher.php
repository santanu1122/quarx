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

<div class="raw100" style="min-height: 600px;"><!-- content -->
    <div class="device">
        <h1>CloudCatcher: Your Website Backup Tool</h1>

        <div class="raw33">
            <div class="padded20">
                <?php 
                
                if(isset($_GET['download'])){ ?>
                    <?php $date = date('m-d-y'); ?>
                
                <button onclick="window.location='<?php echo site_url(); ?>backup/<?php echo $date; ?>.zip'" >Download</button>
                <button onclick="window.location='<?php echo site_url(); ?>admin/cloudcatcher/deletebackup?date=<?php echo $date; ?>'">Delete Server Copy</button>
                        
                <?php  }else{ ?>
                <button id="backupBtn" onclick="cloudCatcher()">Backup Now</button>
                <div id="loader" style="display: none;"><p>Loading</p></div>
                <?php } ?>

            </div>
        </div> 

        <div class="raw66">
            <div class="padded">
                <h1>Cloud Catcher Instructions</h1>
                <br />
                <p>Welcome to Cloud Catcher, a simple backup tool for that extra bit of insurance. Don't fret the process is as simple as 1, 2, 3:</p>
                <br />
                <p><b>1.</b> Click the "Backup" button, and wait a few moments. You will see that your browser is working just let it work. You will know its done when two new buttons pop up.</p>
                <br />
                <p><b>2.</b> Click the "Download" button to download your copy of the backup to keep on your computer. Pretty easy eh. Place the file in a folder for safe keeping. Its named by the day so you can keep track of when your last backup was done. We recommend performing this action at least monthly.</p>
                <br />
                <p><b>3.</b> Click the "Delete Server Copy" button. This will actually delete the backup file from the server. The reason we do this is to make sure you have lots of space left on your server where the website is hosted.</p>
                <br />
                <p>You're all done! Remember to keep the downloaded files safe. They are your responsibility and in the event of a website error you may need to be able to send a recent version of your website to your developer to get the site back up and running with a recent copy of the site.</p>
            </div>
        </div> 
    </div>

</div><!--/content -->

<script type="text/javascript">
    
    function cloudCatcher(){
        $('#backupBtn').parent().hide();
        $('#loader').show();
        setInterval(function(){ $('#loader p').append(' .') }, 200);
        
        $.ajax({
            type: 'POST',
            url: "<?php echo site_url('admin/cloudcatcher/backup'); ?>/",
            data: { backup: true, <?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>' },
            dataType: "html",
            success: function(data){
                if(data == 1){
                    window.location = '<?php echo site_url("admin/cloudcatcher"); ?>'+'?download';
                }else{

                }
            }
        });
    }

</script>

<?php //End of File ?>