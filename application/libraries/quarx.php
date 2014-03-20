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

class Quarx {

    public function is_installed($with_tables = null)
    {
        $CI =& get_instance();
        $CI->load->model('model_setup');
        return $CI->model_setup->is_installed($with_tables);
    }

    public function get_option($opt)
    {
        $CI =& get_instance();
        $CI->load->model('model_admin');
        $query = $CI->model_admin->get_opt($opt);

        return $query;
    }

    public function quarx_details($col)
    {
        $url  = './.quarx.json';
        $quarx = file_get_contents($url);
        $quarx = json_decode($quarx);

        return $quarx->$col;
    }

}

//End of File
?>