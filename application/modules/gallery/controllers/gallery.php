<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
     
class gallery extends MX_Controller {

    function __construct()
    {
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

/* low level functions
***************************************************************/

/* Generate a thumbnail img
*************************************/
    function make_thumb($img)
    {
        $img_root = str_replace(site_url().'uploads/img/thumb/', "", $img);
        $this->load->library('image_lib');

        $config['image_library'] = 'gd2';
        $config['source_image'] = './uploads/img/full/'.$img_root;
        $config['new_image'] = './uploads/img/thumb/'.$img_root;
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
        $img_root = str_replace(site_url().'uploads/img/thumb/', "", $img);
        $this->load->library('image_lib');

        $config['image_library'] = 'gd2';
        $config['source_image'] = './uploads/img/full/'.$img_root;
        $config['new_image'] = './uploads/img/medium/'.$img_root;
        $config['thumb_marker'] = TRUE;
        $config['maintain_ratio'] = TRUE;
        $config['width'] = 800;
        $config['height'] = 600;

        $this->image_lib->initialize($config);

        $this->image_lib->resize();
        $this->image_lib->clear();
    }

/* Main Blog functions
***************************************************************/

    public function error() 
    {
        $data['root'] = base_url();
        $data['pageRoot'] = base_url().'index.php';
        $data['pagetitle'] = 'Error';

        $this->load->view('common/header', $data);
        $this->load->view('gallery/extras', $data);
        $this->load->view('gallery/gallery_menu');
        $this->load->view('gallery/error', $data);
        $this->load->view('common/footer', $data);
    }

    public function index() 
    {
        redirect("gallery/view");
    }

    public function add() 
    {
        $data['root'] = base_url();
        $data['pageRoot'] = base_url().'index.php';
        $data['pagetitle'] = 'Gallery';

        $this->load->view('common/header', $data);
        $this->load->view('gallery/extras', $data);
        $this->load->view('gallery/gallery_menu');
        $this->load->view('gallery/add', $data);
        $this->load->view('common/footer', $data);
    }

    public function editor($id) 
    {   
        $data['id'] = decrypt($id);

        $this->load->model('model_gallery');
        $products = $this->model_gallery->get_this_entry(decrypt($id));
        $data['m'] = $products[0];

        $data['gallery'] = $this->model_gallery->get_this_products_gallery(decrypt($id));

        $data['root'] = base_url();
        $data['pageRoot'] = base_url().'index.php';
        $data['pagetitle'] = 'Gallery : Editor';
        
        $this->load->view('common/header', $data);
        $this->load->view('gallery/extras', $data);
        $this->load->view('gallery/gallery_menu');
        $this->load->view('gallery/editor', $data);
        $this->load->view('common/footer', $data);
    }

    public function view() 
    {
        $this->load->model('model_gallery');
        $this->load->library('pagination'); 
        
        $config['base_url'] = site_url('gallery/view');
        $config['total_rows'] = $this->model_gallery->get_product_tally();
        $config['per_page'] = 10;
        $config['num_links'] = 10;
        $config['uri_segment'] = 2;
        $config['full_tag_open'] = '<div id="pagination">';
        $config['full_tag_close'] = '</div>';

        $this->cur_page = $this->uri->segment(2);
        $this->pagination->initialize($config);

        $data['products'] = $this->model_gallery->get_selected_entries($this->uri->segment(2), $config['per_page']);
        
        $data['root'] = base_url();
        $data['pageRoot'] = base_url().'index.php';
        $data['pagetitle'] = 'Gallery : View';
        
        $this->load->view('common/header', $data);
        $this->load->view('gallery/extras', $data);
        $this->load->view('gallery/gallery_menu');
        $this->load->view('gallery/view', $data);
        $this->load->view('common/footer', $data);
    }

    function search()
    {
        $name = $this->input->post('search');
        $this->load->model('model_gallery');
        $qry = $this->model_gallery->search_gallery($name);

        if($qry){
            $data['results'] = $qry;
        }else{
            $data['results'] = 'error';
        }

        $data['root'] = base_url();
        $data['pageRoot'] = base_url().'index.php';
        $data['pagetitle'] = 'Gallery : Search';

        $this->load->view('common/header', $data);
        $this->load->view('gallery/extras', $data);
        $this->load->view('gallery/gallery_menu');
        $this->load->view('gallery/search', $data);
        $this->load->view('common/footer', $data);
    }

//  Redirects
// **************************************************************

    public function display_entry($id) 
    {
        $this->load->model('model_gallery');
        $qry = $this->model_gallery->display_entry(decrypt($id));
        if( $qry ){
            redirect('gallery/view');
        }
    }

    public function archive_entry($id) 
    {
        $this->load->model('model_gallery');
        $qry = $this->model_gallery->archive_entry(decrypt($id));
        if( $qry ){
            redirect('gallery/view');
        }
    }

    public function display_this_entry($id) 
    {
        $this->load->model('model_gallery');
        $qry = $this->model_gallery->display_entry(decrypt($id));
        if( $qry ){
            redirect('gallery/editor/'.$id);
        }
    }

    public function archive_this_entry($id) 
    {
        $this->load->model('model_gallery');
        $qry = $this->model_gallery->archive_entry(decrypt($id));
        if( $qry ){
            redirect('gallery/editor/'.$id);
        }
    }

    public function delete_entry($id) 
    {
        $this->load->model('model_gallery');
     

        $this->load->model('model_gallery');
        $manual = $this->model_gallery->get_this_products_gallery(decrypt($id));

        foreach ($manual as $m) {
            $file = substr($m->manual_file_name, (strpos($m->manual_file_name, '/file/')+6), strlen($m->manual_file_name));

            unlink('./uploads/file/'.$file);

            $qry = $this->model_gallery->delete_manual($m->manual_file_id);
        }

        $qry = $this->model_gallery->delete_entry(decrypt($id));

        if( $qry ){
            redirect('gallery/view');
        }
    }

/* Add Entry
***************************************************************/

    public function add_entry() 
    {
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
        
        $img = site_url().'uploads/img/thumb/'.$id.'_'.$now.'.jpg';

        $this->load->library('upload', $config);

        if ( ! $this->upload->do_upload() ){
            $img = site_url().'uploads/img/thumb/default_eq.jpg';
        }else{
            $this->make_thumb($img);
            $this->make_medium($img);
        }

        $firstElement = true;
        $i = 0;
        $id = 'file';
        $now = time();
        $fileCollection = array();
        $fileNameCollection = array();

        foreach ($_FILES as $file) {
            if($firstElement) {
                $firstElement = false;
            }else{
                if( $file["error"] == 0 && $file["type"] == "image/jpg" ||
                    $file["error"] == 0 && $file["type"] == "image/jpeg" ||
                    $file["error"] == 0 && $file["type"] == "image/gif" ||
                    $file["error"] == 0 && $file["type"] == "image/png" ||
                    $file["error"] == 0 && $file["type"] == "image/JPG" ||
                    $file["error"] == 0 && $file["type"] == "image/JPEG" ||
                    $file["error"] == 0 && $file["type"] == "image/GIF" ||
                    $file["error"] == 0 && $file["type"] == "image/PNG"
                ){
                    move_uploaded_file($file["tmp_name"], "./uploads/img/full/" . $id."-".$now."-".$i.".pdf");
                    array_push($fileCollection, site_url()."uploads/img/thumb/" . $id."-".$now."-".$i.".pdf");
                    array_push($fileNameCollection, $_POST['file_name_'.$i]);
                    $i++;
                }
            }
        }

        $this->load->model('model_gallery');
        $qry = $this->model_gallery->add_entry($img, $fileCollection, $fileNameCollection);
        
        if(!$qry["success"]){
            $this->session->set_flashdata('error', 'failed to add entry');
            redirect("gallery/add");
        }else{
            redirect("gallery/editor/".encrypt($qry['id']));
        }
    }

/* Edit Entry
***************************************************************/

    public function update_entry($item_id) 
    {
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
        
        $img = site_url().'uploads/img/thumb/'.$id.'_'.$now.'.jpg';

        $this->load->library('upload', $config);

        if ( ! $this->upload->do_upload() ) {
            $this->load->model('model_gallery');
            $entry = $this->model_gallery->get_this_entry($item_id);
            
            foreach($entry as $img): endforeach;
            
            $img = $img->gallery_img;

            $firstElement = true;
            $i = 0;
            $id = 'file';
            $now = time();
            $fileCollection = array();
            $fileNameCollection = array();

            foreach ($_FILES as $file) {
                if($firstElement) {
                    $firstElement = false;
                }else{
                    if($file["error"] == 0 && $file["type"] == "application/pdf"){
                        move_uploaded_file($file["tmp_name"], "./uploads/file/" . $id."-".$now."-".$i.".pdf");
                        array_push($fileCollection, site_url()."uploads/file/" . $id."-".$now."-".$i.".pdf");
                        array_push($fileNameCollection, $_POST['file_name_'.$i]);
                        $i++;
                    }
                }
            }

            $this->load->model('model_gallery');
            $qry = $this->model_gallery->edit_entry($item_id, $img, $fileCollection, $fileNameCollection);
            
            $this->session->set_flashdata('success', 'Successfully updated');
            redirect("gallery/editor/".encrypt($item_id));
        }
        else
        {
            $this->make_thumb($img);
            $this->make_medium($img);

            /* load the new files
            ***************************************************************/

            $firstElement = true;
            $i = 0;
            $id = 'file';
            $now = time();
            $fileCollection = array();

            foreach ($_FILES as $file) {
                if($firstElement) {
                    $firstElement = false;
                }else{
                    if($file["error"] == 0 && $file["type"] == "application/pdf"){
                        move_uploaded_file($file["tmp_name"], "./uploads/file/" . $id."-".$now."-".$i.".pdf");
                        array_push($fileCollection, site_url()."uploads/file/" . $id."-".$now."-".$i.".pdf");
                        $i++;
                    }
                }
            }

            /* Clean out the old
            ***************************************************************/

            $this->load->model('model_gallery');
            $entry = $this->model_gallery->get_this_entry($item_id);

            foreach($entry as $m): endforeach;

            $oldimg = $m->gallery_img;

            if($oldimg && $oldimg != site_url().'uploads/img/thumb/default_eq.jpg'){
                $x_img = str_replace(site_url().'uploads/img/thumb/', '', $oldimg);

                unlink('./uploads/img/full/'.$x_img);
                unlink('./uploads/img/medium/'.$x_img);
                unlink('./uploads/img/thumb/'.$x_img);
            }

            $this->load->model('model_gallery');
            $qry = $this->model_gallery->edit_entry($item_id, $img, $fileCollection);
            
            if($qry){
                $this->session->set_flashdata('success', 'Update was successful');
                redirect("gallery/editor/".encrypt($item_id));
            }else{
                $this->session->set_flashdata('error', 'unable to update');
                redirect("gallery/editor/".encrypt($item_id));
            }
        }
    }

    /* Delete Manual
    *************************************/

    public function delete_manual($id, $item_id)
    {
        $this->load->model('model_gallery');
        $m = $this->model_gallery->get_this_manual(decrypt($id));

        $file = substr($m[0]->manual_file_name, (strpos($m[0]->manual_file_name, '/file/')+6), strlen($m[0]->manual_file_name));

        unlink('./uploads/file/'.$file);

        $qry = $this->model_gallery->delete_manual(decrypt($id));
        
        if($qry){
            redirect("gallery/editor/".encrypt($item_id));
        }
    }

}

/* End of file gallery.php */
/* Location: ./application/modules/gallery/controllers/ */