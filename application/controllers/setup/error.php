<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
     
class error extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->model('modellogin');
        $qry = $this->modellogin->is_installed();

        if($qry !== false){

            if($this->session->userdata('user_id') != 1){
                redirect('accounts/permission');
            }

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
        }
    }

/* Initial Setup and Install
***************************************************************/

    public function index() {
        $data['error'] = $this->session->flashdata('error');

        $data['root'] = base_url();
        $data['pageRoot'] = base_url().'index.php';
        $data['pagetitle'] = 'Setup';
        $data['masterPage'] = true;

        $this->load->view('core/setup/header', $data);
        $this->load->view('core/errors/general', $data);
        $this->load->view('core/setup/footer', $data);
    }
}
/* End of file setup.php */
/* Location: ./application/controllers/ */