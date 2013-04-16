<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class quarxsetup {
    
    public function account_opts(){
        $CI =& get_instance();
        $CI->load->model('modeladmin');
        $query = $CI->modeladmin->account_opts();
        
        return $query;
    }
}

//End of File
?>