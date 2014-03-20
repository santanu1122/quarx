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

class User extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        $with_tables = true;

        if ($this->quarx->is_installed($with_tables))
        {
            redirect('login');
        }
    }

    public function index()
    {
        $data['root'] = base_url();
        $data['pageRoot'] = base_url().'index.php';
        $data['pagetitle'] = 'Setup: Master User';

        $this->load->view('common/header', $data);
        $this->load->view('core/setup/step_2', $data);
        $this->load->view('common/footer', $data);
    }

}

/* End of file user.php */
/* Location: ./application/controllers/setup */