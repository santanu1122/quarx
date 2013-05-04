<?php

/*
    Filename:   model_event.php
    Location:   /application/models/
*/

class model_event extends CI_Model {

    function __construct() {
        parent::__construct();
        
    }
    
/* Add Entry
***************************************************************/

    function add_entry() {
        if($this->input->post('event_name') > '' && $this->input->post('event_entry') > '' && $this->input->post('event_cat') > ''){
            $url_title = strip_special_chars(strtolower($_POST['event_name']));

            $sql = "INSERT INTO 
                        events(event_title, event_url_title, event_entry, event_cat, event_img_library, event_start_date, event_end_date, event_hide, author_id) 
                    VALUES( '".mysql_real_escape_string($this->input->post('event_name'))."', 
                            '".mysql_real_escape_string($url_title)."', 
                            '".mysql_real_escape_string($this->input->post('event_entry'))."',
                            '".mysql_real_escape_string($this->input->post('event_cat'))."',
                            '".mysql_real_escape_string($this->input->post('event_img_library'))."',
                            '".mysql_real_escape_string($this->input->post('event_start_date'))."',
                            '".mysql_real_escape_string($this->input->post('event_end_date'))."',
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
        $title = strtolower($_POST['event_name']);
        $title = html_entity_decode($title);
        $url_title = strip_special_chars($title);

        $sql = "UPDATE 
                    events 
                SET 
                    `event_title` = '".mysql_real_escape_string($_POST['event_name'])."',
                    `event_url_title` = '".mysql_real_escape_string($url_title)."',
                    `event_entry` = '".mysql_real_escape_string($_POST['event_entry'])."',
                    `event_img_library` = '".mysql_real_escape_string($_POST['event_img_library'])."',
                    `event_start_date` = '".mysql_real_escape_string($_POST['event_start_date'])."',
                    `event_end_date` = '".mysql_real_escape_string($_POST['event_end_date'])."',
                    `event_cat` = '".mysql_real_escape_string($_POST['event_cat'])."'
                WHERE 
                    event_id = ".$_POST['event_id'];
                    
        $qry = $this->db->query($sql);
        
        if($qry){
            return $_POST['event_id'];
        }
    }
    
/* Gets
***************************************************************/

    function get_all_entries() {
        $qry = $this->db->query('SELECT * FROM `events` ORDER BY event_start_date DESC');        
        if($qry){
            return $qry->result();
        }
    }

    function get_this_entry($id) {
        $qry = $this->db->query('SELECT * FROM `events` WHERE event_id = '.$id);        
        if($qry){
            return $qry->result();
        }
    }

    function count_all_entries() {
        $qry = $this->db->query('SELECT * FROM `events`');        
        if($qry){
            return $qry->num_row();
        }
    }

/* Quick Edits
***************************************************************/
    
    function display_entry($id) {
        $qry = $this->db->query('UPDATE `events` SET event_hide = 0 WHERE event_id = '.$id);        
        if($qry){
            return true;
        }
    }

    function archive_entry($id) {
        $qry = $this->db->query('UPDATE `events` SET event_hide = 1 WHERE event_id = '.$id);        
        if($qry){
            return true;
        }
    }

    function delete_entry($id) {
        $qry = $this->db->query('DELETE FROM `events` WHERE event_id = '.$id);        
        if($qry){
            return true;
        }
    }

/* Search Actions
***************************************************************/

    //Simple search name function
    function search_event($term){
        $qry = $this->db->query('SELECT * FROM `events` WHERE event_title LIKE "%'.$term.'%" 
                                || event_entry LIKE "%'.$term.'%" 
                                ORDER BY event_id ASC');       
        if($qry){
            return $qry->result();
        }
    }

/* Calendar
***************************************************************/

    function get_calendar_data($year, $month) {
        $query = $this->db->query('SELECT * FROM events WHERE event_start_date LIKE "%'.$year.'-'.$month.'%"');
        return $query->result();
    }

}
// End of File
?>