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

class Edit extends CI_Controller {

    function __construct()
    {
        parent::__construct();

        if ( ! $this->session->userdata('logged_in')) redirect('error/login?r='.($_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']));

        if ($this->session->userdata('user_id') != 1)
        {
            $this->session->set_flashdata('error', 'You do not have sufficient permission to access this');
            redirect('error');
        }

        $this->lang->load(config_item('language_abbr'), config_item('language'));
    }

    public function index()
    {
        if($this->session->userdata('user_id') == 1)
        {
            $js = array('views/admin/quarx.admin.js');
            $this->carabiner->group("quarx-admin-js", array('js'=>$js));

            $data['quarxInstalled'] = 'installed';
            $data['accountStatus'] = ($this->quarx->get_option('account_type') == 'advanced accounts' ? 'checked="checked"' : '');
            $data['masterAccess'] = ($this->quarx->get_option('access_type') == 'master access' ? 'checked="checked"' : '');
            $data['joining'] = ($this->quarx->get_option('enable_joining') == 'yes' ? 'checked="checked"' : '');
            $data['auto_auth'] = ($this->quarx->get_option('auto_auth') == 'on' ? 'checked="checked"' : '');
            $data['joiningIsEnabled'] = ($this->quarx->get_option("enable_joining") == "yes" ? true : false);

            $data['uname'] = $this->db->escape($this->input->post('username'));
            $data['root'] = base_url();
            $data['pageRoot'] = base_url().'index.php';
            $data['pagetitle'] = 'Quarx: Settings';

            $this->load->view('common/header', $data);
            $this->load->view('core/admin/edit', $data);
            $this->load->view('common/footer', $data);
        }
        else
        {
            $this->session->set_flashdata('error', 'You do not have sufficient permission to access this');
            redirect('error');
        }
    }

    public function update()
    {
        $data['quarxInstalled'] = 'installed';

        $advancedAccounts = $this->db->escape_str($this->input->post('advancedAccounts'));
        $accounts = ($advancedAccounts == 1 ? 'advanced accounts' : 'simple accounts');

        $masterAccess = $this->db->escape_str($this->input->post('masterAccess'));
        $access = ($masterAccess == 1 ? 'master access' : 'standard access');

        $enableJoining = $this->db->escape_str($this->input->post('enableJoining'));
        $joining = ($enableJoining == 1 ? 'yes' : 'no');

        $autoAuth = $this->db->escape_str($this->input->post('autoAuth'));
        $auth = ($autoAuth == 1 ? 'on' : 'off');

        $this->update_option($accounts, 'accounts');
        $this->update_option($access, 'access');
        $this->update_option($joining, 'joining');
        $this->update_option($auth, 'auth');

        $this->session->set_flashdata('message', array("info", "Your new settings were saved."));
        redirect('admin/main');
    }

    public function update_option($option, $type)
    {
        $this->load->model('model_setup');
        return $this->model_setup->edit_config($option, $type);
    }

}
/* End of file Edit.php */
/* Location: ./application/controllers/setup */