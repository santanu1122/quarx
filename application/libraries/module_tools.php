<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* Filename: module_tools.php
 * Location: application/libraries/module_tools.php
 */

class module_tools{
    
    public function module_tools(){

        function get_module_menus(){
            $CI =& get_instance();
            if($CI->session->userdata('permission') > 1){
                if(check_master_access() == false){
                    //scan the modules directory for modules
                    $modules = "application/modules/";
                     
                    //get all files in specified directory
                    $files = glob($modules . "*");
                     
                    //check for each module's menu
                    foreach($files as $file){
                        if(is_dir($file)){
                            include($file.'/menu.php');
                        }
                    }
                }
            }else{
                //scan the modules directory for modules
                $modules = "application/modules/";
                 
                //get all files in specified directory
                $files = glob($modules . "*");
                 
                //check for each module's menu
                foreach($files as $file){
                    if(is_dir($file)){
                        include($file.'/menu.php');
                    }
                }
            }
        }

        function get_special_module_menus(){
            //scan the modules directory for modules
            $modules = "application/modules/";
             
            //get all files in specified directory
            $files = glob($modules . "*");
             
            //check for each module's menu
            foreach($files as $file){
                if(is_dir($file)){
                    include($file.'/special_menu.php');
                }
            }
        }

        function get_module_manual_menu(){
            //scan the modules directory for modules
            $modules = "application/modules/";
             
            //get all files in specified directory
            $files = glob($modules . "*");
             
            //check for each module's menu
            foreach($files as $file){
                if(is_dir($file)){
                    include($file.'/manual/manual_menu.php');
                }
            }
        }

        function get_module_manual(){
            //scan the modules directory for modules
            $modules = "application/modules/";
             
            //get all files in specified directory
            $files = glob($modules . "*");
             
            //check for each module's menu
            foreach($files as $file){
                if(is_dir($file)){
                    include($file.'/manual/manual.php');
                }
            }
        }

        function get_module_css(){
            $CI =& get_instance();
            $router =& load_class('Router', 'core');

            $currentModule = $router->fetch_class();

            //scan the modules directory for modules
            $modules = "application/modules/";
             
            //get all files in specified directory
            $files = glob($modules . "*");
             
            //check for each module's menu
            foreach($files as $file){
                if(is_dir($file)){
                    
                    $pieces = explode("/", $file);
                    $currentDir = end($pieces);
                    
                    if($currentDir == $currentModule){
                        include($file.'/css/styles.css');
                    }
                }
            }
        }

        function get_module_js(){
            $CI =& get_instance();

            $router =& load_class('Router', 'core');

            $currentModule = $router->fetch_class();

            //scan the modules directory for modules
            $modules = "application/modules/";
             
            //get all files in specified directory
            $files = glob($modules . "*");
             
            //check for each module's menu
            foreach($files as $file){
                if(is_dir($file)){
                    
                    $pieces = explode("/", $file);
                    $currentDir = end($pieces);
                    
                    if($currentDir == $currentModule){
                        include($file.'/js/module_functions.js');
                    }
                }
            }
        }
    }
}

//End of File
?>