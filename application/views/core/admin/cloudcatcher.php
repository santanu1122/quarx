<?php /* 
    Filename:   cloudcatcher.php
    Location:   /application/views/core/admin
    Author:     Matt Lantz
*/ ?>

<style type="text/css">
    .framed{
        width: 90%;
        height: 80px;
        border: 1px solid #eee;
        overflow: hidden;
        border-radius: 10px;
    }
</style>

<div class="wide_box" style="min-height: 600px;"><!-- content -->

    <div class="half_box">
        <div class="padded">
            <h1>CloudCatcher: Your Website Backup Tool</h1>
            <br />
            <iframe class="framed" src="<?php echo site_url('admin/cloudcatcher/backuptool'); ?>"></iframe>
        </div>
    </div> 

    <div class="half_box">
        <div class="padded">
            <h1>Cloud Catcher Instructions</h1>
            <br />
            <p>Welcome to Cloud Catcher, a simple backup tool for that extra bit of insurance. Don’t fret the process is as simple as 1,2,3:</p>
            <br />
            <p><b>1.</b> Click the “Backup” button, and wait a few moments. You will see that your browser is working just let it work. You will know its done when two new buttons pop up.</p>
            <br />
            <p><b>2.</b> Click the “Download” button to download your copy of the backup to keep on your computer. Pretty easy eh. Place the file in a folder for safe keeping. Its named by the day so you can keep track of when your last backup was done. We recommend performing this action at least monthly.</p>
            <br />
            <p><b>3.</b> Click the “Delete Server Copy” button. This will actually delete the backup file from the server. The reason we do this is to make sure you have lots of space left on your server where the website is hosted.</p>
            <br />
            <p>You’re all done! Remember to keep the downloaded files safe. They are your responsibility and in the event of a website error you may need to be able to send a recent version of your website to your developer to get the site back up and running with a recent copy of the site.</p>
        </div>
    </div> 

</div><!--/content -->

<?php //End of File ?>