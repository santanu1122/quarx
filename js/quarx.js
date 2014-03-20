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

$.ajaxSetup({
    cache: false
});

$.mobile.ajaxEnabled = false;
$.mobile.loadingMessage = false;
$.mobile.selectmenu.prototype.options.nativeMenu = false;

$(document).bind('mobileinit',function(){
    $.mobile.selectmenu.prototype.options.hidePlaceholderMenuItems = false;
});

function _quarx_loading() {
    $("#quarx-modal, #fountainG").show();
}

$(document).ready(function() {
    var quarxFrame = "";

    $(".deefault").deefault();

    $('textarea.rtf').redactor({
        minHeight: 275
    });

    if($(window).width() > 600){
        $(".quarx-top-menu-icons").tooltip();
    }

    $('#password').keyup(function(){
        strengthCH($('#password').val());
    });

    $('#confirm').keyup(function(){
        strengthCH($('#confirm').val());
        pwChecker();
    });

    $("#changeBtn").click(function(event){
        event.preventDefault();
        if (pwChecker()) {
            $('#pwChanger').submit();
        }
    });

    if ( ! window.frameElement) {
        quarxFrame = 'main';
    } else {
        quarxFrame = window.frameElement.getAttribute('data-location');
    }

    if (quarxFrame == 'panel') {
        $('#quarx-benchmarking').remove();
        $('#quarx-benchmarking').remove();
        $('.quarx-top-menu-icons').remove();
    }

    $(".quarx-popup").css({
        width: $(window).width() * 0.9,
        height: $(window).height() * 0.8,
    });

    $("#quarx-image-library-button").click(function(){
        var windowXMargin = ($(window).width() * 0.05),
            windowYMargin = ($(window).height() * 0.05),
            windowWidth = $(window).width() * 0.9,
            windowHeight = $(window).height() * 0.8;

        $(".quarx-img-box, #quarx-image-library").css({
            width: windowWidth,
            height: windowHeight,
        });

        $("#quarx-image-library").css("display", "block");

        $('#quarx-header, #quarx-body, #quarx-footer').Vague({
            intensity: 4,
        }).blur();

        $(".ui-popup-screen, #quarx-close-image-library").click(function(){
            $('#quarx-header, #quarx-body, #quarx-footer').Vague().unblur();
            $(".vague-svg-blur").remove();
        });

        setTimeout(function(){
            $(".ui-popup-container").css({
                marginTop: ($(window).height() * 0.05),
                marginLeft: ($(window).width() * 0.05),
                left: 0,
                top: 0
            });
        }, 5);
    });
});