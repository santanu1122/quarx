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
 * @link        http://ottacon.co/quarx
 * @since       Version 1.0
 * 
 */
     
class User extends CI_Controller {

/* Initial Setup and Install
***************************************************************/

    public function index() 
    {
        $data['root'] = base_url();
        $data['pageRoot'] = base_url().'index.php';
        $data['pagetitle'] = 'Setup';
        
        $data['masterPage'] = true;

        $this->load->view('core/setup/header', $data);
        $this->load->view('core/setup/user_setup', $data);
    }

}

/* End of file user.php */
/* Location: ./application/controllers/setup */