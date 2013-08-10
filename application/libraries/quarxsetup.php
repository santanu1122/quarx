<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Quarx
 *
 * A modular application framework built on CodeIgniter
 *
 * @package     Quarx
 * @author      Matt Lantz
 * @copyright   Copyright (c) 2013 Matt Lantz
 * @license     http://ottacon.co/quarx/license.html
 * @link        http://ottacon.co/quarx
 * @since       Version 1.0
 * 
 */ 

class quarxsetup {
    
    public function account_opts()
    {
        $CI =& get_instance();
        $CI->load->model('modeladmin');
        $query = $CI->modeladmin->account_opts();
        
        return $query;
    }

    public function get_option($opt)
    {
        $CI =& get_instance();
        $CI->load->model('modeladmin');
        $query = $CI->modeladmin->get_opt($opt);
        
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