<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
     
class pages extends MX_Controller {

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

    public function index() {
        $data['imageGalleryRequest'] = true;

        $data['root'] = base_url();
        $data['pageRoot'] = base_url().'index.php';
        $data['pagetitle'] = 'Pages';

        //load the view elements
        $this->load->view('common/header', $data);
        $this->load->view('pages/extras', $data);
        $this->load->view('pages/pages_menu', $pages);
        $this->load->view('pages/pages', $data);
        $this->load->view('common/footer', $data);
    }

    public function add() {
        redirect('pages');
    }

    public function editor($id) {
        $data['imageGalleryRequest'] = true;
        $this->load->library('pages_parent_tools');
        
        //In order to see all our lovely pages
        $this->load->model('model_pages');
        $entry = $this->model_pages->get_this_entry(decrypt($id));
        $data['pages'] = $entry[0];

        //configured the data to be transported to the view
        $data['root'] = base_url();
        $data['pageRoot'] = base_url().'index.php';
        $data['pagetitle'] = 'Pages : Editor';
        
        //load the view elements
        $this->load->view('common/header', $data);
        $this->load->view('pages/extras', $data);
        $this->load->view('pages/pages_menu', $pages);
        $this->load->view('pages/editor', $data);
        $this->load->view('common/footer', $data);
    }

    public function view() {
        $this->load->model('model_pages');
        $this->load->library('pages_parent_tools');

        //In order to see all our lovely pages entries
        $data['entries'] = $this->model_pages->get_all_pages();
        
        //configured the data to be transported to the view
        $data['root'] = base_url();
        $data['pageRoot'] = base_url().'index.php';
        $data['pagetitle'] = 'Pages : View';
        
        //load the view elements
        $this->load->view('common/header', $data);
        $this->load->view('pages/extras', $data);
        $this->load->view('pages/pages_menu', $pages);
        $this->load->view('pages/view', $data);
        $this->load->view('common/footer', $data);
    }

    function search(){
        $name = $this->input->post('search');
            
            // print_r($_POST);

        $this->load->model('model_pages');
        $qry = $this->model_pages->search_page($name);
        
        $this->load->library('pages_parent_tools');

        if($qry){
            $data['results'] = $qry;
        }else{
            $data['results'] = 'error';
        }

        $data['root'] = base_url();
        $data['pageRoot'] = base_url().'index.php';
        $data['pagetitle'] = 'Pages : Search';
        
        //load the view elements
        $this->load->view('common/header', $data);
        $this->load->view('pages/extras', $data);
        $this->load->view('pages/pages_menu', $pages);
        $this->load->view('pages/search', $data);
        $this->load->view('common/footer', $data);
    }

    public function options(){
        $this->load->model('model_pages');
        $parents = $this->model_pages->get_all_pages();
            echo    '<option value="0">Please Select a Parent Page</option>';
            echo    '<option value="0">None</option>';
        
        foreach($parents as $item):
            echo '<option value="'.$item->page_id.'">'.$item->page_title.'</option>';
        endforeach;
    }

/* Redirects
***************************************************************/

    public function display_entry($id) {
        $this->load->library('cryptography');

        //In order to see all our lovely pages
        $this->load->model('model_pages');
        $qry = $this->model_pages->display_entry(decrypt($id));
        if( $qry ){
            redirect('pages/view');
        }
    }

    public function archive_entry($id) {
        $this->load->library('cryptography');

        //In order to see all our lovely pages
        $this->load->model('model_pages');
        $qry = $this->model_pages->archive_entry(decrypt($id));
        if( $qry ){
            redirect('pages/view');
        }
    }

    public function display_this_entry($id) {            
        $this->load->library('cryptography');

        //In order to see all our lovely pages
        $this->load->model('model_pages');
        $qry = $this->model_pages->display_entry(decrypt($id));
        if( $qry ){
            redirect('pages/editor/'.$id);
        }
    }

    public function archive_this_entry($id) {
        $this->load->library('cryptography');

        //In order to see all our lovely pages
        $this->load->model('model_pages');
        $qry = $this->model_pages->archive_entry(decrypt($id));
        if( $qry ){
            redirect('pages/editor/'.$id);
        }
    }

    public function delete_entry($id) {
        $this->load->library('cryptography');

        //In order to see all our lovely pages
        $this->load->model('model_pages');
        $qry = $this->model_pages->delete_entry(decrypt($id));
        if( $qry ){
            redirect('pages/view');
        }
    }

/* Add Pages Entry
***************************************************************/

    public function add_entry() {
        $this->load->model('model_pages');
        $qry = $this->model_pages->add_entry();
        
        if($qry){
            echo $qry;
        }else{
            echo 'duplicate title';
        }
    }

/* Edit Pages Entry
***************************************************************/

    public function update_entry() {
        $this->load->model('model_pages');
        $qry = $this->model_pages->edit_entry();
        
        if($qry){
            echo $qry;
        }
    }
    
}

/* End of file pages.php */
/* Location: ./application/modules/pages/controllers/ */