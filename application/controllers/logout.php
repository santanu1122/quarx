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
     
class logout extends CI_Controller {
    
    public function index() 
    {
        $this->load->helper('cookie');
        
        delete_cookie('quarx-uname');
        delete_cookie('quarx-pword');

        $this->session->sess_destroy();
        
        $data['root'] = base_url();
        $data['pageRoot'] = base_url().'index.php';
        $data['pagetitle'] = 'Sign Out';
        $data['page'] = 'Logout';

        $this->load->view('common/header', $data);
        $this->load->view('core/login/logout', $data);
        $this->load->view('common/footer', $data);
    }
    
}

/* End of file logout.php */
/* Location: ./application/controllers/ */