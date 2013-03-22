/*	***************************************

jquery.spinner.js 0.1
JQuery Plugin

Author: Matt Lantz
Purpose: A polite little reminder that something
is working.
 
****************************************** */

(function($){
	$.fn.spinner = function(options) {

		var defaults = {  
       		time: 6000
      	};  
      
	  	var options = $.extend(defaults, options); 
		
		var uniqueifierStamp = 115911022012,
 		bg = document.getElementById(uniqueifierStamp+'blankpage');

	 	if(bg){
	 		document.body.removeChild(document.getElementById(uniqueifierStamp+'blockerbox'));
			document.body.removeChild(document.getElementById(uniqueifierStamp+'blankpage'));
	 	}

 		//define the object
		var blankpage = document.createElement('div');
			blankpage.setAttribute('id', uniqueifierStamp+'blankpage');
			blankpage.style.width = $(document).width()+'px';
			blankpage.style.height = $(document).height()+'px';
			blankpage.style.position= 'absolute';
			blankpage.style.top = '0';
			blankpage.style.left = '0';
			blankpage.style.margin = '0px';
			blankpage.style.padding = '0px';
			blankpage.style.background = '#000';
			blankpage.style.opacity = 0.9;
			blankpage.style.textAlign = 'center';
			//apply object to document
			document.body.appendChild(blankpage);

		//generate box
		var blockerbox = document.createElement('div');
			blockerbox.setAttribute('id', uniqueifierStamp+'blockerbox');
			blockerbox.style.width = '100px';
			blockerbox.style.height = '100px';
			blockerbox.style.position = 'fixed';
			blockerbox.style.top = (($(window).height()/2)-60)+'px';
			blockerbox.style.left = (($(window).width()/2)-50)+'px';
			blockerbox.style.textAlign = 'center';
			//apply box to document
			document.body.appendChild(blockerbox);
		
		//In order to clean up our mess!	
		blankpage.onclick = function (){ 
			blockerbox.style.display = 'none';
			blankpage.style.display = 'none';
		};
	 	
		function ball(id, pos, color, opacity){
			var b = document.getElementById(id);
			if(!b){
				var ball = document.createElement('div');
				ball.setAttribute('id', id);
				ball.style.width = '20px';
				ball.style.height = '20px';
				ball.style.background = color;
				ball.style.border = 'none';
				ball.style.position = 'absolute';
				ball.style.display = 'block';
				ball.style.opacity =  opacity;
				ball.style.borderRadius = '10px';
				ball.style.margin = pos;
				document.getElementById(uniqueifierStamp+'blockerbox').appendChild(ball);
				}
			}

		var ball_1 = new ball("1", "40px 10px", "#ccc", "0.9"),
			ball_2 = new ball("2", "20px 20px", "#ddd", "1.0"),
			ball_3 = new ball("3", "10px 40px", "#000", "0.2"),
			ball_4 = new ball("4", "20px 60px", "#333", "0.4"),
			ball_5 = new ball("5", "40px 70px", "#555", "0.5"),
			ball_6 = new ball("6", "60px 60px", "#777", "0.6"),
			ball_7 = new ball("7", "70px 40px", "#aaa", "0.7"),
			ball_8 = new ball("8", "60px 20px", "#bbb", "0.8");

		var spinDeg = ((defaults.time/750)*360);

		function spinInducer(){
			document.getElementById(uniqueifierStamp+'blockerbox').style.webkitTransition = 'all '+defaults.time+'ms linear';
			document.getElementById(uniqueifierStamp+'blockerbox').style.webkitTransform = 'rotate('+spinDeg+'deg)';
		}

		setTimeout(spinInducer, 10); // I have no idea why it wont work without this. It's like it needs a kick in the mouth.

	}

})(jQuery);/*	***************************************

gwtt 0.1
JQuery Plugin

Author: Matt Lantz
Purpose: A nice little tool to alert the user
to update their outdated browser. ASAP!
 
****************************************** */

(function($){
 	var result = false,
		browserTitle = "",
		versionNumber = 0,
		browser = navigator.userAgent,
		version = navigator.appVersion,
		platform = navigator.platform,
		IEpattern = new RegExp("MSIE ([0-9]{1,}[\.0-9]{0,})"),
		FFpattern = new RegExp("Firefox/([0-9]{1,}[0-9]{1,}[\.0-9]{0,})"),
		Cpattern = new RegExp("Chrome/([0-9]{1,}[0-9]{1,}[\.0-9]{0,})");

		if(IEpattern.test(browser)){
			browserTitle = "Internet Explorer";
		}
		if(FFpattern.test(browser)){
			browserTitle = "Firefox";
		}
		if(Cpattern.test(browser)){
			browserTitle = "Chrome";
		}

	function blocked(versionNumber){

		document.body.innerHTML = "";

		var blankpage = document.createElement('div');
		blankpage.setAttribute('id', '_____blankpage');
		blankpage.style.width = "100%";
		blankpage.style.height = "100%";
		blankpage.style.position= 'absolute';
		blankpage.style.top = '0';
		blankpage.style.left = '0';
		blankpage.style.margin = '0px';
		blankpage.style.padding = '0px';
		blankpage.style.background = '#333';
		blankpage.style.textAlign = 'center';

		document.body.appendChild(blankpage);

		var blockerbox = document.createElement('div');
		blockerbox.setAttribute('id', '_____blockerbox');
		blockerbox.style.width = '300px';
		blockerbox.style.height = '320px';
		blockerbox.style.margin = '100px auto';
		blockerbox.style.background = '#EEE';
		blockerbox.style.border = '10px solid #666';
		blockerbox.style.borderRadius = '15px';					// There is a huge joke in this
		blockerbox.style.boxShadow = '0px 0px 15px #111';		// Same here, what do you think it is?
		blockerbox.style.textAlign = 'center';
		blockerbox.style.fontFamily = "Arial";

		document.getElementById('_____blankpage').appendChild(blockerbox);

		document.getElementById('_____blockerbox').innerHTML = '<p style="margin-top: 20px; padding: 5px 15px; line-height: 1.5em;">Whoa slow down! <br /> We\'re not trying to be rude but you need to upgrade your browser.</p><p style="line-height: 1.5em;">You\'re currently using <br style="line-height: 1.5em;" /> '+browserTitle+' '+versionNumber+'</p><p style="line-height: 1.5em;"><br style="line-height: 1.5em;" />: (</p><br style="line-height: 1.5em;" /><p style="line-height: 1.5em;"><a style="line-height: 1.5em;" href="http://windows.microsoft.com/ie"><b>Internet Explorer</b></a></p><p><b><a style="line-height: 1.5em;" href="http://getfirefox.com">Firefox</a><b></p><p><b><a href="http://google.com/chrome">Chrome</a><b></p>';

		console.log("Your browser is too old my friend. Time to get a new one perhaps.")
	}

	if(IEpattern.test(browser)){
		var versionNumber = RegExp.$1;
		if(versionNumber == '4.0'){
			blocked(versionNumber);
		}
		if(versionNumber == '5.0'){
			blocked(versionNumber);
		}
		if(versionNumber == '6.0'){
			blocked(versionNumber);
		}
		if(versionNumber == '7.0'){
			blocked(versionNumber);
		}
	}

	if(FFpattern.test(browser)){
		versionNumber = RegExp.$1;
		if(versionNumber <= '14.0'){
			blocked(versionNumber);
		}
	}

	if(Cpattern.test(browser)){
		versionNumber = RegExp.$1;
		if(versionNumber <= '20.0'){
			blocked(versionNumber);
		}
	}

})(jQuery);/*	***************************************

bgsizer 0.1.2
JQuery Plugin

Author: Matt Lantz
Purpose: This is a much needed tool for implimenting large image backgrounds, 
yet ensuring that they consume the users window size.
 
****************************************** */

(function($){  
    $.fn.bgsizer = function(options) {  
      	var defaults = {  
       		img: '',  
      		color: ''
      	};  
      	var options, thisWindow, timeStamp, aspectRatio;
      
	  	options = $.extend(defaults, options);  
	  	thisWindow = $(window);
	  	timeStamp = new Date().getTime();
	  	$(document.body).prepend('<img id="'+timeStamp+'_bgsizer" src="'+defaults.img+'" style="display: none;" />');
		aspectRatio = $('#'+timeStamp+'_bgsizer').width() / $('#'+timeStamp+'_bgsizer').height();
		  
      	$(window).load(function() {

	        function resizeBg() {

			  	$('#'+timeStamp+'_bgsizer').css({
					position: 'fixed',
					top: 0,
					left: 0,
					zIndex: -1,
					width: '100%',
					display: 'block'
				});
	        }

	       	thisWindow.resize(function() {
	        	resizeBg();
	        }).trigger("resize");

		});
	};  
})(jQuery);  /*	***************************************

clockd 0.1
JQuery Plugin

Author: Matt Lantz
Purpose: A clean cut - super simple - clock. period.
 
****************************************** */

(function($){  
    $.fn.clockd = function(options) {  
      
    	var defaults = {  
      	};  

      	var div = $(this).attr('id');
      
	  	var options = $.extend(defaults, options);  
		  
	  	function makeTime(){
			var currentTime = new Date(),
				hours = currentTime.getHours(),
				minutes = currentTime.getMinutes(),
				seconds = currentTime.getSeconds(),
				day = currentTime.getDate(),
				month = currentTime.getMonth()+1,
				year = currentTime.getFullYear();
		
			if (minutes < 10){
				minutes = "0" + minutes
			}
			if (seconds < 10){
				seconds = "0" + seconds
			}
			if(hours > 12){
				hours = hours - 12;
				AP = 'PM';
			}else{
				hours = hours;
				AP = 'AM';
			}
			if(hours == 0){
				hours = 12;
				}

			return hours+':'+minutes+':'+seconds+''+AP+' - '+day+'.'+month+'.'+year;

		}

		$('#'+div).html('<p>'+makeTime()+'</p>');

		function postTime(){
			$('#'+div).html('<p>'+makeTime()+'</p>');
		}

		setInterval( postTime, 1000 );

	};  

})(jQuery);  /*  ***************************************

ivalidate 0.1.2
JQuery Plugin

Author: Matt Lantz
Purpose: Sheerly out of annoyance for never having a tool 
that helps with clean, simply customizable form validation. 
The secondary purpose is because I didn't want to have to 
keep writing up error containers etc. Hope it helps!
 
****************************************** */

//TBD: Add styles to style sheet and drop the error screen that was a bad idea. 

(function($){  
    $.fn.ivalidate = function(options) {  
        
        var thisForm = $(this).attr("id");

        //You Shall Not PASS!
        $('input[type=submit]').css("display", "none");

        var defaults = {
            nameFill: false,
            klass: ""
        };  
        var options = $.extend(defaults, options);  
    
        if(defaults.klass > ""){
            defaults.klass = "."+defaults.klass;  
        }

        //grab the stylesheet and add some styles!
        // var ruleNum = document.styleSheets[0].cssRules.length;
        // var rule = [];
        //     rule[0] = "."+thisForm+"_status{ float: left; clear: left; }";
        //     rule[1] = "."+thisForm+"_status_box{ float: left; width: 16px; }";
        // for (var i = 0; i < rule.length; i++) {
        //     document.styleSheets[0].insertRule(rule[i], ruleNum);
        //     ruleNum++;
        // };
    
        // Before anything lets wrap each of the inputs
        // with a div, to hold the errors or checks!
        var _arrayNum = 0, _inputArray = [];
        $('input[type=text]'+defaults.klass+', textarea'+defaults.klass).each(function(index, element) {
            _inputArray[_arrayNum] = $(this);
            _arrayNum++;
        });

        $('input[type=text], textarea').each(function(index, element) {
            $(this).wrap('<div id="'+$(this).attr('name')+'_status" class="'+thisForm+'_status"></div>');
            $(this).css({
                "float": "left",
                "clear": "left"
            });
            $(this).attr("id", thisForm+"_"+$(this).attr('name')+"_input");
            $('#'+$(this).attr('name')+'_status').append('<div id="'+$(this).attr('name')+'_status_box" class="'+thisForm+'_status_box"></div>');
        });

        $('input[type=submit]').css({
            "float": "left",
            "clear": "left"
        });
    
        // Fill the form with the names of the fields
        if(defaults.nameFill === true){
            $('input[type=text]').each(function(index, element) {
                $(this).val(
                    $(this).attr('data-type')
                );
            });  
        }

        //Bind the click so that way we can clear the val onclick
        $('input[type=text]'+defaults.klass).one('click', function(){
            $(this).val('');
            });
        // dont forget about the textarea!  
        $('textarea'+defaults.klass).one('click', function(){
            $(this).val('');
        });
    
        //check the simple text ones
        $('input[type=text]'+defaults.klass).keyup(function(){
            if($(this).attr('data-type') != 'Email'){
                var text = $(this).val();
                var reg = /[A-Za-z0-9]/;
                if(reg.test(text) == false || $(this).val()=='' ||  $(this).val()==$(this).attr("data-type")) { 
                    $('#'+$(this).attr('name')+'_status_box').html('<div class="ival"><span class="ui-icon ui-icon-closethick"></span></div>');
                } else {
                    $('#'+$(this).attr('name')+'_status_box').html('<div class="ival"><span class="ui-icon ui-icon-check"></span></div>');
                    $(this).attr("data-check", "verified");
                    _submitChecker();
                }
            }else{
                var address = $(this).val();
                var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
                if(reg.test(address) == false || $(this).val()=='') { 
                    $('#'+$(this).attr('name')+'_status_box').html('<div class="ival"><span class="ui-icon ui-icon-closethick"></span></div>');
                } else {
                    $('#'+$(this).attr('name')+'_status_box').html('<div class="ival"><span class="ui-icon ui-icon-check"></span></div>');
                    $(this).attr("data-check", "verified");
                    _submitChecker();
                }
            }
        });

        function _submitChecker(){
            var verifiable = _inputArray.length;
            for(var i = 0; i < verifiable; i++){
                if(_inputArray[i].attr("data-check") != "verified"){
                    $('input[type=submit]').css("display", "none");
                    return;
                }else{
                    $('input[type=submit]').css("display", "block");
                }
                
            }
        }
        
    };  
    
    })(jQuery);  /*	***************************************

jaxet 0.1
JQuery Plugin

Author: Matt Lantz
Purpose: An elegantly simple div content loader. 
For the most part, all it is, is a simple ajax-get 
function.
 
****************************************** */

(function($){  
    $.fn.jaxet = function(options) {  
      
    	var defaults = {  
       		url: ''
      	};  

      	var div = $(this).attr('id');
      
	  	var options = $.extend(defaults, options);  
		  
	  	$.ajax({
		  	url: defaults.url,
		  	success: function(data) {
		  		console.log("jaxet success");
		    	$('#'+div).html(data);
		  	}
		});
	};  

})(jQuery);  /*	***************************************

jquery.mob.js 0.1
JQuery Plugin

Author: Matt Lantz
Purpose: A client side mobile checker enabling
a couple options for handling such an event.
 
****************************************** */

(function($){
	$.fn.mob = function(options) {

		var defaults = {  
       		url: '',
       		stylesheet: ''
      	};  
      
	  	var options = $.extend(defaults, options); 

		var browser = navigator.userAgent,
			version = navigator.appVersion,
			platform = navigator.platform,
			MobilePattern = new RegExp("Mobile");

		if(MobilePattern.test(browser)){
			console.log("You have a mobile browser");
			if(defaults.stylesheet > ''){
				document.getElementsByTagName("head")[0].innerHTML += defaults.stylesheet;
			}
			if(defaults.url > ''){
				window.location = defaults.url;
			}
		}
	}

})(jQuery);