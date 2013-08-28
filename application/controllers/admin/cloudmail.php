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
     
class cloudmail extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        if(!$this->session->userdata('logged_in'))
        {
            redirect('login/error');
        }

        if($this->session->userdata('permission') > 1)
        {
            $setup = $this->quarxsetup->account_opts();
            if($setup[2]->option_title === 'master access')
            {
                redirect('accounts/permission');
            }
        }

        $this->lang->load(config_item('language_abbr'), config_item('language'));
    } 


/* Primary Tools
*****************************************************************/

    public function index()
    {           
        if($this->session->userdata('permission') == 1)
        {
            $this->load->model('modelsetup');
            $this->load->model('modelaccounts');
            $data['account'] = $this->modelaccounts->all_profiles_unlimited();
            
            $data['root'] = base_url();
            $data['pageRoot'] = base_url().'index.php';
            $data['pagetitle'] = 'CloudMail';
            $data['sub_menu_title'] = 'CloudMail';
            
            $this->load->view('common/header', $data);
            $this->load->view('core/admin/cloudmail', $data);
            $this->load->view('common/footer', $data);

        }
        else
        {
            redirect('accounts/insufficient');
        }
    }

    public function success()
    {
        $this->load->model('modelsetup');
        $this->load->model('modelaccounts');
        $data['account'] = $this->modelaccounts->all_profiles_unlimited();

        $data['root'] = base_url();
        $data['pageRoot'] = base_url().'index.php';
        $data['pagetitle'] = 'CloudMail';
        $data['sub_menu_title'] = 'CloudMail';
        
        $this->load->view('common/header', $data);
        $this->load->view('core/admin/cloudmail_success', $data);
        $this->load->view('common/footer', $data);
    }

/* Email
*************************************************************/
    
    public function email() {
        if($this->session->userdata('logged_in'))
        {     
            if($this->session->userdata('permission') == 1)
            {
                $to = $_POST['to'];
                $from = 'do-not-reply@'.$_SERVER['HTTP_HOST'];
                $name = '';
                $subject = $_POST['subject'];
                $message = $_POST['message'];
                
                $this->load->library('email');

                $config['charset'] = 'utf-8';
                $config['protocol'] = 'sendmail';
                $config['mailtype'] = 'html';
                $config['wordwrap'] = TRUE;

                $this->email->initialize($config);
                $this->email->from($from, $name);
                $this->email->to($to);
                $this->email->subject($subject);
                $this->email->message($message);
                
                $mailbot = $this->email->send();
                
                if($mailbot)
                {
                    redirect('admin/cloudmail/success');
                }
                else
                {
                    echo $this->email->print_debugger(); 
                }
            }
        }
    }

}
/* End of file cloudmail.php */
/* Location: ./application/controllers/ */