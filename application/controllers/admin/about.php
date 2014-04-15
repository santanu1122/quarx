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

class About extends CI_Controller {

    function __construct()
    {
        parent::__construct();

        if ( ! $this->session->userdata('logged_in')) redirect('error/login?r='.($_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']));

        if ($this->session->userdata('permission') != 1)
        {
            $this->session->set_flashdata('error', 'You do not have sufficient permission to access this');
            redirect('error');
        }

        $this->lang->load(config_item('language_abbr'), config_item('language'));
    }

    public function index()
    {
        $this->output->cache(9);

        $js = array('views/admin/quarx.admin.js');
        $this->carabiner->group("quarx-admin-js", array('js'=>$js));

        $data['version'] = $this->quarx->quarx_details('version');
        $data['info'] = $this->quarx->quarx_details('info');
        $data['authors'] = $this->quarx->quarx_details('authors');

        $data['root'] = base_url();
        $data['pageRoot'] = base_url().'index.php';
        $data['pagetitle'] = 'About';

        $this->load->view('common/header', $data);
        $this->load->view('core/admin/about', $data);
        $this->load->view('common/footer', $data);
    }

}

/* End of file About.php */
/* Location: ./application/controllers/admin */