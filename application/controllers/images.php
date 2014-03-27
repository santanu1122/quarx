<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Quarx
 *
 * A modular CMS application
 *
 * @package     Quarx
 * @author      Matt Lantz
 * @copyright   Copyright (c) 2013 Matt Lantz
 * @license     http://ottacon.co/quarx/license.html
 * @link        http://ottacon.co/quarx
 * @since       Version 1.0
 *
 */

class Images extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        if ( ! $this->session->userdata('logged_in'))
        {
            redirect('error/login');
        }

        $this->lang->load(config_item('language_abbr'), config_item('language'));

        $js = array('views/images/quarx-images.js');
        $this->carabiner->group("quarx-images-js", array('js'=>$js));
    }

    public function index()
    {
        redirect("images/library");
    }

    public function library($collection = null)
    {
        $this->load->model('model_images');

        $js = array(
            array('views/images/quarx-images.js'),
            array('views/images/quarx-images-library.js')
        );
        $this->carabiner->group("quarx-images-js", array('js'=>$js));

        $collection = (is_null($collection) ? null : $this->crypto->decrypt($collection));

        $data['images'] = $this->model_images->get_all_images($collection);

        if( ! is_null($collection))
        {
            $data['img_collection_name'] = $this->model_images->get_collection_name($collection);
        }

        $data['img_collection_id'] = $collection;

        $data['root'] = base_url();
        $data['pageRoot'] = base_url().'index.php';
        $data['pagetitle'] = 'Images Library';

        $this->load->view('common/header', $data);
        $this->load->view('core/images/library');
        $this->load->view('common/footer', $data);
    }

    public function get_collection_images($collection = null)
    {
        $this->load->model('model_images');

        $collection = ($collection == "null" ? null : $collection);

        $data['images'] = $this->model_images->get_all_images($collection);

        $this->load->view("core/images/image_collection", $data);
    }

    public function add()
    {
        $js = array(
            array('views/images/quarx-images.js')
        );
        $this->carabiner->group("quarx-images-js", array('js'=>$js));

        $data['root'] = base_url();
        $data['pageRoot'] = base_url().'index.php';
        $data['pagetitle'] = 'Image Library: Add';

        $this->load->view('common/header', $data);
        $this->load->view('core/images/add', $data);
        $this->load->view('common/footer', $data);
    }

    public function manager()
    {
        $this->load->model('model_images');

        $js = array(
            array('views/images/quarx-images.js')
        );
        $this->carabiner->group("quarx-images-js", array('js'=>$js));

        $data['collection'] = $this->model_images->get_collections();
        $data['root'] = base_url();
        $data['pageRoot'] = base_url().'index.php';
        $data['pagetitle'] = "Collections Manager";

        $this->load->view('common/header', $data);
        $this->load->view('core/images/manager', $data);
        $this->load->view('common/footer', $data);
    }

    public function change($id)
    {
        $js = array(
            array('views/images/quarx-images.js')
        );
        $this->carabiner->group("quarx-images-js", array('js'=>$js));

        $data['imageId'] = $this->crypto->decrypt($id);
        $data['root'] = base_url();
        $data['pageRoot'] = base_url().'index.php';
        $data['pagetitle'] = 'Change Collection';

        $this->load->view('common/header', $data);
        $this->load->view('core/images/change', $data);
        $this->load->view('common/footer', $data);
    }

    public function add_image()
    {
        $collection = $this->input->post('collection');

        $this->load->library('upload');
        $this->load->model('model_images');
        $this->load->helper(array('form', 'url'));

        $file_array = array();
        $n = $i = 0;

        ini_set('memory_limit','128M');

        $fileCount = count($_FILES['images']['name'])-1;

        foreach (range(0, $fileCount) as $f)
        {
            $rand = 'image-'.rand(100000, 999999);

            array_push($file_array, $rand);

            $_FILES[$rand] = array(
                "name" => $_FILES['images']['name'][$n],
                "type" => $_FILES['images']['type'][$n],
                "tmp_name" => $_FILES['images']['tmp_name'][$n],
                "error" => $_FILES['images']['error'][$n],
                "size" => $_FILES['images']['size'][$n]
            );

            $n++;
        }

        unset($_FILES['images']);

        foreach ($_FILES as $file)
        {
            $now = time();
            $ext = substr(strrchr($file['name'], "."), 1);
            $img = $file_array[$i].'-'.$now.'.'.$ext;

            $config['upload_path'] = './uploads/img/full/';
            $config['allowed_types'] = 'gif|jpg|jpeg|png|GIF|JPG|JPEG|PNG';
            $config['max_size'] = '4000';
            $config['max_width'] = '4000';
            $config['max_height'] = '4000';
            $config['file_name'] = $img;

            $this->upload->initialize($config);

            if ( ! $this->upload->do_upload($file_array[$i]))
            {
                $this->session->set_flashdata('message', array("error", $this->upload->display_errors()));
                redirect('images/add');
            }
            else
            {
                $this->image_tools->make_thumb($img);
                $this->image_tools->make_medium($img);
                $this->model_images->upload_img($img, $collection);
            }

            $i++;
        }

        $this->session->set_flashdata('message', array("info", "Image successfully uploaded"));
        redirect('images');
    }

    public function get_collections()
    {
        $this->load->model('model_images');
        $data = $this->model_images->get_collections();

        if ($data)
        {
            foreach ($data as $collection)
            {
                echo '<option class="quarx-collection-options" value="'.$collection->collection_id.'">'.$collection->collection_name.'</option>';
            }
        }
    }

    public function new_collection()
    {
        $this->load->model('model_images');
        return $this->model_images->new_collection();
    }

    public function delete_collection($id)
    {
        $id = $this->crypto->decrypt($id);

        $this->load->model('model_images');
        $data = $this->model_images->delete_collection($id);

        $this->session->set_flashdata('message', array("error", "Image collection could not be deleted, it may have images paired to it still."));
        if ($data) $this->session->set_flashdata('message', array("info", "Image collection successfully deleted"));

        redirect('images/manager');
    }

    public function delete_img($id)
    {
        $this->load->model('model_images');
        $img = $this->model_images->find_img($id);

        $url = strlen(base_url());

        foreach ($img as $pic)
        {
            @unlink(substr($pic->img_medium_location, $url));
            @unlink(substr($pic->img_thumb_location, $url));
            @unlink(substr($pic->img_location, $url));
        }

        $query = $this->model_images->delete_img($id);

        if($query)
        {
            return true;
        }
    }

    public function set_alt_title()
    {
        $this->load->model('model_images');

        $id = str_replace("image-", "", $this->input->post('pic_id'));
        $alt = $this->input->post('pic_alt');
        $title = $this->input->post('pic_title');

        return $this->model_images->set_alt_title($id, $alt, $title);
    }

    public function get_alt_title()
    {
        $this->load->model('model_images');

        $id = str_replace("image-", "", $this->input->get('pic_id'));

        $qry = $this->model_images->get_alt_title($id);

        if ($qry) echo '{ "alt_tag": "'.$qry[0]->img_alt_tag.'", "title_tag": "'.$qry[0]->img_title_tag.'" }';
    }

    public function view_full($id)
    {
        $id = $this->crypto->decrypt($id);
        $this->load->model('model_images');
        $img = $this->model_images->find_img($id);

        $data['image'] = $img[0];
        $data['root'] = base_url();
        $data['pageRoot'] = base_url().'index.php';
        $data['pagetitle'] = 'Image Library: View';

        $this->load->view('common/header', $data);
        $this->load->view('core/images/view_full', $data);
        $this->load->view('common/footer', $data);
    }

    public function change_collection()
    {
        $this->load->model('model_images');

        $id = $this->crypto->decrypt($this->input->post('imageId'));
        $collection = $this->input->post('collections');

        $data = $this->model_images->update_collection($id, $collection);

        $this->session->set_flashdata('message', array("error", "Image collection could not be moved."));
        if ($data) $this->session->set_flashdata('message', array("info", "Image collection successfully moved"));

        redirect('images/library');
    }
}

/* End of file Images.php */
/* Location: ./application/controllers/ */