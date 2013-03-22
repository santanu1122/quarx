/* 	onyxfunc
	Author: Matt Lantz
	This is the collection of functions utilized in various places throughout the oynx frameworks
*/

// Profile Image resizing
function profileImageResize(){
    var width = $('.profileImageBox img').width(),
        height = $('.profileImageBox img').height();

    if(height == width){
        $('.profileImageBox img').css({
            marginTop: 25,
            marginLeft: 15,
            height: 350,
            width: 350
        });
    }

    else if(height > width){
        var newWidth = ( width * 350 ) / height,
            marginLeft = (375 - newWidth)/2,
            marginTop = (400 - 350)/2;

        $('.profileImageBox img').css({
            marginTop: marginTop,
            marginLeft: marginLeft,
            height: 350,
            width: newWidth
        });

    }

    else if(width > height){

        var newHeight = ( height/width ) * 375,
            marginTop = (400 - newHeight)/2,
            marginLeft = (375 - 350)/2;

        $('.profileImageBox img').css({
            marginTop: marginTop,
            marginLeft: marginLeft,
            width: 350,
            height: newHeight
        });
    }
}

// Profile Image resizing
function thumbnailImageResize(){
    $('.imgThumbHolder img').each(function(){
        var width = $(this).width(),
            height = $(this).height();

        if(height === width){
            $(this).css({
                marginTop: -10,
                marginLeft: 0,
                height: 124,
                width: 124
            });
        }

        if(height > width){
            var newWidth = ( width * 130 ) / height,
                marginLeft = (124 - newWidth)/2,
                marginTop = 13;

            if(newWidth > 100){
                marginTop = -10;
            } 

            $(this).css({
                marginTop: marginTop,
                marginLeft: marginLeft,
                height: 130,
                width: newWidth
            });

        }

        if(width > height){

            var newHeight = ( height/width ) * 130,
                marginTop = -13,
                marginLeft = 0;

            $(this).css({
                marginTop: marginTop,
                marginLeft: marginLeft,
                width: 124,
                height: newHeight
            });
        }
    });
}
