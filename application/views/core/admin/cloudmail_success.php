<?php /*
    Filename:   email_success.php
    Location:   /application/views/core/
*/ ?>

<div class="raw100" style="min-height: 500px;"><!-- content -->
    <div class="smallDevice">
    <h1 style="margin: 20px;">Success!</h1>
    <br />
        <p>Your email was successfully sent!</p>
        <br />
        <br />
        <button class="padded" onclick="document.location='<?php echo site_url('admin/cloudmail'); ?>'">Return to CloudMail</button>
    </div>
</div><!--/content -->

<?php /* End of File */ ?>