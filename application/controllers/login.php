<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
     
class login extends CI_Controller {

/* Main Login
***************************************************************/

    public function index() 
    { 
        $this->load->model('modelsetup');
        $qry = $this->modelsetup->is_installed();
        
        if($qry === false)
        {
            redirect('setup');
        }
        else
        { 
            if($this->session->userdata('logged_in'))
            { 
                redirect('accounts');
            }

            $this->load->helper('cookie');
            $this->load->model('modellogin');
            $query = $this->modellogin->cookie_validate($this->input->cookie('quarx-uname'), $this->input->cookie('quarx-pword'));

            if($query === 'fail')
            {
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
                redirect('accounts');
            }
        }
    }

    public function error() 
    {
        $this->load->model('modelsetup');
        $qry = $this->modelsetup->is_installed();
        
        if($qry === false)
        {
            redirect('setup');
        }
        else
        { 
            $this->load->helper('cookie');
            $this->load->model('modellogin');
            
            $data['root'] = base_url();
            $data['pageRoot'] = base_url().'index.php';
            $data['pagetitle'] = 'Limbo';
            $data['date'] = date("m-d-y");
            
            $this->load->view('common/header', $data);
            $this->load->view('core/login/login_error', $data);
            $this->load->view('common/footer', $data);
        }
    }

    public function insufficient()
    {
        $this->load->model('modelsetup');
        $qry = $this->modelsetup->is_installed();
        
        if($qry === false)
        {
            redirect('setup');
        }
        else
        { 
            $data['root'] = base_url();
            $data['pageRoot'] = base_url().'index.php';
            $data['pagetitle'] = 'Limbo';
            
            $this->load->view('common/header', $data);
            $this->load->view('core/login/insufficient', $data);
            $this->load->view('common/footer', $data);
        }
    }

/* Account Validation
***************************************************************/

    public function validator() 
    {
        $this->load->model('modellogin');
        $query = $this->modellogin->validate();

        if($query == 'valid')
        {
            $data = array(
                'username' => $this->input->post('username'),
                'logged_in' => true
            );

            $this->session->set_userdata($data);

            redirect('accounts');
        }

        if($query == 'unauthorized')
        {
            $data['error'] = "Sorry you're not yet authorized to access this system.";
        }
        
        if($query == 'disabled')
        {
            $data['error'] = "Sorry your account was disabled.";
        }   
        
        if($query == 'noAccount')
        {   
            $data['error'] = "Sorry either your username or password was incorrect.";
        }
            $data['root'] = base_url();
            $data['pageRoot'] = base_url().'index.php';
            $data['pagetitle'] = 'Sign In';
            $data['date'] = date("m-d-y");
            
            $this->load->view('common/header', $data);
            $this->load->view('core/login/login', $data);
            $this->load->view('common/footer', $data);
    }
    
/* Forgotten Password
***************************************************************/

    public function forgotpassword() 
    {  
        if(isset($_GET['e']))
        {
            $data['error'] = "Sorry we couldn't find your account.";
        }      

        $data['root'] = base_url();
        $data['pageRoot'] = base_url().'index.php';
        $data['pagetitle'] = 'Forgot Password';

        $this->load->view('common/header', $data);
        $this->load->view('core/login/forgotpassword', $data);
        $this->load->view('common/footer', $data);
    }

    public function newpasswordsender() 
    {
        $to = $this->input->post('u_email');
        $name = $this->input->post('u_name');

        if($to === '' || $name === '')
        {
            redirect('login/forgotpassword?e');
        }
        else
        {
            $this->load->model('modellogin');
            $query = $this->modellogin->user_validate();

            if($query)
            {
                $rand = $this->modellogin->newpassword();
                
                $from = 'do-not-reply';
                $subject = 'Your New Password';
                $message = '
<h4>Your New Password</h4><br />
<p>Username: '.$this->input->post('u_name').'</p>
<p>Password: '.$rand.'</p>
<p>Please be sure to change your password the next time you login. Thank you.</p>';

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
                
                $data['email_errors'] = $this->email->print_debugger(); 
                $data['root'] = base_url();
                $data['pageRoot'] = base_url().'index.php';
                $data['pagetitle'] = 'New Password Sent';
                
                $this->load->view('common/header', $data);
                $this->load->view('core/login/passwordsent', $data);
                $this->load->view('common/footer', $data);

            }
            else
            {
                $data['error'] = "Sorry either your username or email was incorrect.";
                $data['root'] = base_url();
                $data['pageRoot'] = base_url().'index.php';
                $data['pagetitle'] = 'Forgot Password';

                $this->load->view('common/header', $data);
                $this->load->view('core/login/forgotpassword', $data);
                $this->load->view('common/footer', $data);
            }
        }
    }

}
/* End of file login.php */
/* Location: ./application/controllers/ */