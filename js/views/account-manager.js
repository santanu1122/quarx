$('.closer').bind('click', function() {
    $('.quarx-account-controls').hide();
});

function binder() {
    $('.quarx-action-btn').bind('click', function(){
        $('.quarx-account-controls').hide();
        $(this).parent().parent().parent().children('.quarx-account-controls').show();
    });
}

function authorize(id, URL) {
    $( "#dialog-authorize" ).dialogbox({
        buttons: {
            Ok: function() {
                window.location=URL+"/"+id;
            },
            Cancel: function() {
                dialogDestroy("#dialog-authorize");
            }
        }
    });
}

function deleteConfirm(id, URL) {
    $( "#dialog-confirm" ).dialogbox({
        buttons: {
            Ok: function() {
                window.location=URL+"/"+id;
            },
            Cancel: function() {
                dialogDestroy("#dialog-confirm");
            }
        }
    });
}

function masterConfirm(id, URL) {
    $( "#dialog-master" ).dialogbox({
        buttons: {
            Ok: function() {
                window.location=URL+"/"+id;
            },
            Cancel: function() {
                dialogDestroy("#dialog-master");
            }
        }
    });
}

function standardConfirm(id, URL) {
    $( "#dialog-downgrade" ).dialogbox({
        buttons: {
            Ok: function() {
                window.location=URL+"/"+id;
            },
            Cancel: function() {
                dialogDestroy("#dialog-downgrade");
            }
        }
    });
}

function enable(id, URL) {
    $( "#dialog-enable" ).dialogbox({
        buttons: {
            Ok: function() {
                window.location=URL+"/"+id;
            },
            Cancel: function() {
                dialogDestroy("#dialog-enable");
            }
        }
    });
}

function disable(id, URL) {
    $( '#dialog-disable' ).dialogbox({
        buttons: {
            Ok: function() {
                window.location=URL+"/"+id;
            },
            Cancel: function() {
                dialogDestroy("#dialog-disable");
            }
        }
    });
}

$(document).ready(function(e) {
    $('#quarx-member-search').submit(function() {
        if ($('#quarx-search').val().length < 3 ) {
            quarxNotify('info','Sorry, your search must have at least three characters');
            return false;
        } else {
            return true;
        }
    });

   $("#disableBtn, #enableBtn, #authorizeBtn, #deleteBtn").click(function(e) {
        e.preventDefault();
    });

    $('.quarx-account-controls button').buttonMarkup({ corners: false });
    $('.quarx-account-controls .ui-btn').css("margin", "0");

    binder();
});