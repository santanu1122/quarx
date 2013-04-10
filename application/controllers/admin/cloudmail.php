<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    // Author: Matt Lantz
     
class cloudmail extends CI_Controller {

    public function __construct(){
        parent::__construct();
        if(!$this->session->userdata('logged_in')){
            redirect('login/error'); // Denied! 
        }

        if($this->session->userdata('permission') > 1){
            $setup = $this->quarxsetup->account_opts();
            //check if master access is on
            if($setup[2]->option_title === 'master access'){
                redirect('accounts/permission'); // Denied! 
            }
        }

        $this->lang->load(config_item('language_abbr'), config_item('language'));
    } 


/* Primary Tools
*****************************************************************/

    public function index(){           
        if($this->session->userdata('permission') == 1){
            //Check active plugins
            $this->load->model('modelsetup');
            
            $this->load->model('modelaccounts');
            $data['account'] = $this->modelaccounts->all_profiles_unlimited();
            
            //configured the data to be transported to the view
            $data['root'] = base_url();
            $data['pageRoot'] = base_url().'index.php';
            $data['pagetitle'] = 'CloudMail';
            $data['sub_menu_title'] = 'CloudMail';
            
            //load the view elements
            $this->load->view('common/header', $data);
            $this->load->view('core/admin/cloudmail', $data);
            $this->load->view('common/footer', $data);

        }else{
            redirect('accounts/insufficient');
        }
    }

    public function success(){
        //Check active plugins
        $this->load->model('modelsetup');
        
        $this->load->model('modelaccounts');
        $data['account'] = $this->modelaccounts->all_profiles_unlimited();

        $data['root'] = base_url();
        $data['pageRoot'] = base_url().'index.php';
        $data['pagetitle'] = 'CloudMail';
        $data['sub_menu_title'] = 'CloudMail';
        
        //load the view elements
        $this->load->view('common/header', $data);
        $this->load->view('core/admin/cloudmail_success', $data);
        $this->load->view('common/footer', $data);

    }

/* Email
*************************************************************/
    
    public function email() {
        if($this->session->userdata('logged_in')){ 
            if($this->session->userdata('permission') == 1){
                $to = $_POST['to'];
                $from = 'do-not-reply';
                $name = '';
                $subject = $_POST['subject'];
                $message = $_POST['message'];
                
                //load the email base class
                $this->load->library('email');

                $config['charset'] = 'utf-8';
                $config['protocol'] = 'sendmail';
                $config['mailtype'] = 'html';
                $config['wordwrap'] = TRUE;

                $this->email->initialize($config);
                
                //set the who, and from
                $this->email->from($from, $name);
                $this->email->to($to);
                //$this->email->cc('another@another-example.com');
                //$this->email->bcc('them@their-example.com');
            
                //set the subject, message, attachments etc.
                $this->email->subject($subject);
                $this->email->message($message);
                
                    /*foreach($attachment as $attach) :
                    
                        $this->email->attach($attach);
                
                    endforeach;*/
                
                //rocket that email into cyber space
                $this->email->send();
                
                //set the variable of the errors
                $data['email_errors'] = $this->email->print_debugger(); 
                
                //load the success viewer
                redirect('admin/cloudmail/success');
            }
        }
    }

}
/* End of file admin.php */
/* Location: ./application/controllers/ */