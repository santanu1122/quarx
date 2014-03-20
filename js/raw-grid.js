(function($){
    $.fn.raw_responsive = function(options) {

        var defaults = {
            css: "css/raw",
            domain: document.domain
        };

        var options = $.extend(defaults, options);

        function _raw_resize() {
            if ($(window).width() < 1024 && $(window).width() > 732) {
                $("div[class^='raw-grid-col-").each(function(){
                    $(this).css("width", "342px");
                });
            } else {
                $("div[class^='raw-grid-col-").removeAttr('style');
            }

            $("div[class^='raw-grid-col-']").each(function(){
                if ($(this).position().left == $(this).parent().position().left) {
                    $(this).removeClass("raw-grid-col-child");
                } else {
                    $(this).addClass("raw-grid-col-child");
                }
            });
        }

        function _raw_init() {
            $(".raw-grid-row").children("div[class^='raw-grid-col-']").addClass("raw-grid-col-child");

            $(".raw-grid-row").children("div[class^='raw-grid-col-']:first").css({
                margin: "0 0 0 0"
            });

            $(window).bind("resize", function(){
                _raw_resize();
            });
        }

        $(function(){
            _raw_init();

            setTimeout(function(){
                _raw_resize();
            }, 100);
        });
    }
})(jQuery);