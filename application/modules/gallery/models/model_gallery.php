<?php

/*
    Filename:   modelgallery.php
    Location:   /application/models/
*/

class model_gallery extends CI_Model {

    function __construct() {
        parent::__construct();
    }
    
/* Add Entry
***************************************************************/

    function add_entry() {
        if($this->input->post('gallery_name') > '' && $this->input->post('gallery_entry') > '' && $this->input->post('gallery_cat') > ''){
            $title = strtolower($_POST['gallery_name']);
            $url_title = str_replace(" ", "-", $title);
            $url_title = str_replace("'", "", $url_title);
            $url_title = str_replace("\"", "", $url_title);
            $url_title = str_replace("?", "", $url_title);
            $url_title = str_replace("!", "", $url_title);
            $url_title = str_replace(":", "", $url_title);
            $url_title = str_replace("&", "", $url_title);
            $url_title = str_replace("%", "", $url_title);
            $url_title = str_replace("*", "", $url_title);
            $url_title = str_replace("#", "", $url_title);
            $url_title = str_replace("@", "", $url_title);

            $sql = "INSERT INTO 
                        gallery(gallery_title, gallery_url_title, gallery_entry, gallery_cat, gallery_img_library, gallery_date, gallery_hide, author_id) 
                    VALUES( '".mysql_real_escape_string($this->input->post('gallery_name'))."', 
                            '".mysql_real_escape_string($url_title)."', 
                            '".mysql_real_escape_string($this->input->post('gallery_entry'))."',
                            '".mysql_real_escape_string($this->input->post('gallery_cat'))."',
                            '".mysql_real_escape_string($this->input->post('gallery_img_library'))."',
                            '".mysql_real_escape_string($this->input->post('gallery_date'))."',
                            '0',
                            '".mysql_real_escape_string($this->session->userdata('user_id'))."'
                            )";

            $qry = mysql_query($sql);
            $id = mysql_insert_id();
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
        $title = strtolower($_POST['gallery_name']);
        $title = html_entity_decode($title);
        $url_title = str_replace(" ", "-", $title);
        $url_title = str_replace("'", "", $url_title);
        $url_title = str_replace("\"", "", $url_title);
        $url_title = str_replace("?", "", $url_title);
        $url_title = str_replace("!", "", $url_title);
        $url_title = str_replace(":", "", $url_title);
        $url_title = str_replace("&", "", $url_title);
        $url_title = str_replace("%", "", $url_title);
        $url_title = str_replace("*", "", $url_title);
        $url_title = str_replace("#", "", $url_title);
        $url_title = str_replace("@", "", $url_title);

        $sql = "UPDATE 
                    gallery 
                SET 
                    `gallery_title` = '".mysql_real_escape_string($_POST['gallery_name'])."',
                    `gallery_url_title` = '".mysql_real_escape_string($url_title)."',
                    `gallery_entry` = '".mysql_real_escape_string($_POST['gallery_entry'])."',
                    `gallery_img_library` = '".mysql_real_escape_string($_POST['gallery_img_library'])."',
                    `gallery_date` = '".mysql_real_escape_string($_POST['gallery_date'])."',
                    `gallery_cat` = '".mysql_real_escape_string($_POST['gallery_cat'])."'
                WHERE 
                    gallery_id = ".$_POST['gallery_id'];
                    
        $qry = mysql_query($sql);
        
        if($qry){
            return $_POST['gallery_id'];
        }
    }
    
/* Gets
***************************************************************/

    function get_all_entries() {
        $qry = $this->db->query('SELECT * FROM `gallery` ORDER BY gallery_date DESC');        
        if($qry){
            return $qry->result();
        }
    }

    function get_this_entry($id) {
        $qry = $this->db->query('SELECT * FROM `gallery` WHERE gallery_id = '.$id);        
        if($qry){
            return $qry->result();
        }
    }

    function count_all_entries() {
        $qry = $this->db->query('SELECT * FROM `gallery`');        
        if($qry){
            return $qry->num_row();
        }
    }

/* Quick Edits
***************************************************************/
    
    function display_entry($id) {
        $qry = $this->db->query('UPDATE `gallery` SET gallery_hide = 0 WHERE gallery_id = '.$id);        
        if($qry){
            return true;
        }
    }

    function archive_entry($id) {
        $qry = $this->db->query('UPDATE `gallery` SET gallery_hide = 1 WHERE gallery_id = '.$id);        
        if($qry){
            return true;
        }
    }

    function delete_entry($id) {
        $qry = $this->db->query('DELETE FROM `gallery` WHERE gallery_id = '.$id);        
        if($qry){
            return true;
        }
    }

/* Search Actions
***************************************************************/

    //Simple search name function
    function search_gallery($term){
        $qry = $this->db->query('SELECT * FROM `gallery` WHERE gallery_title LIKE "%'.$term.'%" 
                                || gallery_entry LIKE "%'.$term.'%" 
                                ORDER BY gallery_id ASC');       
        if($qry){
            return $qry->result();
        }
    }

}
// End of File
?>