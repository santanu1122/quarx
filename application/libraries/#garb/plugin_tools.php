<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class plugin_tools {
    
    public function plugin_tools(){ 

        function latest_plugin_version($id){
            $CI =& get_instance();

            $url  = 'http://ottacon.co/_quarx_/plugin_list.json';
            $plugin_data = file_get_contents($url);
            $plugin_array = json_decode($plugin_data);
            foreach ($plugin_array as $plugin) :

                if($plugin->id == $id){
                    return $plugin->version;   
                }

            endforeach;
        }

    }
}

//End of File
?>