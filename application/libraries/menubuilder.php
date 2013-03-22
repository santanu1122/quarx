<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class menubuilder {
	// checks to see what plugins are installed and returns those plugins
	public function menubuilder(){
		//Check active plugins
		$CI =& get_instance();
        $CI->load->model('modelsetup');

        $CI->load->library('session');
        $CI->load->library('quarxsetup');

        if($CI->session->userdata('logged_in')){
            $plugin_qry = $CI->modelsetup->installed_plugins();

            $i = 0;

            if($CI->session->userdata('permission') != 1){
                $setup = $CI->quarxsetup->account_opts();
                
                //check if master access is on
                if(!$setup[2]->option_title === 'master access'){
                    foreach ($plugin_qry as $menu_item):
                        if($menu_item->plugin_name != 'members'){
                            $GLOBALS['menu_build'][$i] = array("name" => $menu_item->plugin_name, "id_tag" => $menu_item->plugin_id_tag, "title" => $menu_item->plugin_title, "pages" => $menu_item->plugin_pages, "active" => $menu_item->plugin_active); 
                            $i++;
                        }
                    endforeach;
                }
            }else{
                foreach ($plugin_qry as $menu_item):
                    if($menu_item->plugin_name != 'members'){
                        $GLOBALS['menu_build'][$i] = array("name" => $menu_item->plugin_name, "id_tag" => $menu_item->plugin_id_tag, "title" => $menu_item->plugin_title, "pages" => $menu_item->plugin_pages, "active" => $menu_item->plugin_active); 
                        $i++;
                    }
                endforeach;
            }
        }
	}
}

//End of File
?>