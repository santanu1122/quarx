<?php

/*
    Filename:   model_blog_categories.php
    Location:   /models
*/

class model_blog_categories extends CI_Model {

    function __construct() {
        // Call the Model constructor
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
        $qry = $this->db->query('SELECT * FROM `blog_categories`');        
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

    function add_category($cat_name, $cat_parent) { 
        $title = strtolower($this->input->post('cat_name'));
        $title = html_entity_decode($title);
        $url_title = strip_special_chars($title);

        $sql = "INSERT INTO 
                    blog_categories(cat_title, cat_url_title, cat_parent) 
                VALUES( '".mysql_real_escape_string($cat_name)."', 
                        '".mysql_real_escape_string($url_title)."', 
                        '".mysql_real_escape_string($cat_parent)."')";
        $qry = $this->db->query($sql);
        
        if($qry){
            return true;
        }
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