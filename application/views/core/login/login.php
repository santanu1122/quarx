<?php /*
    Filename:   login.php
    Location:   /application/views/core/
*/ ?>

<script type="text/javascript">
    $(document).ready(function(){
        $("#errorBox").fadeIn();
        setTimeout(function(){ $("#errorBox").fadeOut(); }, 2200);
    });
</script>

<div class="wide_box">
    <br />
    <?php if(isset($error)){ ?>
        <div id="errorBox" class="errorBox">
            <p><?php echo $error; ?></p>
        </div>  
    <?php } ?>
        
        <div class="wide_box" style="margin: 80px auto;">
            <div class="centered wide320">
                <form method="post" action="<?php echo site_url('login/validator'); ?>">
                    <div class="grid" style="width: 300px;">
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                        <div class="gridrow">
                            <div class="grid50"><p>Username</p></div>
                            <div class="grid50"><p><input type="text" name="username" /></p></div>
                        </div>
                        <div class="gridrow">
                            <div class="grid50"><p>Password</p></div>
                            <div class="grid50"><p><input type="password" name="password" /></p></div>
                        </div>
                        <div class="gridrow">
                            <div class="grid50"><p>Username</p></div>
                            <div class="grid50"><p><input type="checkbox" name="remember_me" value="1" /> (2 weeks)</p></div>
                        </div>
                        <div class="gridrow">
                            <input style="float: right;" type="submit" value="Login" />
                        </div>
                    </div>
                </form>
                
                <button style="margin-top: 50px;" onclick="document.location='<?php echo site_url('login/forgotpassword'); ?>'">Forgot My Password</button>
            </div>
        </div>
    
<?php /* End of File */ ?>