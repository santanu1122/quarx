<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

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

class mobile {
	
    public function mobile(){
	
        function isMobile(){
    		$CI =& get_instance();
            $CI->load->library('user_agent');

            $isMobile = false;

            if($CI->agent->is_mobile()){
                $isMobile = true;
            }

            if($isMobile){
               return true;
            }else{
                return false;
            }
        }
    }
}
//End of File
?>