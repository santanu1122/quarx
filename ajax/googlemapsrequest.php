<?php 

/*
	Written by: Matt Lantz
	A simple tool that grabs the lat and long from Google
	It hands out the XML which we parse and get what we need!
*/

if($_GET['zip_postal']){
	$addy = $_GET['zip_postal'];
	
	$trimmed = trim($addy);
	$trimmed = str_replace(" ", "", $trimmed);
	$url = "http://maps.googleapis.com/maps/api/geocode/xml?address=". $trimmed ."&sensor=false";
	$xml = simplexml_load_file($url);
		
	$lat = floatval($xml->result->geometry->location->lat);
	$lng = floatval($xml->result->geometry->location->lng);

	if($_GET['type'] == 'lat'){ echo $lat; }
	if($_GET['type'] == 'lng'){ echo $lng; }
}
	
?>