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

// Thumbnail Image resizing
function quarxThumbnailImageResize() {
    $('.quarx-img-thumb-holder img').each(function(){
        var width = $(this).width(),
            height = $(this).height();

        if(height === width){
            $(this).css({
                marginTop: 0,
                marginLeft: 0,
                height: 120,
                width: 120
            });
        }

        if(height > width){
            var newWidth = ( width * 120 ) / height,
                marginLeft = (120 - newWidth)/2,
                marginTop = -13;

            $(this).css({
                marginTop: 0,
                marginLeft: marginLeft,
                height: 120,
                width: newWidth
            });

            $(this).parent().prev().css("margin-right", "6px");
        }

        if(width > height){

            var newHeight = (height / width) * 120,
                marginTop = (120 - newHeight)/4,
                marginLeft = 0;

            $(this).css({
                marginTop: 26,
                marginLeft: marginLeft,
                width: 120,
                height: newHeight
            });

            $(this).parent().prev().css("margin-top", marginTop);
        }

        $(this).css({opacity: 0.0, visibility: "visible"}).animate({opacity: 1.0}, 200);
    });
}

function strengthCH(pw) {

    // a quick checker to let them know they've made a solid password!
    var val = 0;
    var pwlen = pw.length;

    if(pwlen >= 13){val = 5;}
    else if(pwlen >= 10){val = 4;}
    else if(pwlen >= 8){val = 3;}
    else if(pwlen >= 5){val = 2;}

    var re = [ null, /[a-z]/g, /[A-Z]/g, /\d/g, /[!@#$%\^&amp;\*\(\)=_+-]/g];

    for (var i = 1; i < re.length; i++) {
        val += (pw.match(re[i]) || []).length * i;
    }

    if (val <= 20) {
        quarxNotify("Weak Passowrd", "Your password is weak");
    } else {
        quarxNotify("Strong Passowrd", "Your password is strong");
    }
}

function pwChecker() {
    var pw1 = $("#password").val()
        pw2 = $("#confirm").val();

    if (pw1 != pw2) {
        quarxNotify("Unmatching Passowrds", "Your passwords don't match");
        return false;
    } else {
        quarxNotify("Matching Passowrds", "Your passwords match!");
        return true;
    }
}

function _quarxUnblur() {
    $('#quarx-header, #quarx-body, #quarx-footer').Vague().unblur();
    $(".vague-svg-blur").remove();
    $('#quarx-image-library-screen').hide();
}

function _quarxHideImgLibrary() {
    $("#quarx-image-library").hide();
    _quarxUnblur();
}