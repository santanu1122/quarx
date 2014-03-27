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
                    boxShadow: 'inset 0px 1px 4px #f00'
                });
                $('#addBtn').attr('disabled', 'disabled');
            } else {
                $('#u_name').parent().css({
                    boxShadow: 'inset 0px 1px 4px #61B329'
                });
                $('#addBtn').removeAttr('disabled');
            }

            if ($('#u_name').val().length < 4) {
                $('#u_name').parent().css({
                    border: 'inset 0px 1px 4px #f00 !important'
                });
                $('#addBtn').attr('disabled', 'disabled');
            }
        }
    });
}