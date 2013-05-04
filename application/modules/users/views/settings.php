<?php /*
    Filename:   settings.php
    Location:   /views
*/ ?>

<!-- Main Page -->

<div class="smallDevice">

    <div class="raw100">
        <a href="#" data-role="button" onclick="showMenu()">Users Menu</a>
    </div>

    <form method="post" enctype="multipart/form-data" action="<?php echo site_url('users/edit'); ?>">
    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />

    <input data-theme="a" id="autoAuth" type="checkbox" <?php echo $autoAuth; ?> value="1" name="autoAuth" />
    <label for="autoAuth">Auto-Authorize Sign Ups</label>

    <input data-role="button" data-theme="a" type="submit" value="Save Settings" />

</div>
    
<?php //End of file ?>