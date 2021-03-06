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

class Logout extends CI_Controller {

    public function index()
    {
        $this->load->helper('cookie');

        delete_cookie('quarx-username');
        delete_cookie('quarx-password');

        $this->session->sess_destroy();

        $data['root'] = base_url();
        $data['pageRoot'] = base_url().'index.php';
        $data['pagetitle'] = 'Log Out';
        $data['page'] = 'Logout';

        $this->load->view('common/header', $data);
        $this->load->view('core/login/logout', $data);
        $this->load->view('common/footer', $data);
    }

}

/* End of file logout.php */
/* Location: ./application/controllers/ */