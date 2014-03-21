<?php

/*
    Filename:   model_feedback.php
    Location:   /application/models/
*/

class model_feedback extends CI_Model {

    function __construct() {
        parent::__construct();
    }
    
/* Add Entry
***************************************************************/

    function generate_link() {
        $key = encrypt(time());

        $sql = "INSERT INTO 
                    feedback(
                        fb_client_name, 
                        fb_client_email, 
                        fb_key, 
                        fb_services,
                        fb_sales_rep, 
                        fb_foreman,
                        fb_status,
                        fb_date
                    ) 
                VALUES( '".mysql_real_escape_string($_POST['client_name'])."', 
                        '".mysql_real_escape_string($_POST['client_email'])."', 
                        '".mysql_real_escape_string($key)."', 
                        '".$_POST['services']."',
                        '".mysql_real_escape_string($_POST['sales_rep'])."',
                        '".mysql_real_escape_string($_POST['foreman'])."',
                        'pending',
                        '".date('Y-m-d')."'
                        )";

        $qry = $this->db->query($sql);
        $id = $this->db->insert_id();

        $results = array();

        $results['id'] = $id;
        $results['key'] = $key;
        $results['success'] = true;

        if($qry){
            return $results;
        }else{
            return false;
        }
    }
    
/* Gets
***************************************************************/

    function get_all_feedback() {
        $qry = $this->db->query('SELECT * FROM `feedback_rating` ORDER BY fbr_id DESC');        
        if($qry){
            return $qry->result();
        }
    }

    function get_this_rating($id) {
        $qry = $this->db->query('SELECT * FROM `feedback_rating` WHERE fbr_id = '.$id);        
        if($qry){
            return $qry->result();
        }
    }

    function get_this_feedback($id){
        $query = $this->db->query('SELECT * FROM `feedback` WHERE fb_id = "'.$id.'"');
        if($query){
            return $query->result();
        }
    }

    function get_all_pending_feedback(){
        $query = $this->db->query('SELECT * FROM `feedback` WHERE fb_status = "pending"');
        if($query){
            return $query->result();
        }
    }

/* Modificatons
***************************************************************/

    function delete_entry($id)
    {
        $qry = $this->db->query('SELECT * FROM feedback_rating WHERE fbr_id = '.$id);
        $r = $qry->result();
        $fb_id = $r[0]->fbr_feedback_id;

        $query = $this->db->query('DELETE FROM feedback_rating WHERE fbr_id = "'.$id.'"');
        $q = $this->db->query('DELETE FROM feedback WHERE fb_id = "'.$fb_id.'"');
        if($query && $q)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    function archive_entry($id)
    {
        $query = $this->db->query('UPDATE feedback_rating SET `fbr_display` = "no" WHERE fbr_id = "'.$id.'"');
        if($query)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    function display_entry($id)
    {
        $query = $this->db->query('UPDATE feedback_rating SET `fbr_display` = "yes" WHERE fbr_id = "'.$id.'"');
        if($query)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    function update_rating()
    {
        $id = $this->input->post('id');
        $fb_id = $this->input->post('fb_id');

        $query = $this->db->query(' UPDATE 
                                        feedback_rating 
                                    SET 
                                        `fbr_title` = "'.$this->input->post('title').'",
                                        `fbr_comments` = "'.$this->input->post('comments').'",
                                        `fbr_recommend` = "'.$this->input->post('recommend').'",
                                        `fbr_location` = "'.$this->input->post('location').'",
                                        `fbr_professionalism` = "'.$this->input->post('feedback_professionalism').'",
                                        `fbr_speed` = "'.$this->input->post('feedback_efficiency').'",
                                        `fbr_cleanliness` = "'.$this->input->post('feedback_cleanliness').'",
                                        `fbr_workmanship` = "'.$this->input->post('feedback_workmanship').'",
                                        `fbr_experience` = "'.$this->input->post('feedback_experience').'",
                                        `fbr_cost_value` = "'.$this->input->post('feedback_value').'",
                                        `fbr_sales_rep_rating` = "'.$this->input->post('feedback_sales').'",
                                        `fbr_sales_rep_comments` = "'.$this->input->post('sales_rep_comments').'",
                                        `fbr_foreman_rating` = "'.$this->input->post('feedback_foreman').'",
                                        `fbr_foreman_comments` = "'.$this->input->post('foreman_comments').'"
                                    WHERE 
                                        fbr_id = '.$id);

        $q = $this->db->query(' UPDATE 
                                    feedback 
                                SET 
                                    `fb_client_name` = "'.$this->input->post('client_name').'",
                                    `fb_client_email` = "'.$this->input->post('client_email').'",
                                    `fb_services` = "'.addslashes($this->input->post('services')).'",
                                    `fb_sales_rep` = "'.$this->input->post('sales_rep').'",
                                    `fb_foreman` = "'.$this->input->post('foreman').'"
                                WHERE 
                                    fb_id = '.$fb_id);
        if($query)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

}
// End of File
?>