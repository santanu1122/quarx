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

<!-- notifications -->

<?php if(isset($error)){ ?>
    <div id="errorBox" class="errorBox">
        <p><?php echo $error; ?></p>
    </div>  
<?php } ?>

<!-- main content -->
    
<div class="raw100">

    <div class="smallDevice">
        <div class="form raw100">
            <form method="post" action="<?php echo site_url('login/validator'); ?>" data-ajax="false">
                <div class="raw100">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                    <div class="raw100">
                        <div class="raw50"><p>Username</p></div>
                        <div class="raw50"><p><input type="text" name="username" /></p></div>
                    </div>
                    <div class="raw100">
                        <div class="raw50"><p>Password</p></div>
                        <div class="raw50"><p><input type="password" name="password" /></p></div>
                    </div>
                    <div class="raw100">
                        <div class="raw50"><p>Remember Me <br /> ( 2 weeks )</p></div>
                        <div class="raw50"><input type="checkbox" id="rememberMe" name="remember_me" value="1" /><label for="rememberMe">I agree</label></div>
                    </div>
                    <div class="raw100">
                        <input type="submit" value="Login" />
                    </div>
                </div>
            </form>
            
        </div>

        <div class="raw100">
            <a data-role="button" href="<?php echo site_url('login/forgotpassword'); ?>">Forgot My Password</a>
        </div>
    </div>
    
</div>

<script type="text/javascript">
    $(document).ready(function(){
        $("#errorBox").fadeIn();
        setTimeout(function(){ $("#errorBox").fadeOut(); }, 2200);
    });
</script>
    
<?php /* End of File */ ?>