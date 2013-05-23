<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
     
class error extends CI_Controller {

    function __construct()
    {
        parent::__construct();
    }

/* Initial Setup and Install
***************************************************************/

    public function index()
    {
        $data['error'] = $this->session->flashdata('error');

        $data['root'] = base_url();
        $data['pageRoot'] = base_url().'index.php';
        $data['pagetitle'] = 'Setup';
        $data['masterPage'] = true;

        $this->load->view('core/setup/header', $data);
        $this->load->view('core/errors/general', $data);
    }
}

/* End of file error.php */
/* Location: ./application/controllers/ */