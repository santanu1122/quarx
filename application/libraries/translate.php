<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// Author: Matt Lantz
/* 
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