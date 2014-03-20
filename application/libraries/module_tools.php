<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Quarx
 *
 * A modular CMS application
 *
 * @package     Quarx
 * @author      Matt Lantz
 * @copyright   Copyright (c) 2013 Matt Lantz
 * @license     http://ottacon.co/quarx/license.html
 * @link        http://ottacon.co/quarx
 * @since       Version 1.0
 *
 */

class Module_tools {

        public function get_module_menus()
        {
            $CI =& get_instance();
            if ($CI->session->userdata('permission') > 1)
            {
                if ($CI->quarx->get_option("access_type") == "standard access")
                {
                    $modules = "application/modules/";

                    $files = glob($modules . "*");

                    foreach ($files as $file)
                    {
                        if (is_dir($file))
                        {
                            if (file_exists($file.'/menu.php'))
                            {
                                @include($file.'/menu.php');
                            }
                        }
                    }
                }
            }
            else
            {
                $modules = "application/modules/";

                $files = glob($modules . "*");

                foreach ($files as $file)
                {
                    if (is_dir($file))
                    {
                        if (file_exists($file.'/menu.php'))
                        {
                            @include($file.'/menu.php');
                        }
                    }
                }
            }
        }

        public function get_special_module_menus()
        {
            $modules = "application/modules/";

            $files = glob($modules . "*");

            foreach ($files as $file)
            {
                if (is_dir($file))
                {
                    if (file_exists($file.'/special_menu.php'))
                    {
                        @include($file.'/special_menu.php');
                    }
                }
            }
        }

        public function get_module_manual_menu()
        {
            $modules = "application/modules/";

            $files = glob($modules . "*");

            foreach ($files as $file)
            {
                if (is_dir($file))
                {
                    if (file_exists($file.'/manual/manual_menu.php'))
                    {
                        @include($file.'/manual/manual_menu.php');
                    }
                }
            }
        }

        public function get_module_manual()
        {
            $modules = "application/modules/";

            $files = glob($modules . "*");

            foreach ($files as $file)
            {
                if (is_dir($file))
                {
                    if (file_exists($file.'/manual/manual.php'))
                    {
                        @include($file.'/manual/manual.php');
                    }
                }
            }
        }

        public function get_module_css()
        {
            $CI =& get_instance();
            $router =& load_class('Router', 'core');

            $currentModule = $router->fetch_class();

            $modules = "application/modules/";

            $files = glob($modules . "*");

            foreach ($files as $file)
            {
                if (is_dir($file))
                {
                    $pieces = explode("/", $file);
                    $currentDir = end($pieces);

                    if ($currentDir == $currentModule)
                    {
                        if (file_exists($file.'/css/styles.css'))
                        {
                            @include($file.'/css/styles.css');
                        }
                    }
                }
            }
        }

        public function get_module_js()
        {
            $CI =& get_instance();

            $router =& load_class('Router', 'core');

            $currentModule = $router->fetch_class();

            $modules = "application/modules/";

            $files = glob($modules . "*");

            foreach ($files as $file)
            {
                if (is_dir($file))
                {
                    $pieces = explode("/", $file);
                    $currentDir = end($pieces);

                    if ($currentDir == $currentModule)
                    {
                        if (file_exists($file.'/js/module_functions.js'))
                        {
                            @include($file.'/js/module_functions.js');
                        }
                    }
                }
            }
        }

        public function get_module_settings()
        {
            $modules = "application/modules/";

            $files = glob($modules . "*");

            foreach ($files as $file)
            {
                if (is_dir($file))
                {
                    if (file_exists($file.'/settings.php'))
                    {
                        @include($file.'/settings.php');
                    }
                }
            }
        }
}

//End of File
?>