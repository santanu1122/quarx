<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// Author: Matt Lantz
     
class pictures extends CI_Controller {

/* Main Image Upload Visuals
***************************************************************/
    
    public function index() {
        if($this->session->userdata('logged_in')){          
            $type = $_GET['type'];
            $plugin = $_GET['plugin'];
            $id = $_GET['galid'];
            
            if(isset($_GET['success'])){
                if($type === 'embeded'){
                    redirect('pictures/add/'.$plugin.'?galid='.$id.'&type='.$type.'&success');
                }
            }

            if(isset($_GET['error'])){
                if($type === 'embeded'){
                    redirect('pictures/add/'.$plugin.'?galid='.$id.'&type='.$type.'&error');
                }
            }

            //configured the data to be transported to the view
            $data['root'] = base_url();
            $data['pageRoot'] = base_url().'index.php';
            $data['type'] = $type;
            $data['plugin'] = $plugin;

            //load the view elements
            $this->load->view('core/pictures/main', $data);
        }else{
            redirect('picture/error');
        }
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

    public function add($plugin) {
        if($this->session->userdata('logged_in')){ 
            //configured the data to be transported to the view
            $data['root'] = base_url();
            $data['pageRoot'] = base_url().'index.php';

            if(isset($_GET['type'])){
                $data['type'] = $_GET['type'];
            }

            //for those special ones like gallery and products
            if(isset($_GET['galid'])){
                $data['plugin'] = $plugin;
                $data['galdId'] = $_GET['galid'];
            }else{
                $data['plugin'] = $plugin;
            }
            
            //load the view elements
            $this->load->view('core/pictures/add', $data);
        }else{
            redirect('picture/error');
        }
    }
    
    public function image_collection($plugin){      
        if($this->session->userdata('logged_in')){ 
            //get the images that are all alone!
            $this->load->model('modelimg');
            $galId = $_GET['galid'];
            $data['image'] = $this->modelimg->get_img_collection($plugin, $galId);

            $data['plugin'] = $plugin;
            $data['type'] = $_GET['type'];
            
            //configured the data to be transported to the view
            $data['root'] = base_url();
            $data['pageRoot'] = base_url().'index.php';
            
            //load the view elements
            $this->load->view('core/pictures/img_feed', $data);
        }else{
            redirect('picture/error');
        }
    }

    public function image_feed($plugin){      
        if($this->session->userdata('logged_in')){ 
            //get the images that are all alone!
            $this->load->model('modelimg');
            $data['image'] = $this->modelimg->get_all_img($plugin);

            $data['plugin'] = $plugin;
            
            //configured the data to be transported to the view
            $data['root'] = base_url();
            $data['pageRoot'] = base_url().'index.php';
            
            //load the view elements
            $this->load->view('core/pictures/img_feed', $data);
        }else{
            redirect('picture/error');
        }
    }

/* Image Upload Processes
***************************************************************/
    
/* Generate a thumbnail img
*************************************/
    function make_thumb($img){
        if($this->session->userdata('logged_in')){ 
            //set the configuration to make a new file
            $config['image_library'] = 'gd2';
            $config['source_image'] = './uploads/img/full/'.$img;
            $config['new_image'] = './uploads/img/thumb/'.$img;
            $config['thumb_marker'] = TRUE;
            $config['maintain_ratio'] = TRUE;
            $config['width'] = 250;
            $config['height'] = 188;
            //load the library tool
            $this->load->library('image_lib', $config);
            //run the function
            $this->image_lib->resize();
        }else{
            redirect('picture/error');
        }
    }
    
/* Add the image
*************************************/
    public function add_image($plugin){
        if($this->session->userdata('logged_in')){ 
            //We will need this model
            $this->load->model('modelimg');
            $galId = $_POST['galid'];
            $type = $_POST['type'];
            
            //load the form helper to help with the image upload
            $this->load->helper(array('form', 'url'));
            
            //set the parameters of the files new name
            $id = 'img';
            $now = time();
            
            //setting the configuration for the file uploads
            $config['upload_path'] = './uploads/img/full/';
            $config['allowed_types'] = 'gif|jpg|jpeg|png|GIF|JPG|JPEG|PNG';
            $config['max_size'] = '4000';
            $config['max_width'] = '1300';
            $config['max_height'] = '1300';
            $config['file_name'] = $id.'_'.$now.'.jpg';
            
            //we make this variable for the make_thumb function
            $img = $id.'_'.$now.'.jpg';
            $this->load->library('upload', $config);

            if ( ! $this->upload->do_upload()){
                if($type == 'embeded'){
                    redirect('pictures?type=embeded&plugin='.$plugin.'&galid='.$galId.'&error');
                }else{
                    redirect('pictures?type=slider&plugin='.$plugin.'&error');
                }
            }else{
                //since it worked we will want a thumbnail img
                $this->make_thumb($img);
            
                //load up the proper data
                $this->load->model('modelimg');
                $rand = $this->modelimg->upload_img($img, $type, $plugin, $galId);
                
                //head back to where we came from
                if($type == 'embeded'){
                    redirect('pictures?type=embeded&plugin='.$plugin.'&galid='.$galId.'&success');
                }else{
                    redirect('pictures?type=slider&plugin='.$plugin.'&success');
                }
            }
        }else{
            redirect('picture/error');
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

}

/* End of file pictures.php */
/* Location: ./application/controllers/ */