<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Quarx
 *
 * A modular application framework built on CodeIgniter
 *
 * @package     Quarx
 * @author      Matt Lantz
 * @copyright   Copyright (c) 2013 Matt Lantz
 * @license     http://ottacon.co/quarx/license
 * @link        http://ottacon.co/quarx
 * @since       Version 1.0
 * 
 */ 
     
class Settings extends CI_Controller {

/* Main Login
***************************************************************/

    public function index() 
    {        
        $data['root'] = base_url();
        $data['pageRoot'] = base_url().'index.php';
        $data['pagetitle'] = 'Settings';
        $data['page'] = 'Settings';

        $this->load->view('common/header', $data);
        $this->load->view('core/accounts/settings', $data);
        $this->load->view('common/footer', $data);
    }

}
/* End of file settings.php */
/* Location: ./application/controllers/ */