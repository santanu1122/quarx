function populateCollections(collectionId) {
    $.ajax({
        url: _quarxRootURL+'images/get_collections',
        type: 'GET',
        cache: false,
        dataType: 'html',
        success: function(data) {
            $('#collections').html(data).selectmenu('refresh', true);
            $(".quarx-collection-options").each(function(){
                if ($(this).val() == collectionId) {
                    $(this).attr("selected", true);
                };
            });

            if (collectionId == 'null') {
                $("#collections").prepend("<option class=\"quarx-collection-options\" selected=\"true\" value=\"0\">Please Select a Category</option>");
            };

            $("#collections").selectmenu("refresh", true);
        }
    });
}

function newCollectionBox(){
    $( "#dialog-newColl" ).dialogboxInput({
        web_link: false,
        buttons: {
            Ok: function() {
                $.ajax({
                    url: _quarxRootURL+'images/new_collection',
                    type: 'POST',
                    cache: false,
                    data: {
                        collection_name: $('#collectionName').val(),
                        q_csrf_token: _quarxSecurityHash
                    },
                    success: function(data) {
                        inputDialogDestroy("#dialog-newColl");
                        populateCollections();
                        if (_quarxCollectionManager == true) {
                            window.location = window.location;
                        }
                    }
                });
            },
            Cancel: function() {
                inputDialogDestroy("#dialog-newColl");
            }
        }
    });
}

function deleteCollection(id) {
    $( "#dialog-col-del" ).dialogboxInput({
        buttons: {
            Ok: function() {
                window.location = _quarxRootURL+'images/delete_collection/'+id;
            },
            Cancel: function() {
                inputDialogDestroy( "#dialog-img" );
            }
        }
    });
}

function deleteImage(id) {
    $( "#dialog-img" ).dialogboxInput({
        buttons: {
            Ok: function() {
                $.ajax({
                    url: _quarxRootURL+'images/delete_img/'+id,
                    type: 'GET',
                    dataType: "HTML",
                    success: function(data) {
                        $("#container-"+id).remove();
                        quarxNotify("Success", "The image was successfully deleted.");
                        inputDialogDestroy("#dialog-img");
                    }
                });
            },
            Cancel: function() {
                inputDialogDestroy("#dialog-img");
            }
        }
    });
}

function viewFull() {
    if ($('#dialog-update-alt').attr('data-imageId') > '') {
        window.location = _quarxRootURL+"images/view_full/"+$('#dialog-update-alt').attr('data-enc-id');
    }

    if ($('#dialog-alt').attr('data-imageId') > '') {
        window.location = _quarxRootURL+"images/view_full/"+$('#dialog-alt').attr('data-enc-id');
    }
}

/*
|--------------------------------------------------------------------------
| Document Ready
|--------------------------------------------------------------------------
*/

$(function(){
    $('input:submit').button();

    $('#quarx-new-collection').bind('click', function(){
        newCollectionBox();
    });

    $('#addBtn').click(function(){
        _quarx_loading();
    });

    $("#quarx-select-library-collections").bind("click", function (){
        $.ajax({
            url: _quarxRootURL+'images/get_collections',
            type: 'GET',
            dataType: "HTML",
            success: function(data) {
                var options = '<option value="0">None</option>'+data;
                $('#quarx-select-library-collections').html(options).selectmenu("refresh");
            }
        });
    });

    populateCollections(_collectionID);
});
