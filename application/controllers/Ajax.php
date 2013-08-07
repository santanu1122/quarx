<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Quarx
 *
 * A modular CMS built on CodeIgniter
 *
 * @package     Quarx
 * @author      Matt Lantz
 * @copyright   Copyright (c) 2013 Matt Lantz
 * @license     http://ottacon.co/quarx/license.html
 * @link        http://ottacon.co/quarx
 * @since       Version 1.0
 * 
 */
     
class Ajax extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        
    }

/* Main
***************************************************************/  

    function index() 
    {   
        if(isset($_GET['zip_postal'])){

            $addy = $_GET['zip_postal'];
            
            $trimmed = trim($addy);
            $trimmed = str_replace(" ", "", $trimmed);
            $url = "http://maps.googleapis.com/maps/api/geocode/xml?address=". $trimmed ."&sensor=false";
            $xml = simplexml_load_file($url);
                
            $lat = floatval($xml->result->geometry->location->lat);
            $lng = floatval($xml->result->geometry->location->lng);

            if($_GET['type'] == 'lat'){ 
                echo $lat; 
            }
            
            if($_GET['type'] == 'lng'){ 
                echo $lng; 
            }
            
        }else{
            echo "This isn't really what you're looking for is it?";
        }
    }
}
/* End of file Ajax.php */
/* Location: ./application/controllers/ */