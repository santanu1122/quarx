<?php

/*
    Filename:   modelblog.php
    Location:   /application/models/
*/

class model_blog extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }

    public function add_entry()
    {
        $name = $this->input->post('blog_name') > '';
        $entry = $this->input->post('blog_entry') > '';
        $cat = $this->input->post('blog_cat') > '';

        if ($name && $entry && $cat)
        {
            $url_title = $this->tools->strip_special_chars(strtolower($this->input->post('blog_name')));

            $data = array(
                "blog_title" => $this->input->post('blog_name'),
                "blog_url_title" => $url_title,
                "blog_entry" => $this->input->post('blog_entry'),
                "blog_cat" => $this->input->post('blog_cat'),
                "blog_img_library" => $this->input->post('blog_img_library'),
                "blog_date" => $this->input->post('blog_date'),
                "blog_publish" => 0,
                "author_id" => $this->session->userdata('user_id')
            );

            $qry = $this->db->insert("blog", $data);

            $id = $this->db->insert_id();

            if ($qry) return $id;

            return false;
        }

        return false;
    }

    public function edit_entry()
    {
        $title = strtolower($this->input->post('blog_name'));
        $url_title = $this->tools->strip_special_chars(html_entity_decode($title));

        $data = array(
            "blog_title" => $this->input->post('blog_name'),
            "blog_url_title" => $url_title,
            "blog_entry" => $this->input->post('blog_entry'),
            "blog_cat" => $this->input->post('blog_cat'),
            "blog_img_library" => $this->input->post('blog_img_library'),
            "blog_date" => $this->input->post('blog_date')
        );

        $this->db->where("blog_id", $this->input->post('blog_id'));
        $qry = $this->db->update("blog", $data);

        if ($qry) return $this->input->post('blog_id');

        return false;
    }

    public function get_all_entries()
    {
        $this->db->order_by("blog_date", "DESC");
        return $this->db->get("blog")->result();
    }

    public function get_this_entry($id)
    {
        $this->db->where("blog_id", $id);
        return $this->db->get("blog")->result();
    }

    public function count_all_entries()
    {
        return $this->db->get("blog")->num_rows();
    }

    public function publish_entry($id)
    {
        $data = array(
            "blog_publish" => 1
        );

        $this->db->where("blog_id", $id);
        $qry = $this->db->update("blog", $data);

        return $qry;
    }

    public function archive_entry($id)
    {
        $data = array(
            "blog_publish" => 0
        );

        $this->db->where("blog_id", $id);
        $qry = $this->db->update("blog", $data);

        return $qry;
    }

    public function delete_entry($id)
    {
        $this->db->where("blog_id", $id);
        $this->db->delete("blog");
        return true;
    }

    public function search_blog($term)
    {
        $this->db->like("blog_title", $term);
        $this->db->or_like("blog_entry", $term);
        $this->db->order_by("blog_id", "ASC");

        return $this->db->get("blog")->result();
    }

}
// End of File
?>