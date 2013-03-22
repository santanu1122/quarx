<?php /*
	Filename: 	forgotpassword.php
	Location: 	/application/views/core
*/ ?>

<script type="text/javascript">
    $(document).ready(function(){
        $("#errorBox").fadeIn();
        setTimeout(function(){ $("#errorBox").fadeOut(); }, 2200);
    });
</script>

<?php if(isset($error)){ ?>
    <div id="errorBox" class="errorBox">
        <p><?php echo $error; ?></p>
    </div>  
<?php } ?>

<div class="wide_box"><!-- content -->

    <div style="width: 960px; margin: 50px auto; height: 400px;">

    	<div style="width: 960px; height: 50px; float: left;">
        	<h1 style="margin-top: 10px;">Bummer</h1>
        </div>

        <div style="width: 660px; margin: 0 auto;">
        	<h2 style="padding: 30px; text-align: left;">We know how much it sucks to forget your password, so here is a simple form to get your password back.</h2>
        </div>
        
        <div style="width: 960px; float: left;">
        	
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

<?php /* End of File */ ?>