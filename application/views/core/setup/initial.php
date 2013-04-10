<?php /*
    Filename:   initial.php
    Location:   /application/views/setup
*/ ?>

<div class="smallDevice tall">
    <div id="pwStrength"></div>
</div>

<div class="raw100">
    
    <div class="wide_box" style="text-align: center; min-height: 500px;">

        <div id="masterAccount" class="smallDevice">
            <h1>Admin Setup</h1>
            <p class="align-left">Stay calm we just need a little more information.</p>
            <div class="raw100">
                <h2>Master Account Information</h2>
                <form method="post" enctype="multipart/form-data" action="<?php echo site_url('setup/complete'); ?>">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                    
                    <input class="" value="User Name" type="text" name="username" onfocus="this.value=''" />
                    <input id="password" value="Password" type="text" name="password" onfocus="this.value=''; this.type='password'" />
                    <input id="confirm" value="Password Again" type="text" name="confirm" onfocus="this.value=''; this.type='password'" />
                    <h2>Options</h2>
                    <br />
                    <input data-theme="a" id="accountStatus" type="checkbox" value="1" name="advancedAccounts" />
                    <label for="accountStatus">Advanced Accounts</label>

                    <input data-theme="a" id="masterAccess" type="checkbox" value="1" name="masterAccess" />
                    <label for="masterAccess">Master Access</label>
                    <br />
                    <br />
                    <input type="submit" value="Install Quarx" />
                </form>
            </div>
        </div>
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
            $("#pwStrength").attr('class', 'errorBorder');
            $("#pwStrength").html('<p class="errorTxt">Your Password is Weak</p>'); 
        }else{
            $("#pwStrength").attr('class', 'successBorder');
            $("#pwStrength").html('<p class="successTxt">Your Password is Strong</p>'); 
        }
            $("#pwStrength").show(); 
    }

    //verify that they match first
    function pwChecker(){
        var pw1 = $("#password").val()
            pw2 = $("#confirm").val();

        if(pw1 != pw2){
            $("#pwStrength").attr('class', 'errorBorder');
            $("#pwStrength").html('<p class="errorTxt">Your Passwords don\'t Match</p>'); 
            return false;
        }else{
            $("#pwStrength").attr('class', 'successBorder');
            $("#pwStrength").html('<p class="successTxt">Your Passwords Match</p>'); 
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
                $("#pwStrength").attr('class', 'errorBorder');
                $("#pwStrength").html('<p class="errorTxt">Your Passwords don\'t Match</p>'); 
            }else{
                $('#pwChanger').submit();
            }
        });
    });

</script>
<?php /* End of File */ ?>