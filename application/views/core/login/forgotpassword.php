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

<div class="raw100"><!-- content -->

    <div class="smallDevice">

        <div class="raw100">
        	<p>Please enter the following to get a new password sent to you.</p>
        </div>
        
        <div class="raw100 form">
        	
            <?php if(isset($error)){ ?>
    			<div class="errorMsg">
                    <p><?php echo $error; ?></p>
                </div>
    		<?php } ?>
            
            <form action="<?php echo site_url('login/newpasswordsender'); ?>" method="post">
                <table class="paddedTable">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                    <tr>
                    	<td>Username</td>
                    	<td><input name="u_name" type="text" size="32" /></td>
                    </tr>
                    <tr>
                    	<td>Email</td>
                    	<td><input name="u_email" type="text" size="32"/></td>
                    <tr>
                        <td colspan="2"><input class="fatButton" type="submit" value="New Password" /></td>
                    </tr>
                </table>
    		</form>
        
        </div>
    
    </div>

</div><!--/content -->

<!-- javascript -->

<script type="text/javascript">
    $(document).ready(function(){
        $("#errorBox").fadeIn();
        setTimeout(function(){ $("#errorBox").fadeOut(); }, 2200);
    });
</script>

<?php /* End of File */ ?>