<?php

/**
 * Quarx
 *
 * A modular CMS application
 *
 * @package     Quarx
 * @author      Matt Lantz
 * @copyright   Copyright (c) 2013 - 2014 Matt Lantz
 * @license     https://ottacon.co/docs/quarx/license.html
 * @link        https://github.com/mlantz/quarx
 * @since       Version 1.0
 *
 */

?>

<div class="raw100">
    <div class="quarx-small-device">

        <h1>Quarx Setup</h1>
        <p class="quarx-align-left">Are you excited to start working on your web application? First we need to setup the database. <br><br><b>** Please ensure that your database is set and access is set up on your hosting provider. **</b> </p>
        <h2>Database Information</h2>

        <form method="post" enctype="multipart/form-data" action="<?php echo site_url('setup/forge'); ?>">

            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
            <input id="db_uname"  value="Database User Name" type="text" name="db_uname" onfocus="this.value=''" />
            <input id="db_password"  value="Database Password" type="text" name="db_password" onfocus="this.value=''; this.type='password'"/>
            <input id="db_name" value="Database Name" type="text" name="db_name" onfocus="this.value=''" />
            <input type="submit" data-theme="d" value="Set Up Database" />

        </form>
    </div>
</div>

<?php /* End of File */ ?>