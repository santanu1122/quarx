<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Quarx
 *
 * A modular application framework built on CodeIgniter
 *
 * @package     Quarx
 * @author      Matt Lantz
 * @copyright   Copyright (c) 2013 Matt Lantz
 * @license     http://ottacon.co/quarx/license
 * @link        http://ottacon.co/quarx
 * @since       Version 1.0
 * 
 */

class account_tools {
    
    public function account_tools()
    {

        function getUserName($id)
        {
            $CI =& get_instance();
            $CI->load->model('modelaccounts');
            $query = $CI->modelaccounts->get_a_name($id);
            $res = $query[0]->user_name;
            
            return $res;
        }

        function getUserEmail($id)
        {
            $CI =& get_instance();
            $CI->load->model('modelaccounts');
            $query = $CI->modelaccounts->get_a_name($id);
            $res = $query[0]->user_email;
            
            return $res;
        }

        function check_master_access()
        {
            $CI =& get_instance();
            $CI->load->model('modeladmin');

            $opts = $CI->modeladmin->get_permissions();

            if($opts->option_data == 'master access'){
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