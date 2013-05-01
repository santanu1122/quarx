<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
     
class gallery extends MX_Controller {

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

/* Main Blog functions
***************************************************************/

    public function index() {
        $data['imageGalleryRequest'] = true;

        $data['root'] = base_url();
        $data['pageRoot'] = base_url().'index.php';
        $data['pagetitle'] = 'Gallery';

        //load the view elements
        $this->load->view('common/header', $data);
        $this->load->view('gallery/extras', $data);
        $this->load->view('gallery/gallery_menu', $gallery);
        $this->load->view('gallery/gallery', $data);
        $this->load->view('common/footer', $data);
    }

    public function add() {
        redirect('gallery');
    }

    public function editor($id) {
        $data['imageGalleryRequest'] = true;
        // we need this to decipher the category name from the category code
        $this->load->library('gallery_categorytools');
        
        //In order to see all our lovely gallery
        $this->load->model('model_gallery');
        $entry = $this->model_gallery->get_this_entry(decrypt($id));
        $data['gallery'] = $entry[0];

        //configured the data to be transported to the view
        $data['root'] = base_url();
        $data['pageRoot'] = base_url().'index.php';
        $data['pagetitle'] = 'Gallery : Editor';
        
        //load the view elements
        $this->load->view('common/header', $data);
        $this->load->view('gallery/extras', $data);
        $this->load->view('gallery/gallery_menu', $gallery);
        $this->load->view('gallery/editor', $data);
        $this->load->view('common/footer', $data);
    }

    public function view() {
        $this->load->model('model_gallery');
        $this->load->library('gallery_categorytools');
        $this->load->library("cryptography");

        //In order to see all our lovely gallery entries
        $data['entries'] = $this->model_gallery->get_all_entries();
        
        //configured the data to be transported to the view
        $data['root'] = base_url();
        $data['pageRoot'] = base_url().'index.php';
        $data['pagetitle'] = 'Gallery : View';
        
        //load the view elements
        $this->load->view('common/header', $data);
        $this->load->view('gallery/extras', $data);
        $this->load->view('gallery/gallery_menu', $gallery);
        $this->load->view('gallery/view', $data);
        $this->load->view('common/footer', $data);
    }

    function search(){
        $name = $_POST['search'];
        $this->load->model('model_gallery');
        $qry = $this->model_gallery->search_gallery($name);
        
        $this->load->library('gallery_categorytools');
        $this->load->library("cryptography");

        if($qry){
            $data['results'] = $qry;
        }else{
            $data['results'] = 'error';
        }

        $data['root'] = base_url();
        $data['pageRoot'] = base_url().'index.php';
        $data['pagetitle'] = 'Gallery : Search';
        
        //load the view elements
        $this->load->view('common/header', $data);
        $this->load->view('gallery/extras', $data);
        $this->load->view('gallery/gallery_menu', $gallery);
        $this->load->view('gallery/search', $data);
        $this->load->view('common/footer', $data);
    }

/* Redirects
***************************************************************/

    public function display_entry($id) {
        $this->load->library('cryptography');

        //In order to see all our lovely gallery
        $this->load->model('model_gallery');
        $qry = $this->model_gallery->display_entry(decrypt($id));
        if( $qry ){
            redirect('gallery/view');
        }
    }

    public function archive_entry($id) {
        $this->load->library('cryptography');

        //In order to see all our lovely gallery
        $this->load->model('model_gallery');
        $qry = $this->model_gallery->archive_entry(decrypt($id));
        if( $qry ){
            redirect('gallery/view');
        }
    }

    public function display_this_entry($id) {            
        $this->load->library('cryptography');

        //In order to see all our lovely gallery
        $this->load->model('model_gallery');
        $qry = $this->model_gallery->display_entry(decrypt($id));
        if( $qry ){
            redirect('gallery/editor/'.$id);
        }
    }

    public function archive_this_entry($id) {
        $this->load->library('cryptography');

        //In order to see all our lovely gallery
        $this->load->model('model_gallery');
        $qry = $this->model_gallery->archive_entry(decrypt($id));
        if( $qry ){
            redirect('gallery/editor/'.$id);
        }
    }

    public function delete_entry($id) {
        $this->load->library('cryptography');

        //In order to see all our lovely gallery
        $this->load->model('model_gallery');
        $qry = $this->model_gallery->delete_entry(decrypt($id));
        if( $qry ){
            redirect('gallery/view');
        }
    }

/* Add Blog Entry
***************************************************************/

    public function add_entry() {
        $this->load->model('model_gallery');
        $qry = $this->model_gallery->add_entry();
        
        if($qry){
            echo $qry;
        }else{
            echo 'duplicate title';
        }
    }

/* Edit Blog Entry
***************************************************************/

    public function update_entry() {
        $this->load->model('model_gallery');
        $qry = $this->model_gallery->edit_entry();
        
        if($qry){
            echo $qry;
        }
    }
    
}

/* End of file gallery.php */
/* Location: ./application/modules/gallery/controllers/ */