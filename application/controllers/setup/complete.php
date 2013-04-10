<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
     
class complete extends CI_Controller {

/* Initial Setup and Install
***************************************************************/

    function quarx_install($userName, $userPassword, $advancedAccounts, $masterAccess, $db_array){
            if($advancedAccounts === '1'){
                $extras = true;
                $avdaccts = 'advanced accounts';
            }else{
                $extras = false;
                $avdaccts = 'simple accounts';
            }

            if($masterAccess === '1'){
                $extras = true;
                $master = 'master access';
            }else{
                $extras = false;
                $master = 'standard access';
            }

            $current_quarx = @file_get_contents(base_url().".quarx.json");
            $current_quarx = @json_decode($current_quarx);

            $version = @$current_quarx->version;

            $this->load->model('modelsetup');

            // master user
            $table = $this->modelsetup->add_user_table($extras);

            if($table !== false){
                $this->modelsetup->add_master_user($userName, $userPassword);
            }

            // admin options
            $admin = $this->modelsetup->add_admin_table();
            if($admin !== false){
                $this->modelsetup->add_admin_opts($avdaccts, $master, $version, $db_array);
            }

            // image table
            $img_table = $this->modelsetup->add_img_table();

            return "Quarx has been successfully installed.";
    }

    public function index() {
        if($this->input->post('username') != '' && $this->input->post('username') != 'User Name'){
            $data['result'] = $this->quarx_install($this->input->post('username'), $this->input->post('confirm'), $this->input->post('advancedAccounts'), $this->input->post('masterAccess'), $this->session->userdata('db_array'));

            $this->session->unset_userdata('db_array');

            $data['uname'] = $this->input->post('username');
            $data['root'] = base_url();
            $data['pageRoot'] = base_url().'index.php';
            $data['pagetitle'] = 'Setup Complete';
            
            //load the view elements
            $this->load->view('core/setup/header', $data);
            $this->load->view('core/setup/complete', $data);

        }else{
            redirect('setup');
        }
    }

}

/* End of file complete.php */
/* Location: ./application/controllers/setup */