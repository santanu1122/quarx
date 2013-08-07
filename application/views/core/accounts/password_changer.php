<?php

/**
 * Quarx
 *
 * A modular application framework built on CodeIgniter
 *
 * @package     Quarx
 * @author      Matt Lantz
 * @copyright   Copyright (c) 2013 Matt Lantz
 * @license     http://ottacon.co/quarx/license
 * @link        http://ottacon.co/quarx
 * @since       Version 1.0
 * 
 */ 

?>

<div class="raw100">
    <div id="quarx-msg-box">
        <p id="pwStrength"></p>
    </div>
</div>

<div class="quarx-small-device">
                    
    <form id="pwChanger" class="raw100 raw-margin-top-30" method="post" action="<?php echo site_url('accounts/changepassword'); ?>">
        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
        <div class="raw100">
            <div class="raw100">
                <div class="raw50"><p>New Password</p></div>
                <div class="raw50"><input id="password" type="password" name="password" size="20" /></div>
            </div>
            <div class="raw100">
                <div class="raw50"><p>New Password Again</p></div>
                <div class="raw50"><input id="confirm" type="password" name="confirm" size="20" /></div>
            </div>
            <div class="raw100">
                <div class="raw100"><input id="changeBtn" type="submit" value="Change" /></div>
            </div>
        </div>
    </form>

</div>

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
            $("#quarx-msg-box").attr('class', 'quarx-error-box');
            $("#quarx-msg-box").html('<p>Your Password is Weak</p>'); 
        }else{
            $("#quarx-msg-box").attr('class', 'quarx-success-box');
            $("#quarx-msg-box").html('<p>Your Password is Strong</p>'); 
        }
            $("#quarx-msg-box").show();
    }

    //verify that they match first
    function pwChecker(){
        var pw1 = $("#password").val()
            pw2 = $("#confirm").val();

        if(pw1 != pw2){
            $("#quarx-msg-box").attr('class', 'quarx-error-box');
            $("#quarx-msg-box").html('<p>Your Passwords don\'t Match</p>'); 
            return false;
        }else{
            $("#quarx-msg-box").attr('class', 'quarx-success-box');
            $("#quarx-msg-box").html('<p>Your Passwords Match</p>'); 
            return true;
        }
    }

    $(document).ready(function(){

        $('#password').keyup(function(){
            strengthCH($('#password').val());
        });

        $('#confirm').keyup(function(){
            strengthCH($('#confirm').val());
            pwChecker();
        });

        $("#changeBtn").click(function(event){
            event.preventDefault();
            if(!pwChecker()){
                $("#quarx-msg-box").html('<p>Your Passwords don\'t Match</p>'); 
            }else{
                $('#pwChanger').submit();
            }
        });
    });

</script>

<?php /* End of File */ ?>