<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// Author: Matt Lantz

class pages_parent_tools {
    
    public function pages_parent_tools(){ 

        function getParentName($id){
            $CI =& get_instance();
            $CI->load->model('model_pages');

            if($id == '0'){
            
                $res = 'None';
            
            }else{
            
                $query = $CI->model_pages->get_this_entry($id);
                $res = $query[0]->page_title;

            }

            return $res;
        }

    }
}

//End of File
?>