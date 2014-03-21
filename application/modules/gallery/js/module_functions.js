//Javascript goes here

$(window).scroll(function(){
    $(".success-box, .error-box").css("top", $(document).scrollTop());
});