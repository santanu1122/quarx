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
     
class edit extends CI_Controller {

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

/* Initial Setup and Install
***************************************************************/

    public function index()
    {
        if($this->session->userdata('user_id') == 1)
        {
            $data['quarxInstalled'] = 'installed';
            
            $state = $this->quarxsetup->account_opts();

            if($state[0]->option_data === 'advanced accounts')
            {
                $data['accountStatus'] = 'checked="checked"';
            }
            else
            {
                $data['accountStatus'] = '';
            } 

            if($state[1]->option_data === 'master access')
            {
                $data['masterAccess'] = 'checked="checked"';
            }
            else
            {
                $data['masterAccess'] = '';
            } 

            if($state[4]->option_data === 'yes')
            {
                $data['joining'] = 'checked="checked"';
            }
            else
            {
                $data['joining'] = '';
            } 

            if($state[5]->option_data === 'on')
            {
                $data['auto_auth'] = 'checked="checked"';
            }
            else
            {
                $data['auto_auth'] = '';
            } 

            $status = $this->quarxsetup->account_opts();
            if($status[4]->option_data == "no"){
                $data['joiningIsEnabled'] = false;
            }else{
                $data['joiningIsEnabled'] = true;
            }

            $data["masterPage"] = true;

            $data['uname'] = $this->db->escape($this->input->post('username'));
            $data['root'] = base_url();
            $data['pageRoot'] = base_url().'index.php';
            $data['pagetitle'] = 'Setup Edit';
            
            $this->load->view('core/setup/header', $data);
            $this->load->view('core/setup/edit', $data);
        }
        else
        {
            redirect('accounts/insufficient');
        }
    }

    public function edit_setup()
    {
        $data['quarxInstalled'] = 'installed';
        
        /* Advanced Accounts
        *************************************/
        $advancedAccounts = $this->db->escape_str($this->input->post('advancedAccounts'));

        if($advancedAccounts === '1')
        {
            $avdaccts = 'advanced accounts';
        }
        else
        {
            $avdaccts = 'simple accounts';
        }

        $this->load->model('modelsetup');
        $this->modelsetup->edit_account_config($avdaccts);

        /* Master Access
        *************************************/

        $masterAccess = $this->db->escape_str($this->input->post('masterAccess'));
        if($masterAccess === '1')
        {
            $masterAccess = 'master access';
        }
        else
        {
            $masterAccess = 'standard access';
        }

        $this->load->model('modelsetup');
        $this->modelsetup->edit_master_access_config($masterAccess);

        /* Joining
        *************************************/

        $enableJoining = $this->db->escape_str($this->input->post('enableJoining'));
        if($enableJoining === '1')
        {
            $enableJoining = 'yes';
        }
        else
        {
            $enableJoining = 'no';
        }

        $this->load->model('modelsetup');
        $this->modelsetup->edit_joining_config($enableJoining);

        /* Auto-Auth
        *************************************/

        $autoAuth = $this->db->escape_str($this->input->post('autoAuth'));
        if($autoAuth === '1')
        {
            $autoAuth = 'on';
        }
        else
        {
            $autoAuth = 'off';
        }

        $this->load->model('modelsetup');
        $this->modelsetup->edit_auto_auth_config($autoAuth);
        
        $this->session->set_flashdata('success', 'Your setup edits were successful');
        redirect('setup');
    }

}
/* End of file edit.php */
/* Location: ./application/controllers/setup */