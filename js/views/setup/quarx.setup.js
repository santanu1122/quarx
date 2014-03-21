function strengthCH(pw){

    // a quick checker to let them know they've made a solid password!
    var val = 0;
    var pwlen = pw.length;

    if (pwlen >= 13) {
        val = 5;
    } else if (pwlen >= 10) {
        val = 4;
    } else if (pwlen >= 8) {
        val = 3;
    } else if (pwlen >= 5) {
        val = 2;
    }

    var re = [ null, /[a-z]/g, /[A-Z]/g, /\d/g, /[!@#$%\^&amp;\*\(\)=_+-]/g];

    for (var i = 1; i < re.length; i++) {
        val += (pw.match(re[i]) || []).length * i;
    }

    if (val <= 20) {
        $("#pwStrength").attr('class', 'quarx-error-border');
        $("#pwStrength").html('<p class="quarx-error-txt">Your Password is Weak</p>');
    } else {
        $("#pwStrength").attr('class', 'quarx-success-border');
        $("#pwStrength").html('<p class="quarx-success-txt">Your Password is Strong</p>');
    }

    $("#pwStrength").show();
}

//verify that they match first
function pwChecker() {
    var pw1 = $("#password").val()
        pw2 = $("#confirm").val();

    if (pw1 != pw2) {
        $("#pwStrength").attr('class', 'quarx-error-border');
        $("#pwStrength").html('<p class="quarx-error-txt">Your Passwords don\'t Match</p>');
        return false;
    } else {
        $("#pwStrength").attr('class', 'quarx-success-border');
        $("#pwStrength").html('<p class="quarx-success-txt">Your Passwords Match</p>');
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
        if (!pwChecker()) {
            $("#pwStrength").attr('class', 'quarx-error-border');
            $("#pwStrength").html('<p class="errortxt">Your Passwords don\'t Match</p>');
        } else {
            $('#pwChanger').submit();
        }
    });

});