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

class translate{
    
    public function translate(){ 

        function lang($label, $obj){
            $return = $obj->lang->line($label);
            if($return){
                echo $return;
            }else{
                echo $label;
            }
        }
    }
}

//End of File
?>