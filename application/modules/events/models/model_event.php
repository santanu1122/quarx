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
            $title = strtolower($_POST['event_name']);
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
        $title = strtolower($_POST['event_name']);
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
                    
        $qry = mysql_query($sql);
        
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


    // function get_calendar($year, $month) {

    //     $config = array(
    //         'start_day' => 'monday',
    //         'show_next_prev' => true,
    //         'next_prev_url' => base_url() . 'events/calendar'
    //     );
        
    //     $config['template'] = '
    //         {table_open}<table border="0" cellpadding="0" cellspacing="0" class="calendar">{/table_open}
            
    //         {heading_row_start}<tr>{/heading_row_start}
            
    //         {heading_previous_cell}<th><a href="{previous_url}">&lt;&lt;</a></th>{/heading_previous_cell}
    //         {heading_title_cell}<th colspan="{colspan}">{heading}</th>{/heading_title_cell}
    //         {heading_next_cell}<th><a href="{next_url}">&gt;&gt;</a></th>{/heading_next_cell}
            
    //         {heading_row_end}</tr>{/heading_row_end}
            
    //         {week_row_start}<tr>{/week_row_start}
    //         {week_day_cell}<td>{week_day}</td>{/week_day_cell}
    //         {week_row_end}</tr>{/week_row_end}
            
    //         {cal_row_start}<tr class="days">{/cal_row_start}
    //         {cal_cell_start}<td class="day">{/cal_cell_start}
            
    //         {cal_cell_content}
    //             <div class="day_num">{day}</div>
    //             <div class="content">{content}</div>
    //         {/cal_cell_content}
    //         {cal_cell_content_today}
    //             <div class="day_num highlight">{day}</div>
    //             <div class="content">{content}</div>
    //         {/cal_cell_content_today}
            
    //         {cal_cell_no_content}<div class="day_num">{day}</div>{/cal_cell_no_content}
    //         {cal_cell_no_content_today}<div class="day_num highlight">{day}</div>{/cal_cell_no_content_today}
            
    //         {cal_cell_blank}&nbsp;{/cal_cell_blank}
            
    //         {cal_cell_end}</td>{/cal_cell_end}
    //         {cal_row_end}</tr>{/cal_row_end}
            
    //         {table_close}</table>{/table_close}
    //     ';
        
    //     $this->load->library('eventcalendar', $config);
        
    //     $cal_data = array();//$this->get_calendar_data($year, $month);
        
    //     return $this->eventcalendar->generate($year, $month, $cal_data);
        
    // }

}
// End of File
?>