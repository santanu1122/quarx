<?php

/*
    Filename:   modelblog.php
    Location:   /application/models/
*/

class model_blog extends CI_Model {

    function __construct() {
        parent::__construct();
    }
    
/* Add Entry
***************************************************************/

    function add_entry() {
        if($this->input->post('blog_name') > '' && $this->input->post('blog_entry') > '' && $this->input->post('blog_cat') > ''){
            $url_title = strip_special_chars(strtolower($_POST['blog_name']));

            $sql = "INSERT INTO 
                        blog(blog_title, blog_url_title, blog_entry, blog_cat, blog_img_library, blog_date, blog_hide, author_id) 
                    VALUES( '".mysql_real_escape_string($this->input->post('blog_name'))."', 
                            '".mysql_real_escape_string($url_title)."', 
                            '".mysql_real_escape_string($this->input->post('blog_entry'))."',
                            '".mysql_real_escape_string($this->input->post('blog_cat'))."',
                            '".mysql_real_escape_string($this->input->post('blog_img_library'))."',
                            '".mysql_real_escape_string($this->input->post('blog_date'))."',
                            '0',
                            '".mysql_real_escape_string($this->session->userdata('user_id'))."'
                            )";

            $qry = $this->db->query($sql);
            $id = $this->db->insert_id();
            if($qry){
                return $id;
            }else{
                return false;
            }
        }  
    }

/* Edit Entry
***************************************************************/

    function edit_entry() {  
        $title = strtolower($this->input->post('blog_name'));
        $url_title = strip_special_chars(html_entity_decode($title));

        $sql = "UPDATE 
                    blog 
                SET 
                    `blog_title` = '".$this->input->post('blog_name')."',
                    `blog_url_title` = '".$url_title."',
                    `blog_entry` = '".$this->input->post('blog_entry')."',
                    `blog_img_library` = '".$this->input->post('blog_img_library')."',
                    `blog_date` = '".$this->input->post('blog_date')."',
                    `blog_cat` = '".$this->input->post('blog_cat')."'
                WHERE 
                    blog_id = ".$this->input->post('blog_id');
                    
        $qry = $this->db->query($sql);
        
        if($qry){
            return $this->input->post('blog_id');
        }
    }
    
/* Gets
***************************************************************/

    function get_all_entries() {
        $qry = $this->db->query('SELECT * FROM `blog` ORDER BY blog_date DESC');        
        if($qry){
            return $qry->result();
        }
    }

    function get_this_entry($id) {
        $qry = $this->db->query('SELECT * FROM `blog` WHERE blog_id = '.$id);        
        if($qry){
            return $qry->result();
        }
    }

    function count_all_entries() {
        $qry = $this->db->query('SELECT * FROM `blog`');        
        if($qry){
            return $qry->num_row();
        }
    }

/* Quick Edits
***************************************************************/
    
    function display_entry($id) {
        $qry = $this->db->query('UPDATE `blog` SET blog_hide = 0 WHERE blog_id = '.$id);        
        if($qry){
            return true;
        }
    }

    function archive_entry($id) {
        $qry = $this->db->query('UPDATE `blog` SET blog_hide = 1 WHERE blog_id = '.$id);        
        if($qry){
            return true;
        }
    }

    function delete_entry($id) {
        $qry = $this->db->query('DELETE FROM `blog` WHERE blog_id = '.$id);        
        if($qry){
            return true;
        }
    }

/* Search Actions
***************************************************************/

    //Simple search name function
    function search_blog($term){
        $qry = $this->db->query('SELECT * FROM `blog` WHERE blog_title LIKE "%'.$term.'%" 
                                || blog_entry LIKE "%'.$term.'%" 
                                ORDER BY blog_id ASC');       
        if($qry){
            return $qry->result();
        }
    }

}
// End of File
?>