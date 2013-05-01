<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// Author: Matt Lantz
/* This library gives us a handful of general 
 * tools for category management.
 */

class blog_categorytools {
    
    public function blog_categorytools(){ 

        function getCatName($id){
            $CI =& get_instance();
            $CI->load->model('model_blog_categories');
            
            $query = $CI->model_blog_categories->get_a_cat($id);
            $res = $query[0]->cat_title;
            
            return $res;
        }

    }
}

//End of File
?>