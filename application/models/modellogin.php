<?php

/*
    Filename:   modellogin.php
    Location:   /application/models/
*/

class modellogin extends CI_Model {

    function validAccount($uname, $upass)
    {
        $this->db->where('user_name', $uname);
        $this->db->where('user_pass', $upass);
        $this->db->where('user_state', 'enabled');
        $this->db->where('status', 'authorized');
        $query = $this->db->get('users');

        if($query->num_rows() == 1)
        {
            $sql = "SELECT * FROM users WHERE user_name ='".$uname."'";
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
        }
    }

    function disabledAccount($uname, $upass)
    {
        $this->db->where('user_name', $uname);
        $this->db->where('user_pass', $upass);
        $this->db->where('user_state', 'disabled');
        $this->db->where('status', 'authorized');
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
        $this->db->where('status', 'unauthorized');
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
        if($this->validAccount($this->input->post('username'), hash("sha256", $this->input->post('password'))) )
        {
            return 'valid';
        }
        
        elseif($this->disabledAccount($this->input->post('username'), hash("sha256", $this->input->post('password'))) )
        {
            return 'disabled';
        }
        
        elseif($this->unauthorizedAccount($this->input->post('username'), hash("sha256", $this->input->post('password'))) )
        {
            return 'unauthorized';
        }
        
        elseif($this->noAccount($this->input->post('username'), hash("sha256", $this->input->post('password'))) )
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
                            user_name = '".$this->input->post('u_name')."'
                        AND
                            user_email = '".$this->input->post('u_email')."'                          
            ";
            
        $update_result = $this->db->query($update_sql);

        return $rand;
    }
    
    function changepassword()
    {
        $sql = "UPDATE users SET `user_pass` = '".hash("sha256", $this->input->post('password'))."' WHERE user_id =".$this->session->userdata('user_id');
        $qry = $this->db->query($sql);
        
        if($qry)
        {
            return true;
        }
    }
}

// End of File

?>