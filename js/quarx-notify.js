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

// Notifications Growl style
function quarxNotify(title, message) {

    $("html, body").animate({ scrollTop: 0 }, "slow");

    switch(title)
    {
        case "Error":
        $(".quarx-notify-title").css("color", "#F00");
        break;

        case "Warning":
        $(".quarx-notify-title").css("color", "#e5c100");
        break;

        case "Info":
        $(".quarx-notify-title").css("color", "#333");
        title = "Notification";
        break;

        default:
        $(".quarx-notify-title").css("color", "#333");
    }

    $(".quarx-notify-title").html(title);
    $(".quarx-notify-comment").html(message);
    if ($(".quarx-notification").css("right") != "20px") {
        $(".quarx-notification").clearQueue();
        $(".quarx-notification").animate({
            right: "20px"
        });
    };

    $(".quarx-notify-closer-icon, #quarx-header, #quarx-body, #quarx-footer").click(function(){
        $(".quarx-notification").clearQueue();
        if ($(".quarx-notification").css("right") != "-300px") {
            $(".quarx-notification").animate({
                right: "-300px"
            },"", function(){
                $(".quarx-notify-title").removeAttr("style");
                $(".quarx-notify-title").html("");
                $(".quarx-notify-comment").html("");
            });
        };
    });
}