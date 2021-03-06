<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Quarx
 *
 * A modular application framework
 *
 * @package     Quarx
 * @author      Matt Lantz
 * @copyright   Copyright (c) 2013 Matt Lantz
 * @license     http://ottacon.co/quarx/license.html
 * @link        http://ottacon.co/quarx
 * @since       Version 1.0
 *
 */

class Error extends CI_Controller {

    function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $data['error'] = $this->session->flashdata('error');

        $data['root'] = base_url();
        $data['pageRoot'] = base_url().'index.php';
        $data['pagetitle'] = 'Setup: Error';

        $this->load->view('core/setup/header', $data);
        $this->load->view('core/errors/general', $data);
    }
}

/* End of file error.php */
/* Location: ./application/controllers/ */