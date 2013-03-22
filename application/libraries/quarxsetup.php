<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// Author: Matt Lantz

class quarxsetup {
    
    public function account_opts(){
        //regarding this-> We have to use this in order to objectify this
        //allowing us to use the prebuilt functions correctly.
        $CI =& get_instance();
        //just running a simple tool to check the settings on/off postitions
        $CI->load->model('modeladmin');
        $query = $CI->modeladmin->account_opts();
        
        //Send back all the information/ settings types we found in the database!
        return $query;
    }
}

//End of File
?>