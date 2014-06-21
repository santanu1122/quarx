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

class Jsonp extends CI_Controller {

    function __construct()
    {
        parent::__construct();

        $this->valid_ips = array();

        if ( in_array($this->input->get('token'), $this->config->item('jsonp_tokens'))) array_push($this->valid_ips, $_SERVER['REMOTE_ADDR']);
        else
        {
            echo 'failed()'; exit;
        }
    }

    public function login()
    {
        if (in_array($_SERVER['REMOTE_ADDR'], $this->valid_ips))
        {
            if ($this->validate())
            {
                echo 'logged_in({ username: "'.$this->session->userdata('username').'" });';
            }
            else
            {
                echo 'failed()'; exit;
            }

        }
    }

    public function logout()
    {
        $this->session->sess_destroy();
        echo 'logged_out()';
    }

    public function check_login()
    {
        if ($this->session->userdata("logged_in"))
        {
            echo "logged_in({ username: '".$this->session->userdata('username')."' })";
        }
        else
        {
            echo "failed()";
        }
    }

    public function validate()
    {
        $username = $this->input->get('username');
        $password = $this->input->get('password');

        $this->load->model('model_login');
        $user = $this->model_login->do_login($username, $password);

        if ($user)
        {
            $userdata = array(
                "user_id" => $user->id,
                "username" => $user->username,
                "email" => $user->email,
                "permission" => $user->permission,
                "logged_in" => true,
            );

            $this->session->set_userdata($userdata);

            return true;
        }

        return false;
    }
}

/* End of file Jsonp.php */
/* Location: ./application/controllers/ */