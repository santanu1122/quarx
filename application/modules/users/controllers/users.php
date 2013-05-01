<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
     
class users extends MX_Controller {

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
        redirect('users/view');
    }

    public function add() {
        // $data['imageGalleryRequest'] = true;

        $data['root'] = base_url();
        $data['pageRoot'] = base_url().'index.php';
        $data['pagetitle'] = 'Users';

        //load the view elements
        $this->load->view('common/header', $data);
        $this->load->view('users/extras', $data);
        $this->load->view('users/users_menu', $users);
        $this->load->view('users/users', $data);
        $this->load->view('common/footer', $data);
    }

    public function editor($id) {
        // $data['imageGalleryRequest'] = true;
        // $this->load->library('users_parent_tools');
        
        //In order to see all our lovely users
        // $this->load->model('model_users');
        // $entry = $this->model_users->get_this_entry(decrypt($id));
        // $data['users'] = $entry[0];

        //configured the data to be transported to the view
        $data['root'] = base_url();
        $data['pageRoot'] = base_url().'index.php';
        $data['pagetitle'] = 'Users : Editor';
        
        //load the view elements
        $this->load->view('common/header', $data);
        $this->load->view('users/extras', $data);
        $this->load->view('users/users_menu', $users);
        $this->load->view('users/editor', $data);
        $this->load->view('common/footer', $data);
    }

    public function view() {
        $this->load->model('model_users');
        // $this->load->library('users_parent_tools');

        //In order to see all our lovely users entries
        $data['users'] = $this->model_users->get_all_users();
        
        //configured the data to be transported to the view
        $data['root'] = base_url();
        $data['pageRoot'] = base_url().'index.php';
        $data['pagetitle'] = 'Users : View';
        
        //load the view elements
        $this->load->view('common/header', $data);
        $this->load->view('users/extras', $data);
        $this->load->view('users/users_menu', $data);
        $this->load->view('users/view', $data);
        $this->load->view('common/footer', $data);
    }

    function search(){
        $name = $_POST['search'];
        $this->load->model('model_users');
        $qry = $this->model_users->search_users($name);
        
        $this->load->library('users_parent_tools');

        if($qry){
            $data['results'] = $qry;
        }else{
            $data['results'] = 'error';
        }

        $data['root'] = base_url();
        $data['pageRoot'] = base_url().'index.php';
        $data['pagetitle'] = 'Pages : Search';
        $data['sub_menu_title'] = 'Pages : Search';
        
        //load the view elements
        $this->load->view('common/header', $data);
        $this->load->view('users/extras', $data);
        $this->load->view('users/users_menu', $users);
        $this->load->view('users/search', $data);
        $this->load->view('common/footer', $data);
    }

    public function options(){
        $this->load->model('model_users');
        $parents = $this->model_users->get_all_users();
            echo    '<option value="0">Please Select a Parent Page</option>';
            echo    '<option value="0">None</option>';
        
        foreach($parents as $item):
            echo '<option value="'.$item->page_id.'">'.$item->page_title.'</option>';
        endforeach;
    }

/* Redirects
***************************************************************/

    // public function display_entry($id) {
    //     $this->load->library('cryptography');

    //     //In order to see all our lovely users
    //     $this->load->model('model_users');
    //     $qry = $this->model_users->display_entry(decrypt($id));
    //     if( $qry ){
    //         redirect('users/view');
    //     }
    // }

    // public function archive_entry($id) {
    //     $this->load->library('cryptography');

    //     //In order to see all our lovely users
    //     $this->load->model('model_users');
    //     $qry = $this->model_users->archive_entry(decrypt($id));
    //     if( $qry ){
    //         redirect('users/view');
    //     }
    // }

    // public function display_this_entry($id) {            
    //     $this->load->library('cryptography');

    //     //In order to see all our lovely users
    //     $this->load->model('model_users');
    //     $qry = $this->model_users->display_entry(decrypt($id));
    //     if( $qry ){
    //         redirect('users/editor/'.$id);
    //     }
    // }

    // public function archive_this_entry($id) {
    //     $this->load->library('cryptography');

    //     //In order to see all our lovely users
    //     $this->load->model('model_users');
    //     $qry = $this->model_users->archive_entry(decrypt($id));
    //     if( $qry ){
    //         redirect('users/editor/'.$id);
    //     }
    // }

    // public function delete_entry($id) {
    //     $this->load->library('cryptography');

    //     //In order to see all our lovely users
    //     $this->load->model('model_users');
    //     $qry = $this->model_users->delete_entry(decrypt($id));
    //     if( $qry ){
    //         redirect('users/view');
    //     }
    // }

/* Invisible Functions
***************************************************************/

    public function unc($name) {
        if($name > ''){
            //load the preliminary parts
            $this->load->model('model_users');
            $query = $this->model_users->unc_validate($name);
            
            //check the data
            echo $query;
        }else{
            redirect('login');
        }
    }

/* Add Pages Entry
***************************************************************/

    public function add_entry() {
        $this->load->model('model_users');
        $qry = $this->model_users->add_entry();
        
        if($qry){
            echo $qry;
        }else{
            echo 'duplicate title';
        }
    }

/* Edit Pages Entry
***************************************************************/

    public function update_entry() {
        $this->load->model('model_users');
        $qry = $this->model_users->edit_entry();
        
        if($qry){
            echo $qry;
        }
    }
    
}

/* End of file users.php */
/* Location: ./application/modules/users/controllers/ */