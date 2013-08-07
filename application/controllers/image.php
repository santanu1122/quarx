<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Quarx
 *
 * A modular CMS built on CodeIgniter
 *
 * @package     Quarx
 * @author      Matt Lantz
 * @copyright   Copyright (c) 2013 Matt Lantz
 * @license     http://ottacon.co/quarx/license
 * @link        http://quarx.ottacon.co
 * @since       Version 1.0
 * 
 */
     
class Image extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        
        if(!$this->session->userdata('logged_in'))
        {
            print_r( 'Denied' );
            exit();
        }

        if($this->session->userdata('permission') > 1)
        {
            $access = check_master_access();
            if($access)
            {
                redirect('login/insufficient');
            }
        }

        $this->lang->load(config_item('language_abbr'), config_item('language'));
    }

/* Main Image Upload Visuals
***************************************************************/
    
    public function index() 
    {        
        $data['root'] = base_url();
        $data['pageRoot'] = base_url().'index.php';
        $data['libraryHome'] = true;
        
        $data['state'] = "";
        $data['message'] = "";

        if($this->session->flashdata('error')){
            $data['state'] = "quarx-error-box";
            $data['message'] = $this->session->flashdata('error');
        }

        if($this->session->flashdata('success')){
            $data['state'] = "quarx-success-box";
            $data['message'] = $this->session->flashdata('success');
        }

        $this->load->view('core/image/common/header', $data);
        $this->load->view('core/image/main', $data);
        $this->load->view('core/image/common/footer', $data);
    }

/* Library
***************************************************************/
    public function library()
    {
        $data['root'] = base_url();
        $data['pageRoot'] = base_url().'index.php';
        $data['pagetitle'] = 'Image Library';

        $this->load->view('common/header', $data);
        $this->load->view('core/image/frames/library');
        $this->load->view('common/footer', $data);
    }

    public function error() 
    {
        if($this->session->userdata('logged_in'))
        {          
            $type = $_GET['type'];
            
            $data['root'] = base_url();
            $data['pageRoot'] = base_url().'index.php';
            $data['type'] = $type;

            $this->load->view('core/pictures/error', $data);
        }
        else
        {
            redirect('image/error');
        }
    }

    public function add() 
    {
        $data['root'] = base_url();
        $data['pageRoot'] = base_url().'index.php';

        $data['state'] = "";
        $data['message'] = "";

        if($this->session->flashdata('error')){
            $data['state'] = "quarx-error-box";
            $data['message'] = $this->session->flashdata('error');
        }

        if($this->session->flashdata('success')){
            $data['state'] = "quarx-success-box";
            $data['message'] = $this->session->flashdata('success');
        }
        
        $this->load->view('core/image/common/header', $data);
        $this->load->view('core/image/add', $data);
    }

    public function collections($collection = null)
    {
        $this->load->model('modelimg');
        $data['image'] = $this->modelimg->get_all_img($collection);

        if($collection != null)
        {
            $data['img_collection_name'] = $this->modelimg->get_collection_name($collection);
            $data['img_collection_id'] = $collection;
        }

        $data['root'] = base_url();
        $data['pageRoot'] = base_url().'index.php';

        $this->load->view('core/image/common/header', $data);
        $this->load->view('core/image/img_feed', $data);
    }

    public function manager()
    {        
        $this->load->model('modelimg');

        $data['collection'] = $this->modelimg->get_collections();
        $data['root'] = base_url();
        $data['pageRoot'] = base_url().'index.php';
        $data['state'] = "";
        $data['message'] = "";

        if($this->session->flashdata('error')){
            $data['state'] = "quarx-error-box";
            $data['message'] = $this->session->flashdata('error');
        }

        if($this->session->flashdata('success')){
            $data['state'] = "quarx-success-box";
            $data['message'] = $this->session->flashdata('success');
        }

        $this->load->view('core/image/common/header', $data);
        $this->load->view('core/image/manager', $data);
    }

    public function change($id) 
    {
        $data['imageId'] = $id;
        $data['root'] = base_url();
        $data['pageRoot'] = base_url().'index.php';

        $data['state'] = "";
        $data['message'] = "";

        if($this->session->flashdata('error')){
            $data['state'] = "quarx-error-box";
            $data['message'] = $this->session->flashdata('error');
        }

        if($this->session->flashdata('success')){
            $data['state'] = "quarx-success-box";
            $data['message'] = $this->session->flashdata('success');
        }

        $this->load->view('core/image/common/header', $data);
        $this->load->view('core/image/change', $data);
    }

/* Image Upload Processes
***************************************************************/
    
/* Generate a thumbnail img
*************************************/
    function make_thumb($img)
    {
        $this->load->library('image_lib');

        $config['image_library'] = 'gd2';
        $config['source_image'] = './uploads/img/full/'.$img;
        $config['new_image'] = './uploads/img/thumb/'.$img;
        $config['thumb_marker'] = TRUE;
        $config['maintain_ratio'] = TRUE;
        $config['width'] = 250;
        $config['height'] = 188;

        $this->image_lib->initialize($config);
        $this->image_lib->resize();
        $this->image_lib->clear();
    }

/* Generate a medium img
*************************************/
    function make_medium($img)
    {
        $this->load->library('image_lib');

        $config['image_library'] = 'gd2';
        $config['source_image'] = './uploads/img/full/'.$img;
        $config['new_image'] = './uploads/img/medium/'.$img;
        $config['thumb_marker'] = TRUE;
        $config['maintain_ratio'] = TRUE;
        $config['width'] = 800;
        $config['height'] = 600;

        $this->image_lib->initialize($config);
        $this->image_lib->resize();
        $this->image_lib->clear();
    }
    
/* Add the image
*************************************/
    public function add_image()
    {
        $collection = $this->input->post('collection');

        $this->load->model('modelimg');
        $this->load->helper(array('form', 'url'));
        
        $id = 'img';
        $now = time();

        ini_set('memory_limit','128M');
        
        $config['upload_path'] = './uploads/img/full/';
        $config['allowed_types'] = 'gif|jpg|jpeg|png|GIF|JPG|JPEG|PNG';
        $config['max_size'] = '4000';
        $config['max_width'] = '4000';
        $config['max_height'] = '4000';
        $config['file_name'] = $id.'_'.$now.'.jpg';
        
        $img = $id.'_'.$now.'.jpg';
        $this->load->library('upload', $config);

        if ( ! $this->upload->do_upload())
        {
            $this->session->set_flashdata('error', 'Could not upload image.');
            redirect('image/add');
        }
        else
        {
            $this->make_thumb($img);
            $this->make_medium($img);

            $this->load->model('modelimg');
            $this->modelimg->upload_img($img, $collection);

            $this->session->set_flashdata('success', 'Image upload was successful.');
            redirect('image');
        }
    }

/* Collections
***************************************************************/

    public function get_collections()
    {
        $this->load->model('modelimg');
        $data = $this->modelimg->get_collections();
        
        if($data)
        {
            foreach ($data as $collection):
                echo '<option value="'.$collection->collection_id.'">'.$collection->collection_name.'</option>';
            endforeach;
        }
    }

    public function new_collection()
    {
        $this->load->model('modelimg');
        $data = $this->modelimg->new_collection();
        
        if($data)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function delete_collection()
    {
        $this->load->model('modelimg');
        $data = $this->modelimg->delete_collection();
        
        if($data)
        {
            $this->session->set_flashdata('success', 'You\'ve successfully removed this image category.');
            echo 'true';
        }
        else
        {
            $this->session->set_flashdata('error', 'Sorry, there was an error, are you sure this collection is empty?');
            echo 'false';
        }
    }

/* Favorite Image
*************************************/
    public function favorite_img()
    {
        if($this->session->userdata('logged_in'))
        { 
            $id = $_GET['id'];
            $blog_id = $_GET['blog_id'];

            $this->load->model('modelimg');
            $fav = $this->modelimg->favorite_img_set($id, $blog_id);
            
            if($fav)
            {
                redirect('images/add?success');
            }
        }
        else
        {
            redirect('image/error');
        }
    }

/* Delete Images
***************************************************************/
    public function delete_img() 
    {
        if($this->session->userdata('logged_in'))
        { 
            $id = $_GET['id'];
            $plugin = $_GET['plugin'];
            
            $this->load->model('modelimg');
            $img = $this->modelimg->find_img($id);

            $url = strlen(base_url());

            foreach($img as $pic)
            {
                unlink(substr($pic->img_medium_location, $url));
                unlink(substr($pic->img_thumb_location, $url));
                unlink(substr($pic->img_location, $url));
            }
            
            $query = $this->modelimg->delete_img($id);
            
            if($query)
            {
                return true;
            }
        }
        else
        {
            redirect('image/error');
        }
    }

/* Alt and Title Tags
***************************************************************/
    public function set_alt_title()
    {
        if($this->session->userdata('logged_in'))
        { 
            $id = $_POST['pic_id'];
            $alt = $_POST['pic_alt'];
            $title = $_POST['pic_title'];

            $this->load->model('modelimg');
            $qry = $this->modelimg->set_alt_title($id, $alt, $title);
            
            if(!$qry)
            {
                return false;
            }
        }
        else
        {
            redirect('image/error');
        }
    }

    public function get_alt_title()
    {
        if($this->session->userdata('logged_in'))
        { 
            $id = $_GET['pic_id'];

            $this->load->model('modelimg');
            $qry = $this->modelimg->get_alt_title($id);
            
            if($qry)
            {
                echo '{ "alt_tag": "'.$qry[0]->img_alt_tag.'", "title_tag": "'.$qry[0]->img_title_tag.'" }';
            }
        }
        else
        {
            redirect('image/error');
        }
    }

/* Update Collection
***************************************************************/
    
    public function change_collection()
    {
        $this->load->model('modelimg');
        $data = $this->modelimg->update_collection();
        
        if($data)
        {
            $this->session->set_flashdata('success', 'Image collection change was successful.');
            redirect('image');
        }
        else
        {
            $this->session->set_flashdata('error', 'Image collection change was not successful.');
            redirect('image/error');
        }
    }
}

/* End of file image.php */
/* Location: ./application/controllers/ */