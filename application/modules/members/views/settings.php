<?php /*
    Filename:   settings.php
    Location:   /views
*/ ?>

<!-- Main Page -->

<div class="quarx-small-device">

    <div class="raw100 raw-margin-bottom-15">
        <a href="#" data-role="button" onclick="showMenu()">Users Menu</a>
    </div>

    <form method="post" enctype="multipart/form-data" action="<?php echo site_url('users/update_settings'); ?>">
        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />

        <input data-theme="a" id="autoAuth" type="checkbox" <?php echo $autoAuth; ?> value="1" name="autoAuth" />
        <label for="autoAuth">Auto-Authorize User Accounts</label>

        <input data-theme="a" id="pubProfile" type="checkbox" <?php echo $pubProfile; ?> value="1" name="pubProfile" />
        <label for="pubProfile">Public Profiles Available</label>

        <input data-role="button" data-theme="a" type="submit" value="Save Settings" />
    </form>

</div>
    
<?php //End of file ?>