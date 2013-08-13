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
     
class Master extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->model('modelsetup');
        $qry = $this->modelsetup->is_installed();

        if(!$qry)
        {
            redirect('setup/install');
        }
    }

/* Master
***************************************************************/

    public function index()
    {
        $data['quarxInstalled'] = 'installed';
        
        $this->load->model('modelsetup');
        $atomic = $this->modelsetup->is_connected_to('atomic');
        
        if($atomic){
            $data['atomic'] = true;
        }

        $data['status'] = "";
        $data['message'] = "";

        if($this->session->flashdata('success')){
            $data['status'] = "quarx-success-box";
            $data['message'] = $this->session->flashdata('success');
        }

        if($this->session->flashdata('error')){
            $data['status'] = "quarx-error-box";
            $data['message'] = $this->session->flashdata('error');
        }
    
        $data['root'] = base_url();
        $data['pageRoot'] = base_url().'index.php';
        $data['pagetitle'] = 'Setup';
        $data['masterPage'] = true;

        $this->load->view('core/setup/header', $data);
        $this->load->view('core/setup/master', $data);
    }
}

/* End of file master.php */
/* Location: ./application/controllers/setup */