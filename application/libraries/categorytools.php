<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// Author: Matt Lantz
/* This library gives us a handful of general 
 * tools for category management.
 */

class categorytools {
    
    public function categoryTools(){ 

        function getCatName($id){
            $CI =& get_instance();
            $CI->load->model('modelcategories');
            
            $query = $CI->modelcategories->get_a_cat($id);
            $res = $query[0]->cat_title;
            
            return $res;
        }

    }
}

//End of File
?>