<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Quarx
 *
 * A modular CMS built on CodeIgniter
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

    public function __construct()
    {
        parent::__construct();
        if(!$this->session->userdata('logged_in'))
        {
            redirect('login/error'); // Denied! 
        }

        if($this->session->userdata('permission') > 1)
        {
            $setup = $this->quarxsetup->account_opts();
            if($setup[2]->option_title === 'master access')
            {
                redirect('accounts/permission');
            }
        }

        $this->lang->load(config_item('language_abbr'), config_item('language'));
    } 


/* Primary Tools
*****************************************************************/

    public function index()
    {  
        // $this->output->cache(9);

        $this->load->model('modelsetup');

        $data['root'] = base_url();
        $data['pageRoot'] = base_url().'index.php';
        $data['pagetitle'] = 'About';
        
        $this->load->view('common/header', $data);
        $this->load->view('core/admin/about', $data);
        $this->load->view('common/footer', $data);
    }

}

/* End of file about.php */
/* Location: ./application/controllers/admin */