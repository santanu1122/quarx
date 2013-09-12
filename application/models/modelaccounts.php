<?php

/**
 * Quarx
 *
 * A modular application framework built on CodeIgniter
 *
 * @package     Quarx
 * @author      Matt Lantz
 * @copyright   Copyright (c) 2013 Matt Lantz
 * @license     http://ottacon.co/quarx/licence.html
 * @link        http://ottacon.co/quarx
 * @since       Version 1.0
 * 
 */

class modelaccounts extends CI_Model {

    function __construct() 
    {
        parent::__construct();
    }
    
    function my_account() 
    {
        $qry = $this->db->query('SELECT * FROM `users` WHERE user_id = '.$this->session->userdata('user_id'));
        if($qry) 
        {
            return $qry->result();
        }
    }

    function unc_validate($name)
    {
        if(!$name){
            return 0;
        }

        $this->db->where('user_name', $this->db->escape_str($name));
        $query = $this->db->get('users');
        if($query->num_rows == 1)
        {
            return 1;
        }
        else
        {
            return 0;
        }
    }
    
    function this_account($id) 
    {
        $qry = $this->db->query('SELECT * FROM `users` WHERE user_id='.$id);        
        if($qry)
        {
            return $qry->result();
        }
    }
    
    function profile_update($img)
    {
        $optional = '';

        if($this->quarxsetup->get_option("account_type") == 'advanced accounts')
        {
            $optional = "
                `address` = '".$this->db->escape_str($this->input->post('address'))."',
                `city` = '".$this->db->escape_str($this->input->post('city'))."',
                `state` = '".$this->db->escape_str($this->input->post('state_prov'))."',
                `country` = '".$this->db->escape_str($this->input->post('country'))."',
                `phone` = '".$this->db->escape_str($this->input->post('phone'))."',
                `fax` = '".$this->db->escape_str($this->input->post('fax'))."',
                `website` = '".$this->db->escape_str($this->input->post('website'))."',
                `company` = '".$this->db->escape_str($this->input->post('company'))."',";
        }

        $sql = "UPDATE 
                    users 
                SET 
                    `user_email` = '".$this->db->escape_str($this->input->post('email'))."',
                    `full_name` = '".$this->db->escape_str($this->input->post('full_name'))."',
                    `location` = '".$this->db->escape_str($this->input->post('location'))."',
                    ".$optional."
                    `lat` = '".$this->db->escape_str($this->input->post('latitude'))."',
                    `lng` = '".$this->db->escape_str($this->input->post('longitude'))."',
                    `img` = '".$img."'
                WHERE 
                    user_id=".$this->session->userdata('user_id');
                    
        $qry = $this->db->query($sql);
        
        if($qry)
        {
            $this->session->set_userdata('email', $this->db->escape_str($this->input->post('email')));
            return true;
        }
    }

/* Add a profile
***************************************************************/
    
    function username_checker() 
    {
        $qry = $this->db->query('SELECT * FROM `users` WHERE user_name = "'.$this->db->escape_str($this->input->post('user_name')).'"');       
        if($qry)
        {
            return $qry->result();
        }
    }

    function profile_adder($img) 
    {
        $permission = 2;
        $optional_inserts = '';
        $optional_vals = '';
        
        $rand = substr(sha1(rand(10000001,99999999)), 0, 9);
        
        $password = hash("sha256", $rand);

        if($this->db->escape_str($this->input->post('user_name')) == '' || $this->db->escape_str($this->input->post('user_email')) == ''){
            return false;
        }

        if($this->quarxsetup->get_option("account_type") == 'advanced accounts')
        {
            $optional_inserts = "address, city, state, country, phone, fax, website, company, ";

            $optional_vals = "
                '".$this->db->escape_str($this->input->post('address'))."',
                '".$this->db->escape_str($this->input->post('city'))."',
                '".$this->db->escape_str($this->input->post('state_prov'))."',
                '".$this->db->escape_str($this->input->post('country'))."',
                '".$this->db->escape_str($this->input->post('phone'))."',
                '".$this->db->escape_str($this->input->post('fax'))."',
                '".$this->db->escape_str($this->input->post('website'))."',
                '".$this->db->escape_str($this->input->post('company'))."',";
        }

        if($this->db->escape_str($this->input->post('user_name')) > ''){
    
            $sql = "INSERT INTO 
                    users(user_name, user_email, user_pass, owner, permission, a_status, ".$optional_inserts."lat, lng, location, full_name, user_state, img) 
                VALUES( '".$this->db->escape_str($this->input->post('user_name'))."', 
                        '".$this->db->escape_str($this->input->post('user_email'))."',
                        '".$password."',
                        '".$this->db->escape_str($this->session->userdata('user_id'))."',
                        '".$permission."',
                        'authorized',
                        ".$optional_vals."
                        '".$this->db->escape_str($this->input->post('latitude'))."',
                        '".$this->db->escape_str($this->input->post('longitude'))."',
                        '".$this->db->escape_str($this->input->post('location'))."',
                        '".$this->db->escape_str($this->input->post('full_name'))."',
                        'enabled',
                        '".$img."'
                        )";

            $qry = $this->db->query($sql);
    
        }

        if($qry)
        {
            return $rand;
        }
    }
    
    function account_manager()
    {
        $qry = $this->db->query('SELECT * FROM `users` WHERE permission = 2');      
        if($qry){
            return $qry->result();
        }
    }
    
    function profile_deleter($id)
    {
        $qry = $this->db->query('DELETE FROM users WHERE user_id ='.$this->db->escape_str($id).' AND permission > 0');     
        if($qry)
        {
            return true;
        }
    }
    
    function search_accounts($term) 
    {
        $qry = $this->db->query('SELECT * FROM `users` WHERE user_name LIKE "%'.$this->db->escape_like_str($term).'%" AND user_id != 1 AND permission < 50 ORDER BY full_name ASC');      
        if($qry)
        {
            return $qry->result();
        }
    }
    
    function search_accounts_full($term, $offset=null, $limit=null)
    {
        if($offset == null)
        { 
            $offset = 0; 
        }

        $qry = $this->db->query('SELECT * FROM `users` WHERE user_name LIKE "%'.$this->db->escape_like_str($term).'%" AND user_id != 1 AND permission < 50
                                || full_name LIKE "%'.$this->db->escape_like_str($term).'%" AND user_id != 1 AND permission < 50
                                || user_email LIKE "%'.$this->db->escape_like_str($term).'%" AND user_id != 1 AND permission < 50
                                || location LIKE "%'.$this->db->escape_like_str($term).'%" AND user_id != 1 AND permission < 50
                                 ORDER BY full_name DESC LIMIT '.$offset.', '.$limit);     
        if($qry)
        {
            return $qry->result();
        }
    }
    
    function full_search_totals($name)
    {
        $qry = $this->db->query('SELECT * FROM `users` WHERE user_name LIKE "%'.$this->db->escape_like_str($name).'%" AND user_id != 1 AND permission < 50
                                || full_name LIKE "%'.$this->db->escape_like_str($name).'%" AND user_id != 1 AND permission < 50
                                || user_email LIKE "%'.$this->db->escape_like_str($name).'%" AND user_id != 1 AND permission < 50
                                || location LIKE "%'.$this->db->escape_like_str($name).'%" AND user_id != 1 AND permission < 50
                                 ORDER BY full_name DESC');        
        if($qry)
        {
            return count($qry->result());
        }
    }
    
    function editor($id)
    {
        $qry = $this->db->query('SELECT * FROM `users` WHERE user_id = '.$this->db->escape_str($id));      
        if($qry)
        {
            return $qry->result();
        }
    }
    
    function this_profile_update($img, $id)
    {
        $optional = '';

        if($this->quarxsetup->get_option("account_type") == 'advanced accounts')
        {
            $optional = "
                `address` = '".$this->db->escape_str($this->input->post('address'))."',
                `city` = '".$this->db->escape_str($this->input->post('city'))."',
                `state` = '".$this->db->escape_str($this->input->post('state_prov'))."',
                `country` = '".$this->db->escape_str($this->input->post('country'))."',
                `phone` = '".$this->db->escape_str($this->input->post('phone'))."',
                `fax` = '".$this->db->escape_str($this->input->post('fax'))."',
                `website` = '".$this->db->escape_str($this->input->post('website'))."',
                `company` = '".$this->db->escape_str($this->input->post('company'))."',";
        }

        $sql = "UPDATE 
                    users 
                SET 
                    `user_email` = '".$this->db->escape_str($this->input->post('user_email'))."',
                    `full_name` = '".$this->db->escape_str($this->input->post('full_name'))."',
                    ".$optional."
                    `location` = '".$this->db->escape_str($this->input->post('location'))."',
                    `lat` = '".$this->db->escape_str($this->input->post('latitude'))."',
                    `lng` = '".$this->db->escape_str($this->input->post('longitude'))."',
                    `img` = '".$img."'
                WHERE 
                    user_id =".$id;
                    
        $qry = $this->db->query($sql);
        
        if($qry)
        {
            return true;
        }
    }

    function authorize_user($id) 
    {
        $sql = "UPDATE 
                    users 
                SET 
                    `a_status` = 'authorized'
                WHERE 
                    user_id =".$this->db->escape($id);
                    
        $qry = $this->db->query($sql);
        
        if($qry)
        {
            return true;
        }
    }

    function enable_user($id)
    {
        $sql = "UPDATE 
                    users 
                SET 
                    `user_state` = 'enabled'
                WHERE 
                    user_id =".$this->db->escape($id);
                    
        $qry = $this->db->query($sql);
        
        if($qry)
        {
            return true;
        }
    }

    function master_user_upgrade($id) 
    {
        $sql = "UPDATE 
                    users 
                SET 
                    `permission` = 1,
                    `owner` = ".$this->session->userdata('user_id')."
                WHERE 
                    user_id =".$this->db->escape($id);
                    
        $qry = $this->db->query($sql);
        
        if($qry)
        {
            return true;
        }
    }

    function master_user_downgrade($id)
    {
        $sql = "UPDATE 
                    users 
                SET 
                    `permission` = 2,
                    `owner` = 0
                WHERE 
                    user_id =".$this->db->escape($id);
                    
        $qry = $this->db->query($sql);
        
        if($qry)
        {
            return true;
        }
    }

    function disable_user($id)
    {
        $sql = "UPDATE 
                    users 
                SET 
                    `user_state` = 'disabled'
                WHERE 
                    user_id =".$this->db->escape($id);
                    
        $qry = $this->db->query($sql);
        
        if($qry)
        {
            return true;
        }
    }

/* GETS
***************************************************************/
    
    function get_a_name($id)
    {
        $qry = $this->db->query('SELECT * FROM `users` WHERE user_id = '.$this->db->escape($id).' ORDER BY user_name ASC LIMIT 1');
        if($qry)
        {
            return $qry->result();
        }
    }

    function all_profiles($offset=null, $limit=null)
    {
        if($offset == null)
        { 
            $offset = 0; 
        }
        
        if($this->session->userdata('owner') == 0)
        {
            $qry = $this->db->query('   SELECT * 
                                        FROM `users` 
                                        WHERE permission >= 1
                                        AND permission < 50
                                        AND user_id != 1
                                        ORDER BY user_name ASC LIMIT '.$this->db->escape_str($offset).', '.$this->db->escape_str($limit));
        }
        else
        {
            $qry = $this->db->query('   SELECT * 
                                        FROM `users` 
                                        WHERE permission > 1 
                                        AND permission < 50
                                        AND owner = '.$this->db->escape_str($this->session->userdata('user_id')).' 
                                        ORDER BY user_name ASC LIMIT '.$this->db->escape_str($offset).', '.$this->db->escape_str($limit));
        }

        if($qry)
        {
            return $qry->result();
        }
    }
    
    function all_profiles_unlimited() 
    {
        $qry = $this->db->query('SELECT * FROM `users` WHERE permission > 1 AND permission < 50 ORDER BY user_name ASC');       
        if($qry)
        {
            return $qry->result();
        }
    }
    
    function all_profiles_tally()
    {
        $qry = $this->db->query('SELECT * FROM `users` WHERE permission > 1 AND permission < 50 ORDER BY user_name ASC');       
        if($qry)
        {
            return count($qry->result());
        }
    }
}

// End of File
?>