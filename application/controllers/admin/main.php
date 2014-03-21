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

class Main extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        if (!$this->session->userdata('logged_in'))
        {
            redirect('error/login'); // Denied!
        }

        if ($this->session->userdata('user_id') != 1)
        {
            redirect('users/permission');
        }

        $this->lang->load(config_item('language_abbr'), config_item('language'));
    }

    public function index()
    {
        $this->load->model('model_admin');

        $js = array('views/admin/quarx.admin.js');
        $this->carabiner->group("quarx-admin-js", array('js'=>$js));

        $data['root'] = base_url();
        $data['pageRoot'] = base_url().'index.php';
        $data['pagetitle'] = 'Admin';

        $this->load->view('common/header', $data);
        $this->load->view('core/admin/main', $data);
        $this->load->view('common/footer', $data);
    }

}

/* End of file main.php */
/* Location: ./application/controllers/admin */