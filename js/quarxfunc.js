/* 	quarxfunc.js
	This is the collection of functions utilized in various places throughout the quarx frameworks
*/

// Profile Image resizing
function profileImageResize(){
    var width = $('.profileImageBox img').width(),
        height = $('.profileImageBox img').height();

    if(height == width){
        $('.profileImageBox img').css({
            marginTop: 15,
            marginLeft: ($('.profileImageBox img').parent().width() - 320)/2,
            height: 320,
            width: 320
        });
    }

    else if(height > width){
        var newWidth = ( width * 320 ) / height,
            marginLeft = ($('.profileImageBox img').parent().width() - newWidth)/2,
            marginTop = (350 - 320)/2;

        $('.profileImageBox img').css({
            marginTop: marginTop,
            marginLeft: marginLeft,
            height: 320,
            width: newWidth
        });
    }

    else if(width > height){

        var newHeight = ( height/width ) * 350,
            marginTop = (350 - newHeight)/2,
            marginLeft = ($('.profileImageBox img').parent().width() - 350)/2;

        $('.profileImageBox img').css({
            marginTop: marginTop,
            marginLeft: marginLeft,
            width: 320,
            height: newHeight
        });
    }
}

// Profile Image resizing
function thumbnailImageResize(){
    $('.imgThumbHolder img').each(function(){
        var width = $(this).width(),
            height = $(this).height();

        if(height === width){
            $(this).css({
                marginTop: -10,
                marginLeft: 0,
                height: 114,
                width: 114
            });
        }

        if(height > width){
            var newWidth = ( width * 114 ) / height,
                marginLeft = (114 - newWidth)/2,
                marginTop = -10;

            $(this).css({
                marginTop: marginTop,
                marginLeft: marginLeft,
                height: 114,
                width: newWidth
            });

        }

        if(width > height){

            var newHeight = ( height/width ) * 114,
                marginTop = -13,
                marginLeft = 0;

            $(this).css({
                marginTop: marginTop,
                marginLeft: marginLeft,
                width: 114,
                height: newHeight
            });
        }
    });
}

function dialogDestroy(idTag){
    $(idTag+'_dialog-header').remove();
    $(idTag+' .dialogbox_body').remove(); 
    $(idTag).hide();
    $('#quarx-modal').fadeOut();
}

function inputDialogDestroy(idTag){
    $(idTag+'_dialog-header').remove();
    $(idTag+' .dialogbox_body_btns').remove(); 
    $(idTag).hide(); 
    $('#quarx-modal').fadeOut();
}

(function($){  
    $.fn.dialogbox = function(options) {
        var defaults = {  
            ok: '',  
            buttons: {}
        };  
        options = $.extend(defaults, options);  

        var idTag = $(this).attr('id');
            coreTxt = $(this).html();
        
        /* Modal Part
        ***************************************************************/

        $('#quarx-modal').show();
        $('#quarx-modal').bind('click', function(){
            dialogDestroy('#'+idTag);
            $('#quarx-modal').fadeOut();
        });

        if(options.modal !== true){
            $('#quarx-modal').css('background', 'none');
        }else{
            $('#quarx-modal').css('background', '#333');
        }

        if($(this).attr('data-copy') > ''){
            coreTxt = $(this).attr('data-copy');
        }else{
            $(this).attr('data-copy', $(this).html());
        }

        if(options.buttons){

            $(this).html('');
            $(this).append('<div class="dialogbox_body"></div>');
            $('#'+idTag).prepend('<div class="dialogbox_header" id="'+idTag+'_dialog-header"><h1>'+$(this).attr('title')+'</h1></div>');
            $('#'+idTag+ ' .dialogbox_body').append(coreTxt);
            $('#'+idTag+ ' .dialogbox_body').append('<button data-theme="a" data-role="button" id="'+idTag+'_okBtn">Ok</button><button data-theme="a" data-role="button" id="'+idTag+'_CnclBtn">Cancel</button>').trigger('create');

            $('#'+idTag+'_okBtn').click( options.buttons.Ok );
            $('#'+idTag+'_CnclBtn').click( options.buttons.Cancel );

            if(!options.buttons.Ok){
                $('#'+idTag+'_okBtn').parent().remove();
            }

            if(!options.buttons.Cancel){
                $('#'+idTag+'_CnclBtn').parent().remove();
            }

        }

        $(this).css({
            marginLeft: ($(window).width() - 287)/2,
            marginTop: ($(window).height() - 287)/2
        });

        $(this).fadeIn();
    }  
})(jQuery);

(function($){  
    $.fn.dialogboxInput = function(options) {
        var defaults = {  
            ok: '',
            web_link: '',
            buttons: {}
        };  
        options = $.extend(defaults, options);  

        var idTag = $(this).attr('id'),
            coreTxt = $(this).html(),
            linkBox = '';

        inputDialogDestroy('#'+idTag);

        if($(this).attr('data-copy') > ''){
            coreTxt = $(this).attr('data-copy');
        }else{
            $(this).attr('data-copy', $(this).html());
        }

        if(options.web_link == false){
            linkBox = '';
        }else{
            linkBox = '<p>Web Link: <input value="'+options.web_link+'" /></p>';
        }

        $('#'+idTag).prepend('<div class="dialogbox_header" id="'+idTag+'_dialog-header"><h1>'+$(this).attr('title')+'</h1></div>');
        $('#'+idTag+ ' .dialogbox_body').append('<div class="dialogbox_body_btns">'+linkBox+'<button data-theme="a" data-role="button" id="'+idTag+'_okBtn">Ok</button><button data-theme="a" data-role="button" id="'+idTag+'_CnclBtn">Cancel</button></div>').trigger('create');

        $('#'+idTag+'_okBtn').click( options.buttons.Ok );
        $('#'+idTag+'_CnclBtn').click( options.buttons.Cancel );

        if(!options.buttons.Cancel){
            $('#'+idTag+'_CnclBtn').remove();
        }

        $(this).css({
            marginLeft: ($(window).width() - 287)/2,
            marginTop: ($(window).height() - 287)/2
        });

        $(this).fadeIn();
    }  
})(jQuery);

$(document).ready(function(){
    $(window).resize(function() {
        setTimeout(profileImageResize, 200);
    });
});