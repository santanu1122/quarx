<?php /*
    Filename:   email_success.php
    Location:   /application/views/core/
    Author:     Matt Lantz
*/ ?>

<div class="wide_box" style="min-height: 500px;"><!-- content -->

    <h1 style="margin: 20px;">Success!</h1>
    <br />
        <p>Your email was successfully sent!</p>
        <br />
        <br />
        <button class="padded" onclick="document.location='<?php echo site_url('admin/cloudmail'); ?>'">Return to CloudMail</button>

</div><!--/content -->

<?php /* End of File */ ?>