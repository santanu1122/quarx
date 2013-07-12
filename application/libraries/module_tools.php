<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Quarx
 *
 * A modular CMS built on CodeIgniter
 *
 * @package     Quarx
 * @author      Matt Lantz
 * @copyright   Copyright (c) 2013 Matt Lantz
 * @license     http://ottacon.co/quarx/license
 * @link        http://ottacon.co/quarx
 * @since       Version 1.0
 * 
 */

class module_tools{
    
    public function module_tools()
    {

        function get_module_menus()
        {
            $CI =& get_instance();
            if($CI->session->userdata('permission') > 1){
                if(check_master_access() == false){

                    $modules = "application/modules/";
                     
                    $files = glob($modules . "*");
                     
                    foreach($files as $file){
                        if(is_dir($file)){
                            @include($file.'/menu.php');
                        }
                    }
                }
            }else{
                $modules = "application/modules/";
                 
                $files = glob($modules . "*");
                 
                foreach($files as $file){
                    if(is_dir($file)){
                        @include($file.'/menu.php');
                    }
                }
            }
        }

        function get_special_module_menus()
        {
            $modules = "application/modules/";
             
            $files = glob($modules . "*");
             
            foreach($files as $file){
                if(is_dir($file)){
                    @include($file.'/special_menu.php');
                }
            }
        }

        function get_module_manual_menu()
        {
            $modules = "application/modules/";
             
            $files = glob($modules . "*");
             
            foreach($files as $file){
                if(is_dir($file)){
                    @include($file.'/manual/manual_menu.php');
                }
            }
        }

        function get_module_manual()
        {
            $modules = "application/modules/";
             
            $files = glob($modules . "*");
             
            foreach($files as $file){
                if(is_dir($file)){
                    @include($file.'/manual/manual.php');
                }
            }
        }

        function get_module_css()
        {
            $CI =& get_instance();
            $router =& load_class('Router', 'core');

            $currentModule = $router->fetch_class();

            $modules = "application/modules/";
            
            $files = glob($modules . "*");
             
            foreach($files as $file){
                if(is_dir($file)){
                    
                    $pieces = explode("/", $file);
                    $currentDir = end($pieces);
                    
                    if($currentDir == $currentModule){
                        @include($file.'/css/styles.css');
                    }
                }
            }
        }

        function get_module_js()
        {
            $CI =& get_instance();

            $router =& load_class('Router', 'core');

            $currentModule = $router->fetch_class();

            $modules = "application/modules/";
             
            $files = glob($modules . "*");
             
            foreach($files as $file){
                if(is_dir($file)){
                    
                    $pieces = explode("/", $file);
                    $currentDir = end($pieces);
                    
                    if($currentDir == $currentModule){
                        @include($file.'/js/module_functions.js');
                    }
                }
            }
        }

        function get_module_settings()
        {
            $modules = "application/modules/";
             
            $files = glob($modules . "*");
             
            foreach($files as $file){
                if(is_dir($file)){
                    @include($file.'/settings.php');
                }
            }
        }

    }
}

//End of File
?>