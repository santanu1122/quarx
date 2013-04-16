<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class account_tools {
    
    public function account_tools(){

        function getUserName($id){
            $CI =& get_instance();
            $CI->load->model('modelaccounts');
            $query = $CI->modelaccounts->get_a_name($id);
            $res = $query[0]->user_name;
            
            return $res;
        }

        function check_master_access(){
            $CI =& get_instance();
            $CI->load->model('modeladmin');

            $opts = $CI->modeladmin->get_permissions();

            if($opts->option_title == 'master access'){
                return TRUE;
                exit;
            }else{
                return FALSE;
                exit;
            }
        }
    }
}

//End of File
?>