<?php /*
    Filename:   initial.php
    Location:   /application/views/setup
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
        $("#pwStrength").hide(); 
        var pw1 = $("#password1").val();
        if(pw1 != pw2){
            $("#success").hide(); 
            $("#error").show(); 
        }else{
            $("#error").hide(); 
            $("#success").show();
            setTimeout(function(){ $("#success").fadeOut(); }, 1000);
        }
    }

    $(function() {
        $( "#progressBar" ).progressbar({
            value: 50
        });
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

    <div id="progressBar"></div>
    
    <div class="wide_box" style="text-align: center; min-height: 500px;">

        <div id="masterAccount" class="wide300 centered">
            <br />
            <h1>Admin Setup</h1>
            <br />
            <p class="align-left">Stay calm we just need a little more information.</p>
            <br />
            <div class="wide300">
                <form method="post" enctype="multipart/form-data" action="<?php echo site_url('setup/complete'); ?>">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                    <h2>Master Account Information</h2>
                    <br />
                    <input class="padded10 roundcorners greyborder wide300" value="User Name" type="text" name="username" onfocus="this.value=''" />
                    <br />
                    <input id="password1" class="padded10 roundcorners greyborder wide300" value="Password" type="text" name="userpassword1" onfocus="this.value=''; this.type='password'" onkeyup="strengthCH(this.value)" />
                    <br />
                    <input id="password2" class="padded10 roundcorners greyborder wide300" value="Password Again" type="text" name="userpassword2" onfocus="this.value=''; this.type='password'" onkeyup="pwChecker(this.value)" />
                    <br />
                    <br />
                    <h2>Options</h2>
                    <br />
                    <div class="wide300 centered padded10">
                        <div class="leftBox wide200"><p>Advanced Accounts</p></div>
                        <div class="leftBox"><input type="checkbox" value="1" name="advancedAccounts" /></div>
                    </div>

                    <div class="wide300 centered padded10">
                        <div class="leftBox wide200"><p>Master Access</p></div>
                        <div class="leftBox"><input type="checkbox" value="1" name="masterAccess" /></div>
                    </div>
                    <br />
                    <br />
                    <input type="submit" class="green centered" style="padding: 15px 25px; width: 200px;" value="Install Quarx" />
                </form>
            </div>
        </div>
    </div>
    
<?php /* End of File */ ?>