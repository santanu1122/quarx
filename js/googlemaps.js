/**
 * Quarx
 *
 * A modular application framework built on CodeIgniter
 *
 * @package     Quarx
 * @author      Matt Lantz
 * @copyright   Copyright (c) 2013 Matt Lantz
 * @license     http://ottacon.co/quarx/license.html
 * @link        http://ottacon.co/quarx
 * @since       Version 1.0
 * 
 */

// Populates and adds a marker to a google map
function getAjax(type, p_code, root){
    $.ajax({
        type: 'GET',
        url: root+"ajax?zip_postal="+p_code+"&type="+type,
        async: false,
        dataType: "html",
        success: function(data){
            if(type == 'lat'){
                $('#latBox').val(data);
            }
            if(type == 'lng'){
                $('#lngBox').val(data);
            }
        }
    });
}

function setMyLocation(lat_lng){
    var location = String(lat_lng),
        lat = location.substr(1, 11),
        lng = location.substr(20, 11);

    $('#latBox').val(lat);
    $('#lngBox').val(lng);     
}

function locateMe(root, val, preVal){
    var p_code = val;

    if(preVal != val) {
        getAjax("lat", p_code, root);
        getAjax("lng", p_code, root);
    }    

    lat = $('#latBox').val(); 
    lng = $('#lngBox').val();
    
    locations = [
        ['This is you!', lat, lng, 1]
    ];
        
    myMap = {
        zoom: 18,
        center: new google.maps.LatLng(lat, lng),
        mapTypeId: google.maps.MapTypeId.ROADMAP
    };
 
    var map = new google.maps.Map(document.getElementById("quarx-map"), myMap);
    
    var infowindow = new google.maps.InfoWindow();

    var marker, i;
    
    for (i = 0; i < locations.length; i++) {  
        marker = new google.maps.Marker({
            position: new google.maps.LatLng(locations[i][1], locations[i][2]),
            map: map,
            draggable: true
        }); 

        google.maps.event.addListener(marker, 'dragend', (function(marker, i) {
        
        return function() {
            setMyLocation(this.getPosition());
            infowindow.setContent(locations[i][0]);
            infowindow.open(map, marker);
        }

    })(marker, i));

    }
}

function locateMeAlt(){
    var lat = $('#latBox').val(),
        lng = $('#lngBox').val();     
    
    var locations = [
        ['This is you!', lat, lng, 1]
    ];

    var myMap = {
        zoom: 18,
        center: new google.maps.LatLng(lat, lng),
        mapTypeId: google.maps.MapTypeId.ROADMAP
    }
 
    var map = new google.maps.Map(document.getElementById("quarx-map"), myMap),
        infowindow = new google.maps.InfoWindow(),
        marker, 
        i;
    
    for (i = 0; i < locations.length; i++) {  
      marker = new google.maps.Marker({
        position: new google.maps.LatLng(locations[i][1], locations[i][2]),
        map: map,
        draggable: true
        }); 
        
        google.maps.event.addListener(marker, 'dragend', (function(marker, i) {
        return function() {
          setMyLocation(this.getPosition());
          infowindow.setContent(locations[i][0]);
          infowindow.open(map, marker);
        }
        })(marker, i));
    }
}