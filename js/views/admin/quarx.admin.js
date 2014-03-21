/**
 * Quarx
 *
 * A modular CMS application
 *
 * @package     Quarx
 * @author      Matt Lantz
 * @copyright   Copyright (c) 2013 Matt Lantz
 * @license     http://ottacon.co/quarx/license.html
 * @link        http://ottacon.co/quarx
 * @since       Version 1.0
 *
 */

$('#account_info').bind("click", function(e){
    e.preventDefault();

    $( "#dialog-account_info" ).dialogbox({
        buttons: {
            Ok: function() {
                inputDialogDestroy("#dialog-account_info");
            }
        }
    });
});


$('#master_info').bind("click", function(e){
    e.preventDefault();

    $( "#dialog-master_info" ).dialogbox({
        buttons: {
            Ok: function() {
                inputDialogDestroy("#dialog-master_info");
            }
        }
    });
});

$('#joining_info').bind("click", function(e){
    e.preventDefault();

    $( "#dialog-joining_info" ).dialogbox({
        buttons: {
            Ok: function() {
                inputDialogDestroy("#dialog-joining_info");
            }
        }
    });
});

$('#autoAuth_info').bind("click", function(e){
    e.preventDefault();

    $( "#dialog-autoAuth_info" ).dialogbox({
        buttons: {
            Ok: function() {
                inputDialogDestroy("#dialog-autoAuth_info");
            }
        }
    });
});


function cloudCatcher() {
    $('#backupBtn').parent().hide();

    _quarx_loading();

    $.ajax({
        type: 'POST',
        url: _quarxRootURL+"admin/cloudcatcher/backup/",
        data: { backup: true, q_csrf_token: _quarxSecurityHash },
        dataType: "html",
        success: function(data){
            if(data == 1){
                window.location = _quarxRootURL+'admin/cloudcatcher?download';
            }
        }
    });
}