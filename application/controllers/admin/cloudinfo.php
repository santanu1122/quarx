<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// Author: Matt Lantz
     
class cloudinfo extends CI_Controller {

    public function __construct(){
        parent::__construct();
        if(!$this->session->userdata('logged_in')){
            redirect('login/error'); // Denied! 
        }

        if($this->session->userdata('permission') > 1){
            $setup = $this->quarxsetup->account_opts();
            //check if master access is on
            if($setup[2]->option_title === 'master access'){
                redirect('accounts/permission'); // Denied! 
            }
        }

        $this->lang->load(config_item('language_abbr'), config_item('language'));
    }


/* Primary Tools
*****************************************************************/

    public function index(){  
        if($this->session->userdata('permission') == 1){
            //Check active plugins
            $this->load->model('modelsetup');
            
            $this->load->library('checker');

            //configured the data to be transported to the view
            $data['root'] = base_url();
            $data['pageRoot'] = base_url().'index.php';
            $data['pagetitle'] = 'CloudInfo';
            $data['sub_menu_title'] = 'CloudInfo';
            
            //load the view elements
            $this->load->view('common/header', $data);
            $this->load->view('core/admin/cloudinfo', $data);
            $this->load->view('common/footer', $data);

        }else{
            redirect('accounts/insufficient');
        }
    }

}

/* End of file admin.php */
/* Location: ./application/controllers/admin */