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

class Init extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        if ($this->quarx->is_installed())
        {
            redirect('login');
        }
    }

    public function index()
    {
        $data['root'] = base_url();
        $data['pageRoot'] = base_url().'index.php';
        $data['pagetitle'] = 'Quarx Setup';

        $this->load->view('common/header', $data);
        $this->load->view('core/setup/init', $data);
        $this->load->view('common/footer', $data);
    }
}

/* End of file master.php */
/* Location: ./application/controllers/setup */