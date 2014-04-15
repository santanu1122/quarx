<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Quarx
 *
 * A modular CMS application
 *
 * @package     Quarx
 * @author      Matt Lantz
 * @copyright   Copyright (c) 2013 Matt Lantz
 * @license     http://ottacon.co/quarx/license.html
 * @link        http://ottacon.co/quarx
 * @since       Version 1.0
 *
 */

class Error extends CI_Controller {

    public function index()
    {
        $refURL = $_SERVER['REQUEST_URI'];
        $browser = $_SERVER['HTTP_USER_AGENT'];
        $user = $_SERVER['REMOTE_ADDR'];

        $message = "The following website: ".$root." recieved a 404 error: ".$refURL." when user: ".$user.", while using the following browser: ".$browser;
        log_message('Error', $message);

        $data['root'] = base_url();
        $data['pageRoot'] = base_url().'index.php';
        $data['pagetitle'] = 'Error';
        $data['page'] = 'Error';

        $data['error'] = $this->session->flashdata('error') ?: null;

        $this->load->view('common/header', $data);
        $this->load->view('core/errors/general', $data);
        $this->load->view('common/footer', $data);
    }

    public function e_404()
    {
        $refURL = $_SERVER['REQUEST_URI'];
        $browser = $_SERVER['HTTP_USER_AGENT'];
        $user = $_SERVER['REMOTE_ADDR'];
        $root = base_url();

        $message = "The following website: ".$root." recieved a 404 error: ".$refURL." when user: ".$user.", while using the following browser: ".$browser;
        log_message('Error', $message);

        $data['root'] = $root;
        $data['pageRoot'] = base_url().'index.php';
        $data['pagetitle'] = 'Error';
        $data['page'] = 'Error';

        $this->load->view('common/header', $data);
        $this->load->view('core/errors/e_404', $data);
        $this->load->view('common/footer', $data);
    }

    public function login()
    {
        $site = str_replace("http://", "", site_url());
        $site = str_replace("https://", "", $site);

        $request = str_replace($site, "", $this->input->get("r"));

        $this->load->helper('cookie');
        $this->load->model('model_login');

        $user = $this->model_login->cookie_validate($this->input->cookie('quarx-username'), $this->input->cookie('quarx-password'));

        if ( ! $user)
        {
            $message = "This user: ".$user.", encountered a login error";
            log_message('Error', $message);

            $data['root'] = base_url();
            $data['pageRoot'] = base_url().'index.php';
            $data['pagetitle'] = 'Limbo';
            $data['date'] = date("m-d-y");

            $this->load->view('common/header', $data);
            $this->load->view('core/errors/login-error', $data);
            $this->load->view('common/footer', $data);
        }
        else
        {
            $userdata = array(
                "user_id" => $user->id,
                "username" => $user->username,
                "email" => $user->email,
                "permission" => $user->permission,
                "logged_in" => true,
            );

            $this->session->set_userdata($userdata);
            @$this->session->set_userdata('owner', $user->owner);
            @$this->session->set_userdata('company', $user->company);

            $uri = $request;
            redirect($uri ?: "users");
        }
    }
}

/* End of file Error.php */
/* Location: ./application/controllers/ */