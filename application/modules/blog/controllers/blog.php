<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class blog extends MX_Controller {

    function __construct()
    {
        parent::__construct();
        if ( ! $this->session->userdata('logged_in')) redirect('error/login');
        if ($this->session->userdata('permission') > 1)
        {
            $access = $this->quarx->get_option("access_type");
            if ($access == "standard access") redirect('login/insufficient');
        }
    }

    public function index()
    {
        redirect("blog/view");
    }

    public function add()
    {
        $this->image_tools->enableImageLibrary();

        $data['root'] = base_url();
        $data['pageRoot'] = base_url().'index.php';
        $data['pagetitle'] = 'Blog';

        $this->load->view('common/header', $data);
        $this->load->view('blog/extras', $data);
        $this->load->view('blog/blog_menu', $blog);
        $this->load->view('blog/add', $data);
        $this->load->view('common/footer', $data);
    }

    public function editor($id)
    {
        $this->image_tools->enableImageLibrary();

        $this->load->library('blog_cat_tools');
        $this->load->model('model_blog');

        $entry = $this->model_blog->get_this_entry($this->crypto->decrypt($id));

        $data['blog'] = $entry[0];
        $data['root'] = base_url();
        $data['pageRoot'] = base_url().'index.php';
        $data['pagetitle'] = 'Blog : Editor';

        $this->load->view('common/header', $data);
        $this->load->view('blog/extras', $data);
        $this->load->view('blog/blog_menu', $blog);
        $this->load->view('blog/editor', $data);
        $this->load->view('common/footer', $data);
    }

    public function view()
    {
        $this->load->model('model_blog');
        $this->load->library('blog_cat_tools');

        $data['entries'] = $this->model_blog->get_all_entries();
        $data['root'] = base_url();
        $data['pageRoot'] = base_url().'index.php';
        $data['pagetitle'] = 'Blog : View';

        $this->load->view('common/header', $data);
        $this->load->view('blog/extras', $data);
        $this->load->view('blog/blog_menu', $blog);
        $this->load->view('blog/view', $data);
        $this->load->view('common/footer', $data);
    }

    public function search()
    {
        $this->load->model('model_blog');
        $this->load->library('blog_cat_tools');

        $term = $this->input->post('search');
        $qry = $this->model_blog->search_blog($term);

        $data['results'] = 'error';

        if ($qry) $data['results'] = $qry;

        $data['root'] = base_url();
        $data['pageRoot'] = base_url().'index.php';
        $data['pagetitle'] = 'Blog : Search';

        $this->load->view('common/header', $data);
        $this->load->view('blog/extras', $data);
        $this->load->view('blog/blog_menu', $blog);
        $this->load->view('blog/search', $data);
        $this->load->view('common/footer', $data);
    }

    public function publish_entry($id)
    {
        $this->load->model('model_blog');
        $qry = $this->model_blog->publish_entry($this->crypto->decrypt($id));

        $this->session->set_flashdata('message', array("Error", "Your entry was not published"));
        if ($qry) $this->session->set_flashdata('message', array("Success", "Your entry is now published"));

        redirect($_SERVER['HTTP_REFERER']);
    }

    public function archive_entry($id)
    {
        $this->load->model('model_blog');
        $qry = $this->model_blog->archive_entry($this->crypto->decrypt($id));

        $this->session->set_flashdata('message', array("Error", "Your entry was not archived"));
        if ($qry) $this->session->set_flashdata('message', array("Success", "Your entry is now archived"));

        redirect($_SERVER['HTTP_REFERER']);
    }

    public function delete_entry($id)
    {
        $this->load->model('model_blog');
        $qry = $this->model_blog->delete_entry($this->crypto->decrypt($id));

        $this->session->set_flashdata('message', array("Error", "Your entry was not published"));
        if ($qry) $this->session->set_flashdata('message', array("Success", "Your entry is now published"));

        redirect('blog/view');
    }

    public function add_entry()
    {
        $this->load->model('model_blog');
        $qry = $this->model_blog->add_entry();

        if ($qry) echo $qry;
        else echo 'duplicate title';
    }

    public function update_entry()
    {
        $this->load->model('model_blog');
        $qry = $this->model_blog->edit_entry();

        if ($qry) echo $qry;
    }

}

/* End of file blog.php */
/* Location: ./application/modules/blog/controllers/ */