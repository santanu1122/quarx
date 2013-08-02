<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Quarx
 *
 * A modular application framework built on CodeIgniter
 *
 * @package     Quarx
 * @author      Matt Lantz
 * @copyright   Copyright (c) 2013 Matt Lantz
 * @license     http://ottacon.co/quarx/license
 * @link        http://ottacon.co/quarx
 * @since       Version 1.0
 * 
 * if PHP < 5.2 we now have json_encode/json_decode
 */ 

class json_lib {

    public function json_lib()
    {
        
        if (!function_exists('json_decode')) 
        {
            function json_decode($content, $assoc=false) 
            {
                require_once './third-party/JSON/JSON.php';
                if ($assoc) {
                    $json = new Services_JSON(SERVICES_JSON_LOOSE_TYPE);
                }
                else {
                    $json = new Services_JSON;
                }
                return $json->decode($content);
            }
        }

        if (!function_exists('json_encode')) 
        {
            
            function json_encode($content) 
            {
                require_once './third-party/JSON/JSON.php';
                $json = new Services_JSON;
                return $json->encode($content);
            }
        }

        function check_jsonp_token($token)
        {
            $CI =& get_instance();
            if($CI->config->item('jsonp_token') == $token){
                return true;
            }
        }

    }

}
//End of File
?>