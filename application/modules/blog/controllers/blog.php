<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
     
class blog extends MX_Controller {

    function __construct(){
        parent::__construct();
        if(!$this->session->userdata('logged_in')){
            redirect('login/error'); // Denied! 
        }

        if($this->session->userdata('permission') > 1){
            $setup = $this->onyxsetup->account_opts();
            //check if master access is on
            if($setup[2]->option_title === 'master access'){
                redirect('accounts/permission'); // Denied! 
            }
        }
    }

/* Main Blog functions
***************************************************************/

    public function index() {
        $data['imageGalleryRequest'] = true;

        $data['root'] = base_url();
        $data['pageRoot'] = base_url().'index.php';
        $data['pagetitle'] = 'Blog';

        //load the view elements
        $this->load->view('common/header', $data);
        $this->load->view('blog/extras', $data);
        $this->load->view('blog/blog_menu', $blog);
        $this->load->view('blog/blog', $data);
        $this->load->view('common/footer', $data);
    }

    public function add() {
        redirect('blog');
    }

    public function editor($id) {
        $data['imageGalleryRequest'] = true;
        // we need this to decipher the category name from the category code
        $this->load->library('blog_categorytools');
        
        //In order to see all our lovely blog
        $this->load->model('model_blog');
        $entry = $this->model_blog->get_this_entry(decrypt($id));
        $data['blog'] = $entry[0];

        //configured the data to be transported to the view
        $data['root'] = base_url();
        $data['pageRoot'] = base_url().'index.php';
        $data['pagetitle'] = 'Blog : Editor';
        
        //load the view elements
        $this->load->view('common/header', $data);
        $this->load->view('blog/extras', $data);
        $this->load->view('blog/blog_menu', $blog);
        $this->load->view('blog/editor', $data);
        $this->load->view('common/footer', $data);
    }

    public function view() {
        $this->load->model('model_blog');
        $this->load->library('blog_categorytools');
        $this->load->library("cryptography");

        //In order to see all our lovely blog entries
        $data['entries'] = $this->model_blog->get_all_entries();
        
        //configured the data to be transported to the view
        $data['root'] = base_url();
        $data['pageRoot'] = base_url().'index.php';
        $data['pagetitle'] = 'Blog : View';
        
        //load the view elements
        $this->load->view('common/header', $data);
        $this->load->view('blog/extras', $data);
        $this->load->view('blog/blog_menu', $blog);
        $this->load->view('blog/view', $data);
        $this->load->view('common/footer', $data);
    }

    function search(){
        $name = $_POST['search'];
        $this->load->model('model_blog');
        $qry = $this->model_blog->search_blog($name);
        
        $this->load->library('blog_categorytools');
        $this->load->library("cryptography");

        if($qry){
            $data['results'] = $qry;
        }else{
            $data['results'] = 'error';
        }

        $data['root'] = base_url();
        $data['pageRoot'] = base_url().'index.php';
        $data['pagetitle'] = 'Blog : Search';
        $data['sub_menu_title'] = 'Blog : Search';
        
        //load the view elements
        $this->load->view('common/header', $data);
        $this->load->view('blog/extras', $data);
        $this->load->view('blog/blog_menu', $blog);
        $this->load->view('blog/search', $data);
        $this->load->view('common/footer', $data);
    }

/* Redirects
***************************************************************/

    public function display_entry($id) {
        $this->load->library('cryptography');

        //In order to see all our lovely blog
        $this->load->model('model_blog');
        $qry = $this->model_blog->display_entry(decrypt($id));
        if( $qry ){
            redirect('blog/view');
        }
    }

    public function archive_entry($id) {
        $this->load->library('cryptography');

        //In order to see all our lovely blog
        $this->load->model('model_blog');
        $qry = $this->model_blog->archive_entry(decrypt($id));
        if( $qry ){
            redirect('blog/view');
        }
    }

    public function display_this_entry($id) {            
        $this->load->library('cryptography');

        //In order to see all our lovely blog
        $this->load->model('model_blog');
        $qry = $this->model_blog->display_entry(decrypt($id));
        if( $qry ){
            redirect('blog/editor/'.$id);
        }
    }

    public function archive_this_entry($id) {
        $this->load->library('cryptography');

        //In order to see all our lovely blog
        $this->load->model('model_blog');
        $qry = $this->model_blog->archive_entry(decrypt($id));
        if( $qry ){
            redirect('blog/editor/'.$id);
        }
    }

    public function delete_entry($id) {
        $this->load->library('cryptography');

        //In order to see all our lovely blog
        $this->load->model('model_blog');
        $qry = $this->model_blog->delete_entry(decrypt($id));
        if( $qry ){
            redirect('blog/view');
        }
    }

/* Add Blog Entry
***************************************************************/

    public function add_entry() {
        $this->load->model('model_blog');
        $qry = $this->model_blog->add_entry();
        
        if($qry){
            echo $qry;
        }else{
            echo 'duplicate title';
        }
    }

/* Edit Blog Entry
***************************************************************/

    public function update_entry() {
        $this->load->model('model_blog');
        $qry = $this->model_blog->edit_entry();
        
        if($qry){
            echo $qry;
        }
    }
    
}

/* End of file blog.php */
/* Location: ./application/modules/blog/controllers/ */