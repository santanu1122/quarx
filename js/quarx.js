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
    var _redactor_active = true;

    $(".deefault").deefault();

    var browser = navigator.userAgent;
    var IEpattern = new RegExp("MSIE ([0-9]{1,}[\.0-9]{0,})");

    if (IEpattern.test(browser)) {
        var versionNumber = RegExp.$1;

        if (versionNumber == '8.0') {
            _redactor_active = false;
        }
    }

    if (_redactor_active) {
        $('textarea.rtf').redactor({
            minHeight: 275
        });
    };

    if ($(window).width() > 600) {
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
        $('.quarx-device').css("width", "auto");
    }

    $(".quarx-popup").css({
        width: $(window).width() * 0.9,
        height: $(window).height() * 0.8,
    });

    $("#quarx-body").css("min-height", ($(window).height() - 50)+"px");

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

        if (_quarxBlurBG == true) {
            $('#quarx-header, #quarx-body, #quarx-footer').Vague({
                intensity: 4,
            }).blur();
        };

        $(".ui-popup-screen, #quarx-close-image-library").click(function(){
            $('#quarx-header, #quarx-body, #quarx-footer').Vague().unblur();
            $(".vague-svg-blur").remove();
        });

        setTimeout(function(){
            $("#quarx-image-library-popup").css({
                marginTop: ($(window).height() * 0.05),
                marginLeft: ($(window).width() * 0.05),
                left: 0,
                top: 0
            });
        }, 5);
    });
});