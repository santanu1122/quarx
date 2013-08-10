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

<div id="quarx-msg-box" class="quarx-error-box">
    <p><?php echo $error; ?></p>
</div>  

<!-- main content -->
    
<div class="quarx-small-device">

    <div class="raw100"><p>We're going to need a little bit of information in order to get your profile built. Please complete the following.</p></div>

    <form id="quarx-join-form" method="post" action="<?php echo site_url('login/submit_profile'); ?>">
        
        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />

        <div class="raw100">
            <input id="u_name" type="text" data-deefault="Username" name="user_name" onkeyup="validationCheck(this.value)" />
        </div>


        <div class="raw100">
            <input id="password" type="password" name="password" data-deefault="Password"  />
        </div>
        <div class="raw100">
            <input id="confirm" type="password" name="confirm" data-deefault="Confirm Password" />
        </div>


        <div class="raw100">
            <input id="user_email" data-type="Email" type="text" name="user_email" data-deefault="Email" />
        </div>
        <div class="raw100">
            <input id="full_name" type="text" name="full_name" data-deefault="Full Name" />
        </div>

        <div class="raw100">
            <input id="location" type="text" name="location" data-deefault="Location" />
        </div>

        <div class="raw100 raw-block-35"></div>

        <div class="raw100">
            <button id="subBtn" type="submit">Submit</button>
        </div>

    </form>

</div>

<script type="text/javascript">

    $("#quarx-join-form").submit(function(e){

        var pattern = /^\w+@[a-zA-Z_]+?\.[a-zA-Z]{2,3}$/,
            notification = "",
            state = "go";

        if($("#u_name").val() <= '' || $("#u_name").val() == $("#u_name").attr("data-deefault")){
            notification += " You need a username.";
            state = "stop";
        }

        if($("#u_name").parent().css("border") == "1px solid rgb(255, 0, 0)"){
            notification += " Your username is already taken.";
            state = "stop";
        }

        if($("#password").val() != $("#confirm").val()){
            notification += " Your passwords do not match.";
            state = "stop";
        }

        if($("#full_name").val() <= '' || $("#full_name").val() == $("#full_name").attr("data-deefault")){
            notification += " Please enter your full name.";
            state = "stop";
        }

        if(!pattern.test($("#user_email").val())){
            notification += " Your email is incorrectly formatted.";
            state = "stop";
        }

        if(state == "go"){
            return true;
        }else{
            $("#quarx-msg-box p").html(notification);
            $("#quarx-msg-box").fadeIn();
            setTimeout(function(){ $("#quarx-msg-box").fadeOut(); }, 5200);
            return false;
        }

    });

    $("input").deefault();

    <?php if(isset($error) && $error > ''){ ?>
    $(document).ready(function(){
        $("#quarx-msg-box").fadeIn();
        setTimeout(function(){ $("#quarx-msg-box").fadeOut(); }, 2200);
    });
    <?php } ?>

    function validationCheck(name){
        $.ajax({
            type: 'GET',
            url: "<?php echo site_url('login/unc'); ?>/"+name,
            dataType: "html",
            success: function(data){
                if(data == 1){
                    $('#u_name').parent().css({
                        border: '1px solid #f00'
                    });
                    $('#addBtn').attr('disabled', 'disabled');
                }else{
                    $('#u_name').parent().css({
                        border: '1px solid #61B329'
                    });
                    $('#addBtn').removeAttr('disabled');
                }

                if($('#u_name').val().length < 4){
                    $('#u_name').parent().css({
                        border: '1px solid #f00'
                    });
                    $('#addBtn').attr('disabled', 'disabled');
                }
            }
        });
    }

</script>
    
<?php //End of File ?>