/*
 * tooltip 0.1
 * jQuery Plugin
 *
 * Author:     Matt Lantz
 * Purpose:    To have floating comments that popup while
 *             hovering over elements.
 *
 */

;(function($){

    $.fn.tooltip = function(options) {

        var defaults = {
            boxWidth: 200,
            background: "#333",
            zIndex: "100000",
            border: "2px solid #EEE",
            textColor: "#FFF",
            textPositon: "center"
        };

        var options = $.extend(defaults, options);

        /* Create Tip Box
        *************************************/

        var time = new Date().getTime(),
            toolTipBox = "toolTipBox_"+time;

        $("body").append('<div id="'+toolTipBox+'"></div>');

        $("#"+toolTipBox).css({
            width: options.boxWidth,
            background: options.background,
            position: 'absolute',
            zIndex: options.zIndex,
            display: 'none',
            borderRadius: "5px",
            border: options.border,
            textAlign: options.textPositon
        });

        $(this).each(function(){

            $(this).bind("mouseover", function(e){

                $("#"+toolTipBox).html("<p>"+$(this).attr("data-tooltip")+"</p>");

                $("#"+toolTipBox+" p").css({
                    color: options.textColor,
                    lineHeight: "35px",
                    margin: 0,
                    padding: "2px 8px",
                    fontFamily: "Arial"
                });

                var leftPos = e.pageX+36;

                if(leftPos+options.boxWidth > $(window).width()){
                    leftPos = leftPos - (options.boxWidth + 36);
                }

                $("#"+toolTipBox).css({
                    top: e.pageY+36,
                    left: leftPos
                });

                $("#"+toolTipBox).show();

                setTimeout(function(){ $("#"+toolTipBox).fadeOut("fast"); }, 3000);

            });

            $(this).bind("click", function(){

                $("#"+toolTipBox).fadeOut();

            });

        });

    }

})(jQuery);