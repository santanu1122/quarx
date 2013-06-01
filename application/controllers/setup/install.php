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
     
class install extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->model('modelsetup');
        $qry = $this->modelsetup->is_installed();

        if($qry)
        {
            redirect('login');
        }
    }

/* Initial Setup and Install
***************************************************************/

    public function index()
    {
        $this->load->model('modelsetup');
        $qry = $this->modelsetup->is_installed();
    
        $data['root'] = base_url();
        $data['pageRoot'] = base_url().'index.php';
        $data['pagetitle'] = 'Setup';

        $this->load->view('core/setup/header', $data);
        $this->load->view('core/setup/db_setup', $data);
    }

}

/* End of file install.php */
/* Location: ./application/controllers/setup */