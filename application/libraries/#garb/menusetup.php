<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class menusetup {
	// checks to see what plugins are installed and returns those plugins
	public function plugins(){
		//Check active plugins
		$CI =& get_instance();
        $CI->load->model('modelsetup');

        $CI->load->library('session');
        $CI->load->library('quarxsetup');

        $plugin_qry = $CI->modelsetup->installed_plugins();

        if($CI->session->userdata('permission') != 1){
            $setup = $CI->quarxsetup->account_opts();
            //check if master access is on
            if(!$setup[2]->option_title === 'master access'){
                return $plugin_qry;
            }
        }else{
            return $plugin_qry;
        }
	}
}

//End of File
?>