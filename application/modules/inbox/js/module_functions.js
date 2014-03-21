//Javascript goes here

$(window).scroll(function(){
    $(".success-box, .error-box").css("top", $(document).scrollTop());
});

$(function(){
    $("#find-users").parent().css({
        "border-radius" : "0px",
        margin: 0
    });
});