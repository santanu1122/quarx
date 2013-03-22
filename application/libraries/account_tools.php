<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// Author: Matt Lantz
/* This library gives us a handful of general 
 * tools for accounts.
 */

class account_tools {
    
    public function account_tools(){ 

        function getUserName($id){
            $CI =& get_instance();
            $CI->load->model('modelaccounts');
            $query = $CI->modelaccounts->get_a_name($id);
            $res = $query[0]->user_name;
            
            return $res;
        }

    }
}

//End of File
?>