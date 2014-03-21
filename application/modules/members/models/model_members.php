<?php

/*
    Filename:   model_users.php
    Location:   /application/models/
*/

class model_members extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }

/* Add User
***************************************************************/

    function add_user($img) {
        //has to generate a password

        $sql = "INSERT INTO
                    atomic_users(
                            user_name,
                            user_email,
                            user_fullname,
                            user_location,
                            user_bio,
                            user_img,
                            user_status
                        )
                VALUES( '".$this->input->post('user_name')."',
                        '".$this->input->post('user_email')."',
                        '".$this->input->post('full_name')."',
                        '".$this->input->post('location')."',
                        '".$this->input->post('bio')."',
                        '".$img."',
                        'enabled'
                        )";

        $qry = $this->db->query($sql);

        //has to email out a password

        if($qry){
            return true;
        }else{
            return false;
        }
    }

    function unc_validate($name) {
        $this->db->where('user_name', $name);
        $query = $this->db->get('atomic_users');
        if($query->num_rows >= 1){
            return 1;
        }else{
            return 0;
        }
    }

/* Delete User
***************************************************************/

    function delete_user($id) {
        $qry = $this->db->query('DELETE FROM `atomic_users` WHERE user_id = '.$id);
        if($qry){
            return true;
        }else{
            return false;
        }
    }

/* Enable User
***************************************************************/

    function enable_user($id) {
        $qry = $this->db->query('UPDATE atomic_users SET `user_status` = "enabled" WHERE user_id = '.$id);
        if($qry){
            return true;
        }else{
            return false;
        }
    }

/* Disable User
***************************************************************/

    function disable_user($id) {
        $qry = $this->db->query('UPDATE atomic_users SET `user_status` = "disabled" WHERE user_id = '.$id);
        if($qry){
            return true;
        }else{
            return false;
        }
    }

/* Edit User
***************************************************************/

    function update_user($img) {
        $sql = "UPDATE
                    atomic_users
                SET
                    `user_email` = '".$this->input->post('user_email')."',
                    `user_fullname` = '".$this->input->post('full_name')."',
                    `user_location` = '".$this->input->post('location')."',
                    `user_bio` = '".$this->input->post('bio')."',
                    `user_img` = '".$img."'
                WHERE
                    user_id = ".$this->input->post('user_id');

        $qry = $this->db->query($sql);

        if($qry){
            return true;
        }else{
            return false;
        }
    }

/* Gets
***************************************************************/

    function get_all_members() {
        $qry = $this->db->query('SELECT * FROM `atomic_users` ORDER BY user_id DESC');
        if($qry){
            return $qry->result();
        }
    }

    function get_this_member($id) {
        $qry = $this->db->query('SELECT * FROM `atomic_users` WHERE user_id = '.$id);
        if($qry){
            return $qry->result();
        }
    }

/* Search Actions
***************************************************************/

    //Simple search name function
    function search_users($term){
        $qry = $this->db->query('SELECT * FROM `atomic_users` WHERE user_name LIKE "%'.$term.'%"
                                || user_fullname LIKE "%'.$term.'%"
                                || user_email LIKE "%'.$term.'%"
                                ORDER BY user_fullname ASC');
        if($qry){
            return $qry->result();
        }
    }

}
// End of File
?>