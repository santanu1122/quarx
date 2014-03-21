<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
     
class inbox extends MX_Controller {

    function __construct(){
        parent::__construct();
        if(!$this->session->userdata('logged_in')){
            redirect('login/error'); // Denied! 
        }

        if($this->session->userdata('permission') > 1){
            $access = check_master_access(); //check if master access is on
            if($access){
                redirect('login/insufficient'); // Denied! 
            }
        }
    }

/* Main Pages functions
***************************************************************/

    public function index() 
    {
        redirect('inbox/view');
    }

    public function compose($to = null) 
    {
        $this->load->library("inbox_tools");

        if($to != null){
            $data["to"] = $to;
        }

        $data['root'] = base_url();
        $data['pageRoot'] = base_url().'index.php';
        $data['pagetitle'] = 'Inbox : Compose';

        //load the view elements
        $this->load->view('common/header', $data);
        $this->load->view('inbox/extras', $data);
        $this->load->view('inbox/inbox_menu', $users);
        $this->load->view('inbox/compose', $data);
        $this->load->view('common/footer', $data);
    }

    public function find_users($name) 
    {
        $this->load->model("model_inbox");
        $qry = $this->model_inbox->find_users($name);
        $data = "";

        foreach ($qry as $u) :
            $data .= "<li>".$u->user_name."</li>";
        endforeach;

            $data .= '
            <script type="text/javascript">
            $(".select-a-user ul li").bind("click", function(){

                $("#u_name").val($(this).text());

                $("#quarx-modal").css({
                    display: "none"
                });

                $(".select-a-user").slideUp();
            });
            </script>';
        
        echo $data;
    }

    public function view() 
    {
        $data['status'] = "";
        $data['message'] = "";

        if($this->session->flashdata('error')){
            $data['status'] = "error-box";
            $data['message'] = $this->session->flashdata('error');
        }

        if($this->session->flashdata('success')){
            $data['status'] = "success-box";
            $data['message'] = $this->session->flashdata('success');
        }

        $this->load->model('model_inbox');

        $data['messages'] = $this->model_inbox->get_all_my_messages();
        
        $data['root'] = base_url();
        $data['pageRoot'] = base_url().'index.php';
        $data['pagetitle'] = 'Inbox : View';
        
        $this->load->view('common/header', $data);
        $this->load->view('inbox/extras', $data);
        $this->load->view('inbox/inbox_menu', $data);
        $this->load->view('inbox/view', $data);
        $this->load->view('common/footer', $data);
    }

    function search()
    {
        $term = $this->input->post('search');
        $this->load->model('model_inbox');
        $qry = $this->model_inbox->search_inbox($term);

        if($qry){
            $data['results'] = $qry;
        }else{
            $data['results'] = 'error';
        }

        $data['root'] = base_url();
        $data['pageRoot'] = base_url().'index.php';
        $data['pagetitle'] = 'Inbox : Search';
        
        //load the view elements
        $this->load->view('common/header', $data);
        $this->load->view('inbox/extras', $data);
        $this->load->view('inbox/inbox_menu', $data);
        $this->load->view('inbox/search', $data);
        $this->load->view('common/footer', $data);
    }

    public function message($id) 
    {
        $this->load->model('model_inbox');

        $data['messages'] = $this->model_inbox->get_this_message(decrypt($id));
        
        $data['root'] = base_url();
        $data['pageRoot'] = base_url().'index.php';
        $data['pagetitle'] = 'Inbox : Message';
        
        $this->load->view('common/header', $data);
        $this->load->view('inbox/extras', $data);
        $this->load->view('inbox/inbox_menu', $data);
        $this->load->view('inbox/message', $data);
        $this->load->view('common/footer', $data);
    }

    public function settings() {

    }

/* Send Message
***************************************************************/

    public function send_message() 
    {
        $this->load->library("inbox_tools");

        $this->load->model("model_inbox");
        $result = $this->model_inbox->send_message();

        if($result){
            $this->session->set_flashdata('success', 'Your message was successfully sent.');
        }else{
            $this->session->set_flashdata('error', 'Your message was not delivered please try again.');
        }

        redirect("inbox/view");
    }


/* Delete User
***************************************************************/

    public function delete_message($id) {
        $this->load->model('model_inbox');
        $qry = $this->model_inbox->delete_message(decrypt($id));
        
        if($qry){
            $this->session->set_flashdata('success', 'You\'ve successfully deleted a message');
            redirect('inbox/view');
        }else{
            $this->session->set_flashdata('error', 'We could not delete that message, please try again.');
            redirect('inbox/view');
        }
    }

}

/* End of file inbox.php */
// /* Location: ./application/modules/inbox/controllers/ */