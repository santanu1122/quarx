<?php

/**
 * Quarx
 *
 * A modular application framework built on CodeIgniter
 *
 * @package     Quarx
 * @author      Matt Lantz
 * @copyright   Copyright (c) 2013 Matt Lantz
 * @license     http://ottacon.co/quarx/license.html
 * @link        http://ottacon.co/quarx
 * @since       Version 1.0
 * 
 */

?>

<!-- notifications -->

<?php if(isset($error)){ ?>
    <div id="quarx-msg-box" class="quarx-error-box">
        <p><?php echo $error; ?></p>
    </div>  
<?php } ?>

<!-- main content -->

<div class="raw100"><!-- content -->

    <div class="quarx-small-device">

        <div class="raw100">
        	<p>Please enter the following to get a new password sent to you.</p>
        </div>
        
        <div class="raw100 quarx-form">
            
            <form action="<?php echo site_url('login/newpasswordsender'); ?>" method="post">
                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                <div class="raw100">
                    <div class="raw33"><p>Username</p></div>
                    <div class="raw66"><input name="u_name" type="text" /></div>
                </div>
                <div class="raw100">
                    <div class="raw33"><p>Email</p></div>
                    <div class="raw66"><input name="u_email" type="text" /></div>
                </div>
                <div class="raw100">
                    <input class="fatButton" type="submit" value="New Password" />
                </div>
    		</form>
        
        </div>
    
    </div>

</div><!--/content -->

<!-- javascript -->

<script type="text/javascript">
    $("#quarx-msg-box").show().delay(2500).fadeOut("slow");
</script>

<?php /* End of File */ ?>