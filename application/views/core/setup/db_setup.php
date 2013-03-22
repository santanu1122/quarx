<?php /*
    Filename:   db_setup.php
    Location:   /application/views/setup
    Author:     Matt Lantz
*/ ?>

<script type="text/javascript">
    $(function() {
        $( "#progressBar" ).progressbar({
            value: 1
        });
    });
</script>

<div class="wide_box">

    <div id="progressBar"></div>
        
    <div class="wide_box" style="text-align: center; min-height: 500px;">

        <div id="masterAccount" class="wide300 centered">
            <br />
            <h1>Admin Setup</h1>
            <br />
            <p class="align-left">Are you excited to start working on your web application? First we need to setup the database.</p>
            <br />
            <div class="wide300">
                <form method="post" enctype="multipart/form-data" action="<?php echo site_url('setup/db_complete'); ?>">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                    <h2>Database Information</h2>
                    <br />

                    <input id="db_uname" class="padded10 roundcorners greyborder wide300" value="Database User Name" type="text" name="db_uname" onfocus="this.value=''" />
                    <br />
                    
                    <input id="db_password" class="padded10 roundcorners greyborder wide300" value="Database Password" type="text" name="db_password" onfocus="this.value=''; this.type='password'"/>
                    <br />
                    
                    <input id="db_name" class="padded10 roundcorners greyborder wide300" value="Database Name" type="text" name="db_name" onfocus="this.value=''" />

                    <br />
                    <br />
                    <input type="submit" class="green centered" style="padding: 15px 25px; width: 200px;" value="Set Up Database" />
                </form>
            </div>
        </div>
    </div>
    
<?php /* End of File */ ?>