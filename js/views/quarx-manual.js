function pageScroll (box) {
    var destination = $(box).offset().top;
    $("html:not(:animated),body:not(:animated)").animate({ scrollTop: destination-20}, 500 );
    return false;
}

function showMenu(){
    $('#quarx-manual-menu').show();
}

function setMenu(){
    if($(window).width() > 960){

        $(window).scroll(function(){
            $('#quarx-manual-menu').hide();

            $('#quarx-manual-menu').css({
                top: 44 + $(window).scrollTop()
            });

            $('#quarx-manual-menu').fadeIn("fast");
        });

        $('.quarx-manual-content').attr("style", "");
        $('#quarx-manual-menu-title').fadeOut("fast");
    }else{
        $('.quarx-manual-content').css("margin-left", "0");
        $('#quarx-manual-menu-title').hide();
    }
}