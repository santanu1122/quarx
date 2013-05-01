<?php

/*
    Filename:   model_pages.php
    Location:   /application/models/
*/

class model_pages extends CI_Model {

    function __construct() {
        parent::__construct();
    }
    
/* Add Entry
***************************************************************/

    function add_entry() {
        if($this->input->post('page_name') > '' && $this->input->post('page_entry') > '' && $this->input->post('page_parent') > ''){
            $title = strtolower($this->input->post('page_name'));
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
                        pages(page_title, page_url_title, page_entry, page_parent, page_img_library, page_hide, author_id) 
                    VALUES( '".$this->input->post('page_name')."', 
                            '".mysql_real_escape_string($url_title)."', 
                            '".$this->input->post('page_entry')."',
                            '".$this->input->post('page_parent')."',
                            '".$this->input->post('page_img_library')."',
                            '0',
                            '".$this->session->userdata('user_id')."'
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
        $title = strtolower($this->input->post('page_name'));
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
                    pages 
                SET 
                    `page_title` = '".$this->input->post('page_name')."',
                    `page_url_title` = '".$url_title."',
                    `page_entry` = '".$this->input->post('page_entry')."',
                    `page_img_library` = '".$this->input->post('page_img_library')."',
                    `page_parent` = '".$this->input->post('page_parent')."'
                WHERE 
                    page_id = ".$this->input->post('page_id');
                    
        $qry = $this->db->query($sql);
        
        if($qry){
            return $this->input->post('page_id');
        }
    }
    
/* Gets
***************************************************************/

    function get_all_pages() {
        $qry = $this->db->query('SELECT * FROM `pages` ORDER BY page_id DESC');        
        if($qry){
            return $qry->result();
        }
    }

    function get_this_entry($id) {
        $qry = $this->db->query('SELECT * FROM `pages` WHERE page_id = '.$id);        
        if($qry){
            return $qry->result();
        }
    }

    function count_all_pages() {
        $qry = $this->db->query('SELECT * FROM `pages`');        
        if($qry){
            return $qry->num_row();
        }
    }

/* Quick Edits
***************************************************************/
    
    function display_entry($id) {
        $qry = $this->db->query('UPDATE `pages` SET page_hide = 0 WHERE page_id = '.$id);        
        if($qry){
            return true;
        }
    }

    function archive_entry($id) {
        $qry = $this->db->query('UPDATE `pages` SET page_hide = 1 WHERE page_id = '.$id);        
        if($qry){
            return true;
        }
    }

    function delete_entry($id) {
        $qry = $this->db->query('DELETE FROM `pages` WHERE page_id = '.$id);        
        if($qry){
            return true;
        }
    }

/* Search Actions
***************************************************************/

    //Simple search name function
    function search_page($term){
        $qry = $this->db->query('SELECT * FROM `pages` WHERE page_title LIKE "%'.$term.'%" 
                                || page_entry LIKE "%'.$term.'%" 
                                ORDER BY page_id ASC');       
        if($qry){
            return $qry->result();
        }
    }

}
// End of File
?>