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

class Install extends CI_Controller {

    function __construct()
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
        $this->load->view('core/setup/step_1', $data);
        $this->load->view('common/footer', $data);
    }

}

/* End of file Install.php */
/* Location: ./application/controllers/setup */