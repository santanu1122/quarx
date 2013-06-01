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
 * @link        http://quarx.ottacon.co
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
}

//End of File
?>