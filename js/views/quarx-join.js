$(document).ready(function(e) {
    $('#u_name').on("keyup", function() {
        $(this).val($(this).val().replace(/\s/g, "").toLowerCase());
    });
});

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

    if (state == "go") {
        return true;
    } else {
        quarxNotify("Warning", notification);
        return false;
    }

});

function validationCheck(name, URL){
    $.ajax({
        type: 'GET',
        url: URL+name,
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