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

class Login extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        if ( ! $this->quarx->is_installed()) redirect('setup/init');

        $this->load->helper('cookie');
        $this->load->model('model_login');

        $is_cookie_valid = $this->model_login->cookie_validate($this->input->cookie('quarx-username'), $this->input->cookie('quarx-password'));

        if ( ! $is_cookie_valid && ! $this->session->userdata('logged_in'))
        {
            $data['joiningIsEnabled'] = ($this->quarx->get_option("enable_joining") == "no" ? false : true);
            $data['is_login'] = true;
            $data['root'] = base_url();
            $data['pageRoot'] = base_url().'index.php';
            $data['pagetitle'] = 'Login';
            $data['date'] = date("m-d-y");

            $this->load->view('common/header', $data);
            $this->load->view('core/login/login', $data);
            $this->load->view('common/footer', $data);
        }
        else
        {
            redirect('users/profile');
        }
    }

    public function join()
    {
        if ($this->quarx->get_option("enable_joining") == "yes")
        {
            $js = array('views/quarx-join.js');
            $this->carabiner->group("quarx-join-js", array('js'=>$js));

            $data['root'] = base_url();
            $data['pageRoot'] = base_url().'index.php';
            $data['pagetitle'] = 'Join';

            $this->load->view('common/header', $data);
            $this->load->view('core/login/join', $data);
            $this->load->view('common/footer', $data);
        }
        else
        {
            $this->session->set_flashdata('message', array("info", "Sorry, but you\'re not currently able to join."));
            redirect("error");
        }
    }

    public function validate()
    {
        $this->load->model('model_login');

        // Validator
        $form = $this->validator->run("login", "validate");

        if ( ! $form['valid'])
        {
            $this->session->set_flashdata("message", array("error", $form['error']));
            redirect("login");
        }

        $user = $this->model_login->validate();

        $password = $this->input->post("password");

        if ( ! $user)
        {
            $this->session->set_flashdata('message', array("info", "Sorry either your username or password was incorrect."));
            redirect('login');
        }

        switch ($user->account_status)
        {
            case 'enabled':
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

                if ($this->input->post('remember_me') == 1)
                {
                    $cookie = array(
                        'name'   => 'quarx-username',
                        'value'  => $user->username,
                        'expire' => '1209600'
                    );

                    $this->input->set_cookie($cookie);

                    $cookie_password = array(
                        'name'   => 'quarx-password',
                        'value'  => $password,
                        'expire' => '1209600'
                    );

                    $this->input->set_cookie($cookie_password);
                }

                redirect('users/profile');
                break;

            case 'disabled':
                $this->session->set_flashdata('message', array("info", "It appears your account has been disabled"));
                redirect('login');
                break;

            case 'inactive':
                $this->session->set_flashdata('message', array("info", "It appears your account has not yet been activated."));
                redirect('login');
                break;

            default:
                $this->session->set_flashdata('message', array("info", "Sorry we could not log you in."));
                redirect('login');
                break;
        }
    }

    public function forgot()
    {
        $data['root'] = base_url();
        $data['pageRoot'] = base_url().'index.php';
        $data['pagetitle'] = 'Forgot Password';

        $this->load->view('common/header', $data);
        $this->load->view('core/login/forgot-password', $data);
        $this->load->view('common/footer', $data);
    }

    public function password()
    {
        $this->load->model('model_login');

        $to = $this->input->post('email');
        $name = $this->input->post('username');

        if($to === '' || $name === '')
        {
            $this->session->set_flashdata('message', array("info", "We could not find you in our system."));
            redirect('login/forgot');
        }
        else
        {
            $legit_user = $this->model_login->user_validate();

            if($legit_user)
            {
                $rand = $this->model_login->new_password($name, $to);

                $from = 'do-not-reply';
                $subject = 'Your New Password';
                $message = '
<h4>Your New Password</h4><br />
<p>Username: '.$name.'</p>
<p>Password: '.$rand.'</p>
<p>Please be sure to change your password the nex2t time you login. Thank you.</p>';

                $this->load->library('email');

                $config['charset'] = 'utf-8';
                $config['protocol'] = 'mail';
                $config['mailtype'] = 'html';
                $config['wordwrap'] = TRUE;

                $this->email->initialize($config);
                $this->email->from($from);
                $this->email->to($to);
                $this->email->subject($subject);
                $this->email->message($message);
                $this->email->send();

                redirect("login/notify");
            }

            $this->session->set_flashdata('message', array("info", "Sorry, either your username or email was incorrect."));
            redirect("login/forgot");
        }
    }

    /**
     * When new users wish to join
     *
     * @return redirect
     */
    public function submit()
    {
        $this->load->model("model_users");
        $query = $this->model_users->add_profile(null, $this->input->post("password"), $this->quarx->get_option("auto_auth")); //image, password, auto-auth

        if ($query)
        {
            redirect("login/success");
        }

        $this->session->set_flashdata('error', 'Unable to successfully add your profile.');
        redirect("error");
    }

    public function success()
    {
        $data['root'] = base_url();
        $data['pageRoot'] = base_url().'index.php';
        $data['pagetitle'] = 'New Account';

        $this->load->view('common/header', $data);
        $this->load->view('core/login/success', $data);
        $this->load->view('common/footer', $data);
    }

    public function notify()
    {
        $data['root'] = base_url();
        $data['pageRoot'] = base_url().'index.php';
        $data['pagetitle'] = 'New Password Sent';

        $this->load->view('common/header', $data);
        $this->load->view('core/login/notify', $data);
        $this->load->view('common/footer', $data);
    }
}
/* End of file Login.php */
/* Location: ./application/controllers/ */