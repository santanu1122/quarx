<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Quarx
 *
 * A modular CMS application
 *
 * @package     Quarx
 * @author      Matt Lantz
 * @copyright   Copyright (c) 2013 - 2014 Matt Lantz
 * @license     https://ottacon.co/docs/quarx/license.html
 * @link        https://github.com/mlantz/quarx
 * @since       Version 1.0
 *
 */

class Complete extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        if ($this->quarx->is_installed(true))
        {
            redirect('login');
        }
    }

    public function index()
    {
        if ($this->input->post('username') != '' && $this->input->post('username') != 'User Name')
        {
            $data['result'] = $this->quarx_install(
                $this->input->post('username'),
                $this->input->post('confirm'),
                $this->input->post('advancedAccounts'),
                $this->input->post('masterAccess'),
                $this->session->userdata('db_array')
            );

            $this->session->unset_userdata('db_array');

            $this->done($this->input->post('username'));
        }
        else
        {
            redirect('setup');
        }
    }

    public function done($username)
    {
        $data['uname'] = $username;
        $data['root'] = base_url();
        $data['pageRoot'] = base_url().'index.php';
        $data['pagetitle'] = 'Setup Complete';

        $this->load->view('common/header', $data);
        $this->load->view('core/setup/step_3', $data);
        $this->load->view('common/footer', $data);
    }

    private function quarx_install($userName, $userPassword, $advancedAccounts, $masterAccess, $db_array)
    {
        $extras = false;
        $avdaccts = 'simple accounts';
        $master = 'standard access';

        if ($advancedAccounts === '1')
        {
            $extras = true;
            $avdaccts = 'advanced accounts';
        }

        if ($masterAccess === '1')
        {
            $extras = true;
            $master = 'master access';
        }

        $current_quarx = @file_get_contents(base_url().".quarx.json");
        $current_quarx = @json_decode($current_quarx);

        $version = @$current_quarx->version;

        $this->load->model('model_setup');
        $table = $this->model_setup->add_user_table($extras);

        if($table !== false)
        {
            $this->model_setup->add_master_user($userName, $userPassword);
        }

        $admin = $this->model_setup->add_admin_table();

        if($admin !== false)
        {
            $this->model_setup->add_admin_opts($avdaccts, $master, $version, $db_array);
        }

        $img_table = $this->model_setup->add_img_table();

        return "Quarx has been successfully installed.";
    }

}

/* End of file complete.php */
/* Location: ./application/controllers/setup */