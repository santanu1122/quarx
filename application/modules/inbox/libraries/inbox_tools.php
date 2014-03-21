<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class inbox_tools {
    
    public function inbox_tools(){ 

        function getUserId($name)
        {
            $CI =& get_instance();
            $CI->load->model('model_inbox');
            $query = $CI->model_inbox->get_an_id($name);

            $res = $query[0]->user_id;
            
            return $res;
        }

    }
}

//End of File
?>