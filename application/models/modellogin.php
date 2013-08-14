<?php

/**
 * Quarx
 *
 * A modular application framework built on CodeIgniter
 *
 * @package     Quarx
 * @author      Matt Lantz
 * @copyright   Copyright (c) 2013 Matt Lantz
 * @license     http://ottacon.co/quarx/license.html
 * @link        http://ottacon.co/quarx
 * @since       Version 1.0
 * 
 */

class modellogin extends CI_Model {

    function validAccount($uname, $upass)
    {
        $this->db->where('user_name', $uname);
        $this->db->where('user_pass', $upass);
        $this->db->where('user_state', 'enabled');
        $this->db->where('a_status', 'authorized');
        $query = $this->db->get('users');

        if($query->num_rows() == 1)
        {
            $sql = "SELECT * FROM users WHERE user_name ='".$this->db->escape_str($uname)."'";
            $qry = $this->db->query($sql);

            foreach ($qry->result() as $row):
            
                $this->db->query("UPDATE users SET `last_login` = '".date('Y-m-d')."', `login_counter` = login_counter+1 WHERE user_id = ".$row->user_id);

                $this->session->set_userdata('user_id', $row->user_id);
                $this->session->set_userdata('email', $row->user_email);
                $this->session->set_userdata('permission', $row->permission);
                @$this->session->set_userdata('owner', $row->owner);
                $this->session->set_userdata('logged_in', true);

                @$this->session->set_userdata('company', $row->company);

                if($this->input->post('remember_me') >= 1)
                {
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

            endforeach;
            
            return true;
        
        }else{

            return false;
        }
    }

    function disabledAccount($uname, $upass)
    {
        $this->db->where('user_name', $uname);
        $this->db->where('user_pass', $upass);
        $this->db->where('user_state', 'disabled');
        $this->db->where('a_status', 'authorized');
        $query = $this->db->get('users');

        if($query->num_rows == 1)
        {
            return true;
        }

        return false;
    }

    function unauthorizedAccount($uname, $upass)
    {
        $this->db->where('user_name', $uname);
        $this->db->where('user_pass', $upass);
        $this->db->where('a_status', 'unauthorized');
        $query = $this->db->get('users');

        if($query->num_rows == 1)
        {
            return true;
        }
    }

    function noAccount($uname, $upass)
    {
        $this->db->where('user_name', $uname);
        $this->db->where('user_pass', $upass);
        $query = $this->db->get('users');

        if($query->num_rows != 1)
        {
            return true;
        }
    }

    function validate()
    {
        if($this->validAccount($this->input->post('username'), hash("sha256", $this->db->escape_str($this->input->post('password')))) )
        {
            return 'valid';
        }
        
        elseif($this->disabledAccount($this->input->post('username'), hash("sha256", $this->db->escape_str($this->input->post('password')))) )
        {
            return 'disabled';
        }
        
        elseif($this->unauthorizedAccount($this->input->post('username'), hash("sha256", $this->db->escape_str($this->input->post('password')))) )
        {
            return 'unauthorized';
        }
        
        elseif($this->noAccount($this->input->post('username'), hash("sha256", $this->db->escape_str($this->input->post('password')))) )
        {
            return 'noAccount';
        }
    }

    //A cookie validator if they want to be rememebered!
    function cookie_validate($username, $password)
    {
        $sql = "SELECT * FROM users WHERE user_name = '".$username."' AND user_pass = '".$password."'";
        $query = $this->db->query($sql);
        $numRows = $query->num_rows();
        
        if($numRows === null)
        {
            $numRows = 3;
        }

        if($numRows === 1)
        {
            $sql = "SELECT * FROM users WHERE user_name ='".$username."'";
            $qry = $this->db->query($sql);
            foreach ($qry->result() as $row):
                $this->session->set_userdata('user_id', $row->user_id);
                $this->session->set_userdata('email', $row->user_email);
                $this->session->set_userdata('permission', $row->permission);
                $this->session->set_userdata('company', $row->company);
                $this->session->set_userdata('username', $row->user_name);
                $this->session->set_userdata('logged_in', true);

                $this->db->query("UPDATE users SET `last_login` = '".date('Y-m-d')."', `login_counter` = login_counter+1 WHERE user_id = ".$row->user_id);
            endforeach;

            return 'success';
        }
        else
        {
            return 'fail';
        } 
    }
    
    function user_validate()
    {
        $this->db->where('user_name', $this->input->post('u_name'));
        $this->db->where('user_email', $this->input->post('u_email'));
        $query = $this->db->get('users');
    
        if($query->num_rows == 1)
        {
            return true;
        }
    }
    
    function newpassword()
    {
        $rand = substr(sha1(rand(10000001,99999999)), 0, 9);
            
            $update_sql = "
                        UPDATE
                            users
                        SET
                            user_pass = '".hash("sha256", $rand)."'
                        WHERE
                            user_name = '".$this->db->escape_str($this->input->post('u_name'))."'
                        AND
                            user_email = '".$this->db->escape_str($this->input->post('u_email'))."'                          
            ";
            
        $update_result = $this->db->query($update_sql);

        return $rand;
    }
    
    function changepassword()
    {
        $sql = "UPDATE users SET `user_pass` = '".hash("sha256", $this->db->escape_str($this->input->post('password')))."' WHERE user_id =".$this->session->userdata('user_id');
        $qry = $this->db->query($sql);
        
        if($qry)
        {
            return true;
        }
    }

    function submit_profile() 
    {
        $permission = 2;

        $auth = "unauthorized";
        $state = "disabled";

        if($this->quarxsetup->get_option("auto_auth") == "on"){
            $auth = "authorized";
            $state = "enabled";
        }

        if($this->db->escape_str($this->input->post("password")) != $this->db->escape_str($this->input->post("confirm"))){
            return false;
        }
        
        $password = hash("sha256", $this->db->escape_str($this->input->post("password")));

        if($this->input->post('user_name') > ''){
    
            $sql = "INSERT INTO 
                    users(user_name, user_email, user_pass, owner, permission, a_status, location, full_name, user_state, img) 
                VALUES( '".$this->db->escape_str($this->input->post('user_name'))."', 
                        '".$this->db->escape_str($this->input->post('user_email'))."',
                        '".$password."',
                        '0',
                        '".$permission."',
                        '".$auth."',
                        '".$this->db->escape_str($this->input->post('location'))."',
                        '".$this->db->escape_str($this->input->post('full_name'))."',
                        '".$state."',
                        '".site_url()."uploads/img/thumb/default.jpg'
                        )";

            $qry = $this->db->query($sql);
    
            if($qry)
            {
                return true;
            }

        }else{
            return false;
        }
    }
}

// End of File

?>