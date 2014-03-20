$(document).ready(function(e) {
    $('#u_name').on("keyup", function() {
        $(this).val($(this).val().replace(/\s/g, "").toLowerCase());
    });

    $("#saveBtn").click(function(){
        $("#quarx-modal, #fountainG").show();
    });
});

function validationCheck(name, userNameURL){
    $.ajax({
        type: 'GET',
        url: userNameURL+"/"+name,
        dataType: "html",
        success: function(data){
            if (data == 1) {
                $('#u_name').parent().css({
                    border: '1px solid #f00'
                });
                $('#addBtn').attr('disabled', 'disabled');
            } else {
                $('#u_name').parent().css({
                    border: '1px solid #61B329'
                });
                $('#addBtn').removeAttr('disabled');
            }

            if ($('#u_name').val().length < 4) {
                $('#u_name').parent().css({
                    border: '1px solid #f00'
                });
                $('#addBtn').attr('disabled', 'disabled');
            }
        }
    });
}