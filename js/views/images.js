function populateCollections() {
    $.ajax({
        url: images_get_collectionsURL,
        type: 'GET',
        cache: false,
        dataType: 'html',
        success: function(data) {
            $('#collections').html(data).selectmenu('refresh', true);
        }
    });
}

function newCollectionBox(){
        $( "#dialog-newColl" ).dialogboxInput({
            web_link: false,
            buttons: {
                Ok: function() {
                    $.ajax({
                        url: images_new_collectionURL,
                        type: 'POST',
                        cache: false,
                        data: {
                            collection_name: $('#collectionName').val(),
                            q_csrf_token: _sec_val
                        },
                        success: function(data) {
                            inputDialogDestroy("#dialog-newColl");
                            populateCollections();
                        }
                    });
                },
                Cancel: function() {
                    inputDialogDestroy("#dialog-newColl");
                }
            }
        });
    }

    $(document).ready(function(e) {
        $('#quarx-new-collection').bind('click', function(){
            newCollectionBox();
        });

        populateCollections();
    });

/*
|--------------------------------------------------------------------------
| Document Ready
|--------------------------------------------------------------------------
*/

$(function(){
    $('input:submit').button();

});
