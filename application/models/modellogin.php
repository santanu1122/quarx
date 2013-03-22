<?php

/*
    Filename:   modellogin.php
    Location:   /application/models/
    Author:     Matt Lantz
*/

class modellogin extends CI_Model {
    
    //verifies the root table of the entire quarx platform
    function is_installed() {
        $qry = mysql_query('SELECT * FROM admin');
        if(!$qry){
            return false;
        }else{
            return true;
        }
    }

    function validAccount($uname, $upass){
        $this->db->where('user_name', $uname);
        $this->db->where('user_pass', $upass);
        $this->db->where('user_state', 'enabled');
        $this->db->where('status', 'authorized');
        $query = $this->db->get('users');

        if($query->num_rows == 1){
            $sql = "SELECT * FROM users WHERE user_name ='".$uname."'";
            $qry = mysql_query($sql);
            $row = mysql_fetch_assoc($qry);
            
            $this->session->set_userdata('user_id', $row['user_id']);
            $this->session->set_userdata('email', $row['user_email']);
            $this->session->set_userdata('permission', $row['permission']);
            $this->session->set_userdata('owner', $row['owner']);
            $this->session->set_userdata('company', $row['company']);

                //In case they opt for the remember me option!
                if($this->input->post('remember_me') >= 1){
                    $cookie = array(
                        'name'   => 'quarx-uname',
                        'value'  => $uname,
                        'expire' => '1209600'
                    );

                    $this->input->set_cookie($cookie);
                    
                    $cookie_pass = array(
                        'name'   => 'quarx-pword',
                        'value'  => $upass,
                        'expire' => '1209600'
                    );

                    $this->input->set_cookie($cookie_pass); 
                }
                
                $data = array(
                    'username' => $this->input->post('username'),
                    'logged_in' => true
                );
            
            return true;
        }
    }

    function disabledAccount($uname, $upass){
        $this->db->where('user_name', $uname);
        $this->db->where('user_pass', $upass);
        $this->db->where('user_state', 'disabled');
        $this->db->where('status', 'authorized');
        $query = $this->db->get('users');

        if($query->num_rows == 1){
            return true;
        }

        return false;
    }

    function unauthorizedAccount($uname, $upass){
        $this->db->where('user_name', $uname);
        $this->db->where('user_pass', $upass);
        // $this->db->where('user_state', 'disabled');
        $this->db->where('status', 'unauthorized');
        $query = $this->db->get('users');

        if($query->num_rows == 1){
            return true;
        }
    }

    function noAccount($uname, $upass){
        $this->db->where('user_name', $uname);
        $this->db->where('user_pass', $upass);
        $query = $this->db->get('users');

        if($query->num_rows != 1){
            return true;
        }
    }

    function validate() {

        if($this->validAccount($this->input->post('username'), sha1($this->input->post('password'))) ){
            return 'valid';
        }
        elseif($this->disabledAccount($this->input->post('username'), sha1($this->input->post('password'))) ){
            return 'disabled';
        }
        elseif($this->unauthorizedAccount($this->input->post('username'), sha1($this->input->post('password'))) ){
            return 'unauthorized';
        }
        elseif($this->noAccount($this->input->post('username'), sha1($this->input->post('password'))) ){
            return 'noAccount';
        }
    }

    //A cookie validator if they want to be rememebered!
    function cookie_validate($username, $password){
        $sql = "SELECT * FROM users WHERE user_name = '".$username."' AND user_pass = '".$password."'";
        $query = mysql_query($sql);
        $numRows = mysql_num_rows($query);
        if($numRows === null){
            $numRows = 3;
        }

        if($numRows === 1){
            $sql = "SELECT * FROM users WHERE user_name ='".$username."'";
            $qry = mysql_query($sql);
            $row = mysql_fetch_assoc($qry);
            
            $this->session->set_userdata('user_id', $row['user_id']);
            $this->session->set_userdata('email', $row['user_email']);
            $this->session->set_userdata('permission', $row['permission']);
            $this->session->set_userdata('company', $row['company']);
            $this->session->set_userdata('username', $row['user_name']);
            $this->session->set_userdata('logged_in', true);
            
            return 'success';
        }else{
            return 'fail';
        }
        
    }

    //When you need more teammates, 
    function create_member(){
        $new_member_insert_data = array(
            'first_name' => $this->input->post('first_name'),
            'last_name' => $this->input->post('last_name'),
            'email_address' => $this->input->post('email_address'),         
            'username' => $this->input->post('username'),
            'password' => md5($this->input->post('password'))                       
        );
        
        $insert = $this->db->insert('membership', $new_member_insert_data);
        return $insert;
    }
    
    //A small user validator for forgotten passwords
    function user_validate(){
        $this->db->where('user_name', mysql_real_escape_string($this->input->post('u_name')));
        $this->db->where('user_email', mysql_real_escape_string($this->input->post('u_email')));
        $query = $this->db->get('users');
    
        if($query->num_rows == 1){
            return true;
        }
    }
    
    //A clean and simple password maker
    function newpassword(){
        $rand = rand(10000001,99999999);
            
            $update_sql = "
                        UPDATE
                            users
                        SET
                            user_pass = '".sha1($rand)."'
                        WHERE
                            user_name = '".mysql_real_escape_string($this->input->post('u_name'))."'
                        AND
                            user_email = '".mysql_real_escape_string($this->input->post('u_email'))."'                          
            ";
            
        $update_result = mysql_query($update_sql);  
        return $rand;
    }
    
    //change the password
    function changepassword(){
        $sql = "UPDATE users SET `user_pass` = '".sha1($_POST['password'])."' WHERE user_id =".$this->session->userdata('user_id');
        $qry = mysql_query($sql);
        
        if($qry){
            return true;
        }
    }
}

// End of File

?>