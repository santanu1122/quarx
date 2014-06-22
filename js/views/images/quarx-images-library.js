/**
 * Quarx
 *
 * A modular CMS application
 *
 * @package     Quarx
 * @author      Matt Lantz
 * @copyright   Copyright (c) 2013 - 2014 Matt Lantz
 * @license     https://ottacon.co/docs/quarx/license.html
 * @link        https://github.com/mlantz/quarx
 * @since       Version 1.0
 *
 */

function setTags(id) {
    $('#dialog-alt').attr('data-imageId', id);
    $('#dialog-alt').attr('data-enc-id', $("#"+id).attr("data-enc-id"));

    $( "#dialog-alt" ).dialogboxInput({
        web_link: $('#'+id).attr('data-web-link'),
        buttons: {
            Ok: function() {
                var alt = $('#pic_alt_tag').val(),
                    title = $('#pic_title_tag').val();

                $.ajax({
                    url: _quarxRootURL+"images/set_alt_title",
                    type: 'POST',
                    data: { pic_id: id, pic_alt: alt, pic_title: title, q_csrf_token: _quarxSecurityHash },
                    success: function(msg) {
                        inputDialogDestroy( "#dialog-alt" );

                        $('#'+id).attr('onclick', 'updateTags("'+id+'")');

                        $('#dialog-alt').attr('data-imageId', '');

                        $("#"+id).attr("alt", alt);
                        $("#"+id).attr("title", title);
                    }
                });
            },
            Cancel: function() {
                $('#dialog-alt').attr('data-imageId', '');
                inputDialogDestroy( "#dialog-alt" );
            }
        }
    });
}

function updateTags(id) {
    var alt = $('#pic_alt_tag').val(),
        title = $('#pic_title_tag').val();

    $.ajax({
        url: _quarxRootURL+"images/get_alt_title",
        type: 'GET',
        data: { pic_id: id },
        success: function(data) {
            var imgDetails = jQuery.parseJSON(data),
                current_alt = imgDetails.alt_tag,
                current_title = imgDetails.title_tag;

            $('#update_pic_alt_tag').val(current_alt);
            $('#update_pic_title_tag').val(current_title);

            $('#dialog-update-alt').attr('data-imageId', id);
            $('#dialog-update-alt').attr('data-enc-id', $("#"+id).attr("data-enc-id"));

            $( "#dialog-update-alt" ).dialogboxInput({
                web_link: $('#'+id).attr('data-web-link'),
                buttons: {
                    Ok: function() {
                        var alt = $('#update_pic_alt_tag').val(),
                            title = $('#update_pic_title_tag').val();

                        $.ajax({
                            url: _quarxRootURL+"images/set_alt_title",
                            type: 'POST',
                            data: { pic_id: id, pic_alt: alt, pic_title: title, q_csrf_token: _quarxSecurityHash },
                            success: function(msg) {
                                $('#'+id).attr('onclick', 'updateTags("'+id+'")');

                                inputDialogDestroy("#dialog-update-alt");

                                $('#dialog-update-alt').attr('data-imageId', '');

                                $("#"+id).attr("alt", alt);
                                $("#"+id).attr("title", title);
                            }
                        });
                    },
                    Cancel: function() {
                        $('#dialog-update-alt').attr('data-imageId', '');
                        inputDialogDestroy( "#dialog-update-alt" );
                    }
                }
            });
        }
    });
}

function changeMe() {
    if ($('#dialog-update-alt').attr('data-imageId') > '') {
        window.location = _quarxRootURL+"images/change/"+$('#dialog-update-alt').attr('data-enc-id');
    }

    if ($('#dialog-alt').attr('data-imageId') > '') {
        window.location = _quarxRootURL+"images/change/"+$('#dialog-alt').attr('data-enc-id');
    }
}

function loadImages(collectionId) {
    $.ajax({
        url: _quarxRootURL+"images/get_collection_images/"+collectionId,
        type: 'GET',
        cache: false,
        dataType: 'html',
        success: function(data) {
            $('.library-container').html(data);
            setTimeout(function(){ quarxThumbnailImageResize(); }, 150);

            $("button").buttonMarkup();
            $('input[type="checkbox"]').checkboxradio();
        }
    });
}

function loadCollection(collectionId) {
    $.ajax({
        url: _quarxRootURL+"images/get_collection_order/"+collectionId,
        type: 'GET',
        cache: false,
        dataType: 'html',
        success: function(data) {
            $('.order-container').html(data);
            setTimeout(function(){ quarxThumbnailImageResize(); }, 150);

            $("button").buttonMarkup();
            $("select").selectmenu();
            $('input[type="checkbox"]').checkboxradio();

            collectionSetterBinder();
        }
    });
}

function setImageCollectionOrder(order, img) {
    $.ajax({
        url: _quarxRootURL+"images/set_collection_order/"+img+"/"+order,
        type: 'GET',
        cache: false,
        dataType: 'html',
        success: function(data) {
            console.log("cool");
        }
    });
}

function collectionSetterBinder() {
    $(".collection_order_setter").each(function(){
        $(this).bind("change", function(){
            setImageCollectionOrder($(this).val(), $(this).attr("data-img-id"));
            loadCollection($('#collectionsOrder').val());
        });
    });
}

function publishQuarxImage(id, img_id) {
    var publishState = "false";

    if ($('input[data-img-id="'+img_id+'"]').attr("checked")) {
        publishState = "true";
    }

    $.ajax({
        url: _quarxRootURL+"images/publish_image/"+id+"/"+publishState,
        type: 'GET',
        cache: false,
        dataType: 'html'
    });
}

$(function() {
    $('#collections').bind('change', function(){
        _collectionID = $(this).val();
        loadImages(_collectionID);
    });

    $('#collectionsOrder').bind('change', function(){
        _collectionID = $(this).val();
        loadCollection(_collectionID);
    });

    collectionSetterBinder();
});