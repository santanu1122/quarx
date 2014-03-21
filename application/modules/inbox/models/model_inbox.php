<?php

/*
    Filename:   model_inbox.php
    Location:   /application/models/
*/

class model_inbox extends CI_Model {

    function __construct() {
        parent::__construct();
    }
    
/* Add User
***************************************************************/

    function send_message() 
    {
        $sql = "INSERT INTO 
                    inbox(  
                            inbox_user_id,
                            inbox_from, 
                            inbox_title, 
                            inbox_message, 
                            inbox_send
                        ) 
                VALUES( '".getUserId($this->input->post("user_name"))."', 
                        '".$this->session->userdata('user_id')."',
                        '".$this->input->post('subject')."',
                        '".$this->input->post('message')."',
                        '".date("Y-m-d H:i:s")."'
                        )";

        $qry = $this->db->query($sql);

        if($qry){
            return true;
        }else{
            return false;
        }
    }

/* Delete Message
***************************************************************/

    function delete_message($id) {
        $qry = $this->db->query('DELETE FROM `inbox` WHERE inbox_id = '.$id.' AND inbox_user_id = '.$this->session->userdata('user_id'));        
        if($qry){
            return true;
        }else{
            return false;
        }
    }
    
/* Gets
***************************************************************/

    function get_all_my_messages() {
        $qry = $this->db->query('SELECT * FROM `inbox` WHERE inbox_user_id = '.$this->session->userdata("user_id").' ORDER BY inbox_send DESC');        
        if($qry){
            return $qry->result();
        }
    }

    function get_this_message($id) {
        $qry = $this->db->query('SELECT * FROM `inbox` WHERE inbox_user_id = '.$this->session->userdata("user_id").' AND inbox_id = '.$id);        
        if($qry){
            return $qry->result();
        }
    }

    function find_users($term) {
        $qry = $this->db->query('SELECT user_name, user_id FROM `users` WHERE user_name LIKE "%'.$term.'%" || user_email LIKE "%'.$term.'%" AND user_state = "enabled" AND permission > 1 AND permission < 50');        
        if($qry){
            return $qry->result();
        }
    }

    function get_an_id($name) {
        $qry = $this->db->query('SELECT user_name, user_id FROM `users` WHERE user_name = "'.$name.'" AND user_state = "enabled" AND permission > 1 AND permission < 50');
        if($qry){
            return $qry->result();
        }
    }

/* Search Actions
***************************************************************/

    function search_inbox($term){
        $res = array();
        $this->load->library("inbox_tools");

        $qry = $this->db->query('SELECT * FROM `inbox` WHERE inbox_message LIKE "%'.$term.'%" || inbox_title LIKE "%'.$term.'%" || inbox_from = "'.getUserId($term).'" ORDER BY inbox_send ASC');

        foreach ($qry->result() as $r) {
            if($r->inbox_user_id == $this->session->userdata("user_id")){
                array_push($res, $r);
            }
        }

        return $res;
    }

}
// End of File
?>