<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Quarx
 *
 * A modular CMS built on CodeIgniter
 *
 * @package     Quarx
 * @author      Matt Lantz
 * @copyright   Copyright (c) 2013 Matt Lantz
 * @license     http://ottacon.co/quarx/license
 * @link        http://quarx.ottacon.co
 * @since       Version 1.0
 * 
 */

class toolbelt {

    public function toolbelt()
    {
        
        function valCheck($string)
        {
            $endVal = "N/A";
            if($string != ""){
                $endVal = $string;
            }
            return $endVal;
        }

        function valTrim($val, $length)
        {
            if(strlen($val) > $length){
                return substr($val, 0, $length).'...';
            }else{
                return $val;
            }
        }

        function strip_special_chars($str)
        {
            $stripped = preg_replace("/[^A-Za-z0-9 ]/", "", $str);
            $polished = str_replace(" ", "-", $stripped);

            return $polished;
        }
    
    }

}
//End of File
?>