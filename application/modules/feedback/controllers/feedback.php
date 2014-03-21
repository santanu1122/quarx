<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
     
class feedback extends MX_Controller {

    function __construct()
    {
        parent::__construct();
        if(!$this->session->userdata('logged_in'))
        {
            redirect('login/error');
        }

        if($this->session->userdata('permission') > 1)
        {
            $setup = $this->onyxsetup->account_opts();
            if($setup[2]->option_title === 'master access')
            {
                redirect('accounts/permission');
            }
        }
    }

/* Main Blog functions
***************************************************************/

    public function index() 
    {
        $data['root'] = base_url();
        $data['pageRoot'] = base_url().'index.php';
        $data['pagetitle'] = 'Feedback';

        $this->load->view('common/header', $data);
        $this->load->view('feedback/feedback_menu', $data);
        $this->load->view('feedback/generate_link', $data);
        $this->load->view('common/footer', $data);
    }

    public function link() 
    {
        redirect('feedback');
    }

    public function editor($id) 
    {
        $this->load->library('rating_calc');
        
        $this->load->model('model_feedback');
        $rating = $this->model_feedback->get_this_rating(decrypt($id));

        $data['feedback'] = $this->model_feedback->get_this_feedback($rating[0]->fbr_feedback_id);
        $data['rating'] = $rating[0];
        $data['root'] = base_url();
        $data['pageRoot'] = base_url().'index.php';
        $data['pagetitle'] = 'Feedback : Review';

        $this->load->view('common/header', $data);
        $this->load->view('feedback/feedback_menu', $data);
        $this->load->view('feedback/editor', $data);
        $this->load->view('common/footer', $data);
    }

    public function view() 
    {
        $this->load->model('model_feedback');
        $this->load->library("rating_calc");

        $data['rating'] = $this->model_feedback->get_all_feedback();
        $data['root'] = base_url();
        $data['pageRoot'] = base_url().'index.php';
        $data['pagetitle'] = 'Feedback : View';
        
        $this->load->view('common/header', $data);
        $this->load->view('feedback/feedback_menu', $data);
        $this->load->view('feedback/view', $data);
        $this->load->view('common/footer', $data);
    }

    public function pending() 
    {
        $this->load->model('model_feedback');
        $this->load->library("rating_calc");

        $data['rating'] = $this->model_feedback->get_all_pending_feedback();
        $data['root'] = base_url();
        $data['pageRoot'] = base_url().'index.php';
        $data['pagetitle'] = 'Feedback : Pending';
        
        $this->load->view('common/header', $data);
        $this->load->view('feedback/feedback_menu', $data);
        $this->load->view('feedback/pending', $data);
        $this->load->view('common/footer', $data);
    }

/* Redirects
***************************************************************/

    public function delete_entry($id) 
    {
        $this->load->library('rating_calc');
        $this->load->model('model_feedback');

        $id = decrypt($id);

        $qry = $this->model_feedback->delete_entry($id);
        if( $qry )
        {
            redirect('feedback/view');
        }
    }

    public function archive_entry($id) 
    {
        $this->load->model('model_feedback');

        $id = decrypt($id);

        $qry = $this->model_feedback->archive_entry($id);
        if( $qry )
        {
            redirect('feedback/view');
        }
    }

    public function display_entry($id) 
    {            
        $this->load->model('model_feedback');

        $id = decrypt($id);

        $qry = $this->model_feedback->display_entry($id);
        
        if( $qry )
        {
            redirect('feedback/view/');
        }
    }

    public function update_rating() 
    {
        $this->load->model('model_feedback');

        $qry = $this->model_feedback->update_rating();
        if( $qry )
        {
            redirect('feedback/view?s');
        }
    }

/* Add a Feedback link
***************************************************************/

    public function generate_link() 
    {
        $this->load->model('model_feedback');
        $qry = $this->model_feedback->generate_link();

        if($qry['success'])
        {
            $to_client = $_POST['client_email'];
            $from = 'do-not-reply@waymar.on.ca';
            $name = 'Way-Mar Inc';
            $subject = 'Way-Mar Feedback';

            $this->load->library('email');
            
            $config['charset'] = 'utf-8';
            $config['protocol'] = 'mail';
            $config['mailtype'] = 'html';
            $config['wordwrap'] = TRUE;

            $this->email->initialize($config);
            $this->email->from($from, $name);
            $this->email->to($to_client);
            $this->email->subject($subject);
            $this->email->message(
                '<p>Dear '.$_POST['client_name']. ',</p><br />' .
                '<p>We here at Way-Mar greatly value our customers opinions and would like to request that you complete our online feedback form by clicking the link below.</p>' .
                '<p>We appreciate you taking the time to provide us with your information and opinion.</p>' .
                '<p>Feel free to contact us anytime at: 519-699-4236.</p><br />' .
                '<a href="http://waymar.on.ca/feedback/provide/'.$qry['key'].'">Click here to provide feedback</a>');

            if (!$this->email->send())
            {
                $data['email_errors'] = $this->email->print_debugger(); 
                echo $data['email_errors'];
            }
            else
            {
                echo '{ "success" : "true", "key" : "'.$qry['key'].'" }';
            }
        }
        else
        {
            echo 'didnt work';
        }
    }
}

/* End of file feedback.php */
/* Location: ./application/controllers/ */