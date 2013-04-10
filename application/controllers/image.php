<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// Author: Matt Lantz
     
class image extends CI_Controller {

    function __construct(){
        parent::__construct();
        
        if(!$this->session->userdata('logged_in')){
            print_r( 'Denied' );
            exit();
        }

        $this->lang->load(config_item('language_abbr'), config_item('language'));
    }

/* Main Image Upload Visuals
***************************************************************/
    
    public function index() {        
        //configured the data to be transported to the view
        $data['root'] = base_url();
        $data['pageRoot'] = base_url().'index.php';

        $data['libraryHome'] = true;

        //load the view elements
        $this->load->view('core/image/header', $data);
        $this->load->view('core/image/main', $data);
        $this->load->view('core/image/footer', $data);
    }

/* Library
***************************************************************/
    public function library(){
        $data['root'] = base_url();
        $data['pageRoot'] = base_url().'index.php';

        $data['fullScreen'] = true;

        $data['pagetitle'] = 'Image Library';

        $data['libraryHome'] = true;

        $this->load->view('common/header', $data);
        $this->load->view('core/image/library');
        $this->load->view('common/footer', $data);
    }

    public function error() {
        if($this->session->userdata('logged_in')){          
            $type = $_GET['type'];
            
            //configured the data to be transported to the view
            $data['root'] = base_url();
            $data['pageRoot'] = base_url().'index.php';
            $data['type'] = $type;

            //load the view elements
            $this->load->view('core/pictures/error', $data);
        }else{
            redirect('picture/error');
        }
    }

    public function add() {
        $data['root'] = base_url();
        $data['pageRoot'] = base_url().'index.php';
        
        //load the view elements
        $this->load->view('core/image/header', $data);
        $this->load->view('core/image/add', $data);
    }

    public function collections($collection = null){
        $this->load->model('modelimg');
        $data['image'] = $this->modelimg->get_all_img($collection);

        if($collection != null){
            $data['img_collection_name'] = $this->modelimg->get_collection_name($collection);
        }

        $data['root'] = base_url();
        $data['pageRoot'] = base_url().'index.php';

        $this->load->view('core/image/header', $data);
        $this->load->view('core/image/img_feed', $data);
    }

    public function manager() {        
        $this->load->model('modelimg');
        $data['collection'] = $this->modelimg->get_collections();

        $data['root'] = base_url();
        $data['pageRoot'] = base_url().'index.php';

        $this->load->view('core/image/header', $data);
        $this->load->view('core/image/manager', $data);
    }

    public function change($id) {
        $data['imageId'] = $id;

        $data['root'] = base_url();
        $data['pageRoot'] = base_url().'index.php';

        $this->load->view('core/image/header', $data);
        $this->load->view('core/image/change', $data);
    }

/* Image Upload Processes
***************************************************************/
    
/* Generate a thumbnail img
*************************************/
    function make_thumb($img){
        $this->load->library('image_lib');
        //set the configuration to make a new file
        $config['image_library'] = 'gd2';
        $config['source_image'] = './uploads/img/full/'.$img;
        $config['new_image'] = './uploads/img/thumb/'.$img;
        $config['thumb_marker'] = TRUE;
        $config['maintain_ratio'] = TRUE;
        $config['width'] = 250;
        $config['height'] = 188;
        //initialize the function
        $this->image_lib->initialize($config);
        //run the function
        $this->image_lib->resize();
        $this->image_lib->clear();
    }

/* Generate a medium img
*************************************/
    function make_medium($img){
        $this->load->library('image_lib');
        //set the configuration to make a new file
        $config['image_library'] = 'gd2';
        $config['source_image'] = './uploads/img/full/'.$img;
        $config['new_image'] = './uploads/img/medium/'.$img;
        $config['thumb_marker'] = TRUE;
        $config['maintain_ratio'] = TRUE;
        $config['width'] = 800;
        $config['height'] = 600;
        //initialize the function
        $this->image_lib->initialize($config);
        //run the function
        $this->image_lib->resize();
        $this->image_lib->clear();
    }
    
/* Add the image
*************************************/
    public function add_image(){
        $collection = 1;
        //We will need this model
        $this->load->model('modelimg');
        
        //load the form helper to help with the image upload
        $this->load->helper(array('form', 'url'));
        
        //set the parameters of the files new name
        $id = 'img';
        $now = time();

        ini_set('memory_limit','128M');
        
        //setting the configuration for the file uploads
        $config['upload_path'] = './uploads/img/full/';
        $config['allowed_types'] = 'gif|jpg|jpeg|png|GIF|JPG|JPEG|PNG';
        $config['max_size'] = '4000';
        $config['max_width'] = '4000';
        $config['max_height'] = '4000';
        $config['file_name'] = $id.'_'.$now.'.jpg';
        
        //we make this variable for the make_thumb function
        $img = $id.'_'.$now.'.jpg';
        $this->load->library('upload', $config);

        if ( ! $this->upload->do_upload()){
            redirect('image?error');
        }else{
            $this->make_thumb($img);
            $this->make_medium($img);
            //load up the proper data
            $this->load->model('modelimg');
            $this->modelimg->upload_img($img, $collection);

            redirect('image?success');
        }
    }

/* Collections
***************************************************************/

    public function get_collections(){
        $this->load->model('modelimg');
        $data = $this->modelimg->get_collections();
        
        if($data){
            foreach ($data as $collection):
                echo '<option value="'.$collection->collection_id.'">'.$collection->collection_name.'</option>';
            endforeach;
        }else{
            echo'';
        }
    }

    public function new_collection(){
        $this->load->model('modelimg');
        $data = $this->modelimg->new_collection();
        
        if($data){
            return true;
        }else{
            return false;
        }
    }

    public function delete_collection(){
        $this->load->model('modelimg');
        $data = $this->modelimg->delete_collection();
        
        if($data){
            echo 'true';
        }else{
            echo 'false';
        }
    }

/* Favorite Image
*************************************/
    public function favorite_img(){
        if($this->session->userdata('logged_in')){ 
            $id = $_GET['id'];
            $blog_id = $_GET['blog_id'];

            $this->load->model('modelimg');
            $fav = $this->modelimg->favorite_img_set($id, $blog_id);
            
            if($fav){
                redirect('images/add?success');
            }
        }else{
            redirect('picture/error');
        }
    }

/* Delete Images
***************************************************************/
    public function delete_img() {
        if($this->session->userdata('logged_in')){ 
            $id = $_GET['id'];
            $plugin = $_GET['plugin'];
            
            $this->load->model('modelimg');
            //get the location so we can drop the files
            $img = $this->modelimg->find_img($id);

            $url = strlen(base_url());

            foreach($img as $pic){
                unlink(substr($pic->img_medium_location, $url));
                unlink(substr($pic->img_thumb_location, $url));
                unlink(substr($pic->img_location, $url));
            }
            
            $query = $this->modelimg->delete_img($id);
            
            if($query){
                return true;
            }
        }else{
            redirect('picture/error');
        }
    }

/* Alt and Title Tags
***************************************************************/
    public function set_alt_title(){
        if($this->session->userdata('logged_in')){ 
            $id = $_POST['pic_id'];
            $alt = $_POST['pic_alt'];
            $title = $_POST['pic_title'];

            $this->load->model('modelimg');
            $qry = $this->modelimg->set_alt_title($id, $alt, $title);
            
            if(!$qry){
                return false;
            }
        }else{
            redirect('picture/error');
        }
    }

    public function get_alt_title(){
        if($this->session->userdata('logged_in')){ 
            $id = $_GET['pic_id'];

            $this->load->model('modelimg');
            $qry = $this->modelimg->get_alt_title($id);
            
            if($qry){
                echo '{ "alt_tag": "'.$qry[0]->img_alt_tag.'", "title_tag": "'.$qry[0]->img_title_tag.'" }';
            }
        }else{
            // redirect('picture/error');
        }
    }

/* Update Collection
***************************************************************/
    
    public function change_collection(){
        $this->load->model('modelimg');
        $data = $this->modelimg->update_collection();
        
            redirect('image');
    }
}

/* End of file pictures.php */
/* Location: ./application/controllers/ */