/*  
 * deefault 0.1
 * jQuery Plugin
 *
 * Author:     Matt Lantz
 * Purpose:    To have a default data holder for 
 *             inputs, for clicks, blurs and keyups
 *
 */

;(function($){

    $.fn.deefault = function(options) { 
        
        var defaults = {   
            initColor: "#BBB",
            typedColor: "#000",
            borderWarning: false,
            borderColor: "#F00"
        };  
        
        var options = $.extend(defaults, options);

        /* Filler Lable - Inital Value Setting
        *************************************/

        $(this).each(function(){
            if($(this).attr("type") != "hidden"){
                $(this).attr("data-o-type", $(this).attr("type"));

                if($(this).attr("type") != 'text'){
                    $(this).attr("type", "text");
                }

                $(this).css("color", options.initColor);
                $(this).val($(this).attr("data-deefault"));
            }
        });

        /* Filler Label - Bindings
        *************************************/

        $(this).bind("click", function(){
            $(this).attr("type", $(this).attr("data-o-type"));
            if($(this).val() == $(this).attr("data-deefault")){
                $(this).val("");
                $(this).css("color", options.typedColor);

                if(options.borderWarning){
                    $(this).css("borderColor", "");
                }
            }
        });

        $(this).bind("blur", function(){
            if($(this).val() == ""){
                $(this).attr("type", "text");
                $(this).val($(this).attr("data-deefault"));
                $(this).css("color", options.initColor);

                if(options.borderWarning){
                    $(this).css("borderColor", options.borderColor);
                }
            }
        });

        $(this).bind("keyup", function(){
            if($(this).val() == ""){
                $(this).attr("type", "text");
                $(this).val($(this).attr("data-deefault"));
                $(this).css("color", options.initColor);

                if(options.borderWarning){
                    $(this).css("borderColor", options.borderColor);
                }
            }
        });

        $(this).bind("keydown", function(){
            $(this).attr("type", $(this).attr("data-o-type"));
            if($(this).val() == $(this).attr("data-deefault")){
                $(this).val("");
                $(this).css("color", options.typedColor);

                if(options.borderWarning){
                    $(this).css("borderColor", "");
                }
            }
        });

        /* Input Type
        ***************************************************************/

        $(this).each(function(){
            if($(this).attr("data-deefault-type") == "phone"){     
                $(this).bind("keyup", function(){
                    $(this).val($(this).val().replace(/[^0-9]/g, ''));
                });
            }

            if($(this).attr("data-deefault-type") == "email"){

                var email = /\S+@\S+\.\S+/;

                $(this).bind("keyup", function(){
                    if(!email.test($(this).val())){
                        $(this).css("borderColor", options.borderColor);
                    }else{
                        $(this).css("borderColor", "");
                    }
                });
            }
        });
    }



})(jQuery);