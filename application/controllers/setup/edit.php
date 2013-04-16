<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
     
class edit extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->model('modelsetup');
        $qry = $this->modelsetup->is_installed();

        if(!$qry){
            redirect('setup/install');
        }
    }

/* Initial Setup and Install
***************************************************************/

    public function index() {
        if($this->session->userdata('user_id') == 1){

            $data['quarxInstalled'] = 'installed';
            
            $state = $this->quarxsetup->account_opts();

            if($state[0]->option_title === 'advanced accounts'){
                $data['accountStatus'] = 'checked="checked"';
            }else{
                $data['accountStatus'] = '';
            } 

            if($state[2]->option_title === 'master access'){
                $data['masterAccess'] = 'checked="checked"';
            }else{
                $data['masterAccess'] = '';
            } 

            $data['uname'] = $this->input->post('username');
            $data['root'] = base_url();
            $data['pageRoot'] = base_url().'index.php';
            $data['pagetitle'] = 'Setup Edit';
            
            //load the view elements
            $this->load->view('core/setup/header', $data);
            $this->load->view('core/setup/edit', $data);
        }else{
            redirect('accounts/insufficient');
        }
    }

    public function edit_setup(){
        $data['quarxInstalled'] = 'installed';
        
        // Regarding Advanced Accounts
        $advancedAccounts = $this->input->post('advancedAccounts');

        if($advancedAccounts === '1'){
            $avdaccts = 'advanced accounts';
        }else{
            $avdaccts = 'simple accounts';
        }

        $this->load->model('modelsetup');
        $this->modelsetup->edit_account_config($avdaccts);

        // Regarding Master Access
        $masterAccess = $this->input->post('masterAccess');
        if($masterAccess === '1'){
            $masterAccess = 'master access';
        }else{
            $masterAccess = 'standard access';
        }

        $this->load->model('modelsetup');
        $this->modelsetup->edit_master_access_config($masterAccess);
        
        redirect('setup');
    }

}
/* End of file edit.php */
/* Location: ./application/controllers/setup */