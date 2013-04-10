<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// Author: Matt Lantz

class quarx_manual {
    
    public function quarx_manual(){
        
        function get_quarx_manual($title){

            $url = 'http://ottacon.co/_quarx_/plugin_list.json';
            $data = file_get_contents($url);
            $plugin = json_decode($data);

            foreach($plugin as $plugin_manual){

                if($plugin_manual->plugin_title == $title){
                    return $plugin_manual->manual;
                }else{
                    foreach($plugin_manual->sub_menu as $sub_item){
                        if(str_replace(' ', '', $sub_item->name) == $title){
                            return $sub_item->manual;
                        }
                    }
                }
            }
            
        }

    }
}

//End of File
?>