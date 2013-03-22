<?php /*
    Filename:   password_changer.php
    Location:   /application/views/core
    Author:     Matt Lantz
*/ ?>

<script type="text/javascript">
    
    function strengthCH(pw){
        
        // a quick checker to let them know they've made a solid password!
        var val = 0;
        var pwlen = pw.length;
        
        if(pwlen >= 13){val = 5;}
        else if(pwlen >= 10){val = 4;}
        else if(pwlen >= 8){val = 3;}
        else if(pwlen >= 5){val = 2;}

        var re = [ null, /[a-z]/g, /[A-Z]/g, /\d/g, /[!@#$%\^&amp;\*\(\)=_+-]/g];

        for (var i = 1; i < re.length; i++) {
            val += (pw.match(re[i]) || []).length * i;
        }

        if(val <= 20){
            $("#pwStrength").css('border', '1px solid #600');
            $("#pwStrength").html('<p style="padding: 5px; color: #600; font-size: 11px;">Your Password is Weak</p>'); 
        }else{
             $("#pwStrength").css('border', '1px solid #0C3');
            $("#pwStrength").html('<p style="padding: 5px; color: #0C3; font-size: 11px;">Your Password is Strong</p>'); 
        }
            $("#pwStrength").show(); 
    }

    //verify that they match first
    function pwChecker(pw2){
        var pw1 = $("#password1").val();
        if(pw1 != pw2){
            $("#success").hide(); 
            $("#error").show(); 
        }else{
            $("#error").hide(); 
            $("#success").show(); 
        }
    }

    $(document).ready(function(){
        $("#error").hide(); 
        $("#success").hide(); 
    });

</script>

<div id="error" class="errorMsg">
    <p>Sorry, you're passwords do not match</p>
</div>

<div id="success" class="successMsg">
    <p>Your passwords match!</p>
</div>

<div id="pwStrength" class="passwordStrength">
    <p>&nbsp;</p>
</div>

<div class="wide_box">
    <?php if($this->session->userdata('logged_in')){ ?>
        <div class="wide_box" style="text-align: center; min-height: 500px;">
            <div style="width: 380px; margin: 50px auto;">  
                <div style="margin: 20px; text-align: left; width: 340px; height: 200px;">
                    <br />
                    <h2>Update My Password</h2>
                    <br />
                    <form method="post" action="<?php echo site_url('accounts/changepassword'); ?>">
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                        <table class="spaced" width="100%" style="float: left; margin: 15px;">
                            <tr>
                                <td><p>New Password&nbsp;&nbsp;&nbsp;</p></td>
                                <td><input id="password1" type="password" name="password" size="20" onkeyup="strengthCH(this.value)" /></td>
                            </tr>
                            <tr>
                                <td><p>New Password Again&nbsp;&nbsp;&nbsp;</p></td>
                                <td><input type="password" name="password2" size="20" onkeyup="pwChecker(this.value)" /></td>
                            </tr>
                            <tr>
                                <td colspan="2"><input class="fatButton" type="submit" value="Change" /></td>
                            </tr>
                        </table>
                    </form>
                </div>
            </div>
        </div>
</div>
        
    <?php }else{ ?>
    
    <?php redirect('login/error'); ?>

    <?php } ?>
    
<?php /* End of File */ ?>