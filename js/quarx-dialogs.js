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

function destroyDialogs() {
    $('.dialogBox').hide();
}

(function($){
    $.fn.dialogbox = function(options) {

        $("html, body").animate({ scrollTop: 0 }, "slow");

        destroyDialogs();

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
            left: ($(window).width() - 260)/2,
            top: (($(window).height() - $(this).height())/2) - 40
        });

        $(this).prependTo("#quarx-wrapper");

        $(this).show();
    }

})(jQuery);

(function($){
    $.fn.dialogboxInput = function(options) {

        destroyDialogs();

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

        if(!options.buttons.Cancel){
            $('#'+idTag+'_CnclBtn').remove();
        }

        $(this).css({
            left: ($(window).width() - 260)/2,
            top: (($(window).height() - $(this).height())/2) - 40
        });

        $(this).prependTo("#quarx-wrapper");

        $(this).show();
    }

})(jQuery);