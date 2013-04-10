<?php /*
    Filename:   db_setup.php
    Location:   /application/views/setup
*/ ?>

<div class="raw100">

    <div id="progressBar"></div>
        
    <div class="raw100">
        <h1>Admin Setup</h1>
        <p class="align-left">Are you excited to start working on your web application? First we need to setup the database.</p>
        <h2>Database Information</h2>
        <div class="smallDevice">
            <form method="post" enctype="multipart/form-data" action="<?php echo site_url('setup/db_complete'); ?>">
                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />

                <input id="db_uname"  value="Database User Name" type="text" name="db_uname" onfocus="this.value=''" />
                
                <input id="db_password"  value="Database Password" type="text" name="db_password" onfocus="this.value=''; this.type='password'"/>
                
                <input id="db_name" value="Database Name" type="text" name="db_name" onfocus="this.value=''" />

                <input type="submit" data-theme="d" value="Set Up Database" />
            </form>
        </div>
    </div>
</d
    
<?php /* End of File */ ?>