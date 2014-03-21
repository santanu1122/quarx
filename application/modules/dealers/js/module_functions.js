$(window).scroll(function(){
    $(".success-box, .error-box").css("top", $(document).scrollTop());
});

(function($) {
    $.fn.draggable = function(opt) {
        //original provided by
        //http://css-tricks.com/snippets/jquery/draggable-without-jquery-ui/

        opt = $.extend({handle:"",cursor:"move"}, opt);

        if(opt.handle === "") {
            var $el = $(this);
        } else {
            var $el = $(this).find(opt.handle);
        }

        return $el.css('cursor', opt.cursor).on("mousedown", function(e) {
            
            $(this).css({width: '200px'});
            $(this).attr('id', 'data-dragging');
            $('.droppable').css({overflow: ''});
            $(this).attr('style', opt.onSelectCSS);

            // window.draggableCarrier = $(this).clone(true);

            if(opt.handle === "") {
                var $drag = $(this).addClass('draggable').attr('data-in-motion', 'yes');
            } else {
                var $drag = $(this).addClass('active-handle').parent().addClass('draggable');
            }
            var z_idx = $drag.css('z-index'),
                drg_h = $drag.outerHeight(),
                drg_w = $drag.outerWidth(),
                pos_y = $drag.offset().top + drg_h - e.pageY,
                pos_x = $drag.offset().left + drg_w - e.pageX;
            
            $drag.css('z-index', 100000).parents().on("mousemove", function(e) {
                $('.draggable').offset({
                    top:e.pageY + pos_y - drg_h,
                    left:e.pageX + pos_x - drg_w
                }).on("mouseup", function() {
                    $(this).removeClass('draggable').css('z-index', z_idx);
                });
            });
            e.preventDefault(); // disable selection
        }).on("mouseup", function() {
            if(opt.handle === "") {
                $(this).removeClass('draggable');
            } else {
                $(this).removeClass('active-handle').parent().removeClass('draggable');
            }
        });
    }

})(jQuery);

(function($) {
    $.fn.droppable = function(opt) {

        $(this).addClass('droppable');

        function deliver(pack, inbox){
            if(inbox.attr('data-retain') == 'true'){
                inbox.append(pack);
                $('#data-dragging').remove();
                inbox.children().removeAttr('style');
            }else{
                $('#data-dragging').removeAttr('style');
            }

            return pack.attr('data-id');
        }

        function drop(result, box){
            box.css({overflow: 'scroll'});
            box.trigger("drop", result);
        }

        /* Main Function
        ***************************************************************/
        if(opt){
            $('.droppable').attr('data-retain', opt.retain);
            $('.droppable').css({overflow: 'scroll'});
        }

        $('.droppable').mouseup(function(e){
            
            var mouse = e;

            $('.droppable').each(function(){

                var currentBox = {};
                    currentBox.t = $(this).offset().top;
                    currentBox.b = $(this).offset().top + $(this).height();
                    currentBox.l = $(this).offset().left;
                    currentBox.r = $(this).offset().left + $(this).width();

                    if( 
                        mouse.pageY > currentBox.t && 
                        mouse.pageY < currentBox.b &&
                        mouse.pageX > currentBox.l && 
                        mouse.pageX < currentBox.r 
                    ){
                        var dbl = $('#data-dragging').clone(true).removeAttr('id');
                        var deliveryBox = $(this);

                        if($('#data-dragging').attr('data-in-motion') == 'yes'){
                            drop(deliver(dbl, deliveryBox), deliveryBox);
                        }

                    }else{
                        
                        $('#data-dragging').removeAttr('style');
                    
                    }
            });

            

        });
    }

})(jQuery);