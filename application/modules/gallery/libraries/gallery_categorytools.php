<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// Author: Matt Lantz
/* This library gives us a handful of general 
 * tools for category management.
 */

class gallery_categorytools {
    
    public function gallery_categorytools(){ 

        function getCatName($id){
            $CI =& get_instance();
            $CI->load->model('model_gallery_categories');
            
            $query = $CI->model_gallery_categories->get_a_cat($id);
            $res = $query[0]->cat_title;
            
            return $res;
        }

    }
}

//End of File
?>