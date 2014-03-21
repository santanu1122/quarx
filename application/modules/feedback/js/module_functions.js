//IE8 hacks - I hate IE with all my soul!
if (!Array.prototype.indexOf)
{
  Array.prototype.indexOf = function(elt /*, from*/)
  {
    var len = this.length >>> 0;

    var from = Number(arguments[1]) || 0;
    from = (from < 0)
         ? Math.ceil(from)
         : Math.floor(from);
    if (from < 0)
      from += len;

    for (; from < len; from++)
    {
      if (from in this &&
          this[from] === elt)
        return from;
    }
    return -1;
  };
}

/*  ***************************************

tothestars 0.1
JQuery Plugin

Author: Matt Lantz
To The Stars is a bootstrap star rating tool.
 
****************************************** */

(function($){  
    $.fn.tothestars = function(options) {  
        
    /* Setup 
    ***************************************************************/
        var defaults = {   
            startAt: 0,
            deadStarBackground: '#333',
            liveStarBackground: '#F00'
        };  
        
        var options = $.extend(defaults, options);
        var div = $(this).attr('id'),
            defaultClass = $('#'+div+' li').attr('class'),
            i = 1;

        //Such a simple way of placing the style details in the document
        $('<style type="text/css">/* Added by tothestars */ #'+div+' li{ float: left; background: '+options.deadStarBackground+' } #'+div+' li:hover, #'+div+' li.highlighted{ float: left; background: '+options.liveStarBackground+' } </style>').appendTo("head");

        $(this).attr('data-current-rating', options.startAt);

        $('#'+div+' li').each(function(){
            $(this).attr('data-num', i);
            i++;
        });

        $('#'+div+' li').mouseover(function(){
            highlightStars($(this).attr('data-num'));
        });

        $('#'+div+' li').mouseout(function(){
            clearStars();
            highlightDefaultStars($('#'+div).attr('data-current-rating'));
        });
    
        $('#'+div+' li').bind('click', function(){
            setCurrentRating($(this).attr('data-num'));
        });

        $('#'+div).append('<input id="'+div+'_hidden_input" name="'+div+'" type="hidden" value="" />');

    /* Inner Functions
    ***************************************************************/

        function setCurrentRating(num){
            clearStars();
            highlightStars(num);
            hiddenInput(num);
            $('#'+div).attr('data-current-rating', num);
        }

        function highlightStars(num){
            $('#'+div+' li').each(function(){
                if($(this).attr('data-num') <= num){
                    $($(this).attr('class', defaultClass+' highlighted'));
                }
            });
        }

        function highlightDefaultStars(num){
            $('#'+div+' li').each(function(){
                if($(this).attr('data-num') <= num){
                    $($(this).attr('class', defaultClass+' highlighted'));
                    $('#'+div+'_hidden_input').val(num);   
                }
            });
        }

        function clearStars(){
            $('#'+div+' li').each(function(){
                $($(this).attr('class', defaultClass+''));
            });
        }

        function hiddenInput(num){
            $('#'+div+'_hidden_input').val(num);
        }

    /* Run
    ***************************************************************/

        highlightDefaultStars($('#'+div).attr('data-current-rating'));
        
    };  
    
})(jQuery);  