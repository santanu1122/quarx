<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// Author: Matt Lantz
     
class login extends CI_Controller {

/* Main Login
***************************************************************/

    public function index() { 
        $this->load->model('modellogin');
        $qry = $this->modellogin->is_installed();
        
        if($qry === false){
            redirect('setup');
        }else{ 

            //verify we're not logged in
            if($this->session->userdata('logged_in')){ 
                redirect('accounts');
            }

            // load the cookie helper
            $this->load->helper('cookie');
            $this->load->model('modellogin');
            // This needs to be reviewed so that it works. Not sure what is going on here.
            $query = $this->modellogin->cookie_validate($this->input->cookie('quarx-uname'), $this->input->cookie('quarx-pword'));

            // echo $this->input->cookie('quarx-uname').' - '.$this->input->cookie('quarx-pword');

            if($query === 'fail'){
                //configured the data to be transported to the view
                $data['root'] = base_url();
                $data['pageRoot'] = base_url().'index.php';
                $data['pagetitle'] = 'Login';
                $data['date'] = date("m-d-y");
                
                //load the view elements
                $this->load->view('common/header', $data);
                $this->load->view('common/mainmenu', $data);
                $this->load->view('core/login/login', $data);
                $this->load->view('common/footer', $data);
            
            }else{
                redirect('accounts');
            }
        }
    }

    public function error() {   
        //load the cookie helper
        $this->load->helper('cookie');
        $this->load->model('modellogin');
        
        //configured the data to be transported to the view
        $data['root'] = base_url();
        $data['pageRoot'] = base_url().'index.php';
        $data['pagetitle'] = 'Login';
        $data['date'] = date("m-d-y");
        
        //load the view elements
        $this->load->view('common/header', $data);
        $this->load->view('common/mainmenu', $data);
        $this->load->view('core/login/login_error', $data);
        $this->load->view('common/footer', $data);
    }

/* Account Validation
***************************************************************/

    public function validator() {
        //load the preliminary parts
        $this->load->model('modellogin');
        $query = $this->modellogin->validate();

        if($query == 'valid'){
            $data = array(
                'username' => $this->input->post('username'),
                'logged_in' => true
            );

            $this->session->set_userdata($data);

            redirect('accounts');
        }
        if($query == 'unauthorized'){
            $data['error'] = "Sorry you're not yet authorized to access this system.";
        }
        if($query == 'disabled'){
            $data['error'] = "Sorry your account was disabled.";
        }   
        if($query == 'noAccount'){   
            $data['error'] = "Sorry either your username or password was incorrect.";
        }
            //configure the data to be transported to the view
            $data['root'] = base_url();
            $data['pageRoot'] = base_url().'index.php';
            $data['pagetitle'] = 'Sign In';
            $data['date'] = date("m-d-y");
            
            //load the view elements
            $this->load->view('common/header', $data);
            $this->load->view('common/mainmenu', $data);
            $this->load->view('core/login/login', $data);
            $this->load->view('common/footer', $data);
    }
    
/* Forgotten Password
***************************************************************/

    public function forgotpassword() {  
        if(isset($_GET['e'])){
            $data['error'] = "Sorry we couldn't find your account.";
        }      
        //set some data and parameters
        $data['root'] = base_url();
        $data['pageRoot'] = base_url().'index.php';
        $data['pagetitle'] = 'Forgot Password';
        
        // load the view components
        $this->load->view('common/header', $data);
        $this->load->view('common/mainmenu', $data);
        $this->load->view('core/login/forgotpassword', $data);
        $this->load->view('common/footer', $data);
    }

    public function newpasswordsender() {
        $to = $this->input->post('u_email');
        $name = $this->input->post('u_name');
        if($to === '' || $name === ''){
            redirect('login/forgotpassword?e');
        }else{
            //load the preliminary parts
            $this->load->model('modellogin');
            $query = $this->modellogin->user_validate();

            // if the user's credentials validated...
            if($query){
                $rand = $this->modellogin->newpassword();
                
                //Class: Emailer1000
                $from = 'do-not-reply';
                $subject = 'Your New Password';
                $message = '
<h4>Your New Password</h4><br />
<p>Username: '.$this->input->post('u_name').'</p>
<p>Password: '.$rand.'</p>
<p>Please be sure to change your password the next time you login. Thank you.</p>';
            
                //load the email base class
                $this->load->library('email');

                //configure the emailer
                $config['charset'] = 'utf-8';
                $config['protocol'] = 'sendmail';
                $config['mailtype'] = 'html';
                $config['wordwrap'] = TRUE;
                $this->email->initialize($config);
                
                //set the who, and from
                $this->email->from($from);
                $this->email->to($to);
                $this->email->subject($subject);
                $this->email->message($message);
                
                //rocket that email into cyber space
                $this->email->send();
                
                //set the variable of the errors
                $data['email_errors'] = $this->email->print_debugger(); 
                
                //set some data and parameters
                $data['root'] = base_url();
                $data['pageRoot'] = base_url().'index.php';
                $data['pagetitle'] = 'New Password Sent';
                
                // load the view components
                $this->load->view('common/header', $data);
                $this->load->view('common/mainmenu', $data);
                $this->load->view('core/login/passwordsent', $data);
                $this->load->view('common/footer', $data);
            }else{
                
                //unfortuneatley there is an error
                $data['error'] = "Sorry either your username or email was incorrect.";
                
                //just some minor stuff
                $data['root'] = base_url();
                $data['pageRoot'] = base_url().'index.php';
                $data['pagetitle'] = 'Forgot Password';
                
                // load the view components
                $this->load->view('common/header', $data);
                $this->load->view('common/mainmenu', $data);
                $this->load->view('core/login/forgotpassword', $data);
                $this->load->view('common/footer', $data);
            }
        }
    }

}
/* End of file login.php */
/* Location: ./application/controllers/ */