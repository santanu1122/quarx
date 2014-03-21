<?php

/*
    Filename:   model_blog_categories.php
    Location:   /models
*/

class model_blog_categories extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }

/* Gets
***************************************************************/

    function get_all_cats() {
        $qry = $this->db->query('SELECT * FROM `blog_categories`');
        if($qry){
            return $qry->result();
        }
    }

    function get_a_cat($id) {
        $qry = $this->db->query('SELECT * FROM `blog_categories` WHERE cat_id = '.$id);
        if($qry){
            return $qry->result();
        }
    }

    function check_title($name, $type) {
        $qry = $this->db->query('SELECT * FROM `blog_categories` WHERE cat_title = "'.$name.'"');
        if($qry->num_rows() > 0){
            echo 'fail';
        }
    }

/* Add Categories
***************************************************************/

    public function add_category($cat_name, $cat_parent)
    {
        $title = strtolower($this->input->post('cat_name'));
        $title = html_entity_decode($title);
        $url_title = $this->tools->strip_special_chars($title);

        $data = array(
            "cat_title" => $cat_name,
            "cat_url_title" => $url_title,
            "cat_parent" => $cat_parent
        );

        $qry = $this->db->insert("blog_categories", $data);

        return $qry;
    }

/* Delete Categories
***************************************************************/

    function delete_category($id) {
        $qry = $this->db->query("SELECT * FROM blog WHERE blog_cat = ".$id);
        if($qry->num_rows() > 0){
            return false;
        }else{
            $cat_qry = $this->db->query("SELECT * FROM blog_categories WHERE cat_parent = ".$id);
            if($cat_qry->num_rows() > 0){
                return false;
            }else{
                $del_sql = "DELETE FROM `blog_categories` WHERE cat_id = ".$id;
                $del_qry = $this->db->query($del_sql);
                return true;
            }
        }
    }

}
// End of File
?>