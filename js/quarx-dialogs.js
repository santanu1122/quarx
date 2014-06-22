/**
 * Quarx
 *
 * A modular application structure built on CodeIgniter
 *
 * @package     Quarx
 * @author      Matt Lantz
 * @copyright   Copyright (c) 2013 - 2014 Matt Lantz
 * @license     https://ottacon.co/docs/quarx/license.html
 * @link        https://github.com/mlantz/quarx
 * @since       Version 1.0
 *
 */

_magical_dialog_cursor_pos = 0;

function dialogDestroy(idTag) {
    $(idTag+'_dialog-header').remove();
    $(idTag+' .dialogbox_body').remove();
    $(idTag).hide();
    $('#quarx-modal').hide();
    $('#quarx-header, #quarx-body, #quarx-footer').Vague().unblur();
    $(".vague-svg-blur").remove();
}

function inputDialogDestroy(idTag) {
    $(idTag+'_dialog-header').remove();
    $(idTag+' .dialogbox_body_btns').remove();
    $(idTag).hide();
    $('#quarx-modal').hide();
    $('#quarx-header, #quarx-body, #quarx-footer').Vague().unblur();
    $(".vague-svg-blur").remove();
}

$(document).mousemove(function(e){
    _magical_dialog_cursor_pos = { x: e.pageX, y: e.pageY };
});

function destroyDialogs() {
    $('.dialogBox').hide();
}

(function($){
    $.fn.dialogbox = function(options) {

        destroyDialogs();

        var evt = _magical_dialog_cursor_pos;

        var defaults = {
            ok: '',
            buttons: {}
        };

        options = $.extend(defaults, options);

        var idTag = $(this).attr('id');
            coreTxt = $(this).html();

        $('#quarx-modal').show();
        $('#quarx-modal').bind('click', function(){
            dialogDestroy('#'+idTag);
            $('#quarx-modal').hide();
        });

        if (_quarxBlurBG == true) {
            $('#quarx-header, #quarx-body, #quarx-footer').Vague({
                intensity: 4,
            }).blur();
        };

        if(options.modal !== true){
            $('#quarx-modal').css('background', 'none');
        }else{
            $('#quarx-modal').css('background', '#FFF');
        }

        if($(this).attr('data-copy') > ''){
            coreTxt = $(this).attr('data-copy');
        }else{
            $(this).attr('data-copy', $(this).html());
        }

        if (options.buttons) {
           $("#"+idTag).html('');
            $('#'+idTag).prepend('<div class="dialogbox_header" id="'+idTag+'_dialog-header"><h1>'+$(this).attr('title')+'</h1></div>');
            $('#'+idTag).append('<div class="dialogbox_body"></div>');

            $('#'+idTag+ ' .dialogbox_body').append(coreTxt).trigger('create');

            if (typeof(options.buttons.Ok) == 'function') {
                $('#'+idTag+ ' .dialogbox_body').append('<button data-theme="a" data-role="button" id="'+idTag+'_okBtn">Ok</button>').trigger('create');
            }

            if (typeof(options.buttons.Cancel) == 'function') {
                $('#'+idTag+ ' .dialogbox_body').append('<button data-theme="a" data-role="button" id="'+idTag+'_CnclBtn">Cancel</button>').trigger('create');
            }

            $('#'+idTag+'_okBtn').click( options.buttons.Ok );
            $('#'+idTag+'_CnclBtn').click( options.buttons.Cancel );
        }

        var heightAdjustment = $(this).height()/2;

        var dialogPosY = evt.y - heightAdjustment;
        if (dialogPosY < 50) {
            dialogPosY = 50;
        };

        $(this).css({
            left: ($(window).width() - 260)/2,
            top: dialogPosY,
        });

        $(this).prependTo("#quarx-wrapper");

        $(".deefault").deefault();

        $(this).show();
    }

})(jQuery);

(function($){
    $.fn.dialogboxInput = function(options) {

        destroyDialogs();

        var evt = _magical_dialog_cursor_pos;

        console.log(evt.y)

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

        $('#quarx-modal').show();
        $('#quarx-modal').bind('click', function(){
            inputDialogDestroy('#'+idTag);
            $('#quarx-modal').hide();
        });

        if (_quarxBlurBG == true) {
            $('#quarx-header, #quarx-body, #quarx-footer').Vague({
                intensity: 4,
            }).blur();
        };

        $('#'+idTag).Vague().unblur()

        if ($(this).attr('data-copy') > '') {
            coreTxt = $(this).attr('data-copy');
        } else {
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

        var heightAdjustment = $(this).height()/2;

        var dialogPosY = evt.y - heightAdjustment;
        if (dialogPosY < 50) {
            dialogPosY = 50;
        };

        $(this).css({
            left: ($(window).width() - 260)/2,
            top: dialogPosY,
        });

        $(this).prependTo("#quarx-wrapper");

        $(".deefault").deefault();

        $(this).show();
    }

})(jQuery);