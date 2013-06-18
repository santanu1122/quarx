<?php

/**
 * Quarx
 *
 * A modular CMS built on CodeIgniter
 *
 * @package     Quarx
 * @author      Matt Lantz
 * @copyright   Copyright (c) 2013 Matt Lantz
 * @license     http://ottacon.co/quarx/license
 * @link        http://quarx.ottacon.co
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
        $qry = $this->db->query('SELECT * FROM `users` WHERE user_id='.$this->session->userdata('user_id'));
        if($qry) 
        {
            return $qry->result();
        }
    }

    function unc_validate($name) 
    {
        $this->db->where('user_name', mysql_real_escape_string($name));
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
    
    function profile_update($img, $opts)
    {
        $optional = '';

        if($opts[0]->option_title === 'advanced accounts')
        {
            $optional = "
                `address` = '".$this->input->post('address')."',
                `city` = '".$this->input->post('city')."',
                `state` = '".$this->input->post('state_prov')."',
                `country` = '".$this->input->post('country')."',
                `phone` = '".$this->input->post('phone')."',
                `fax` = '".$this->input->post('fax')."',
                `website` = '".$this->input->post('website')."',
                `company` = '".$this->input->post('company')."',";
        }

        $sql = "UPDATE 
                    users 
                SET 
                    `user_email` = '".$this->input->post('email')."',
                    `full_name` = '".$this->input->post('full_name')."',
                    `location` = '".$this->input->post('location')."',
                    ".$optional."
                    `lat` = '".$this->input->post('latitude')."',
                    `lng` = '".$this->input->post('longitude')."',
                    `img` = '".$img."'
                WHERE 
                    user_id=".$this->session->userdata('user_id');
                    
        $qry = $this->db->query($sql);
        
        if($qry)
        {
            $this->session->set_userdata('email', $this->input->post('email'));
            return true;
        }
    }

/* Add a profile
***************************************************************/
    
    function username_checker() 
    {
        $qry = $this->db->query('SELECT * FROM `users` WHERE user_name = "'.$this->input->post('user_name').'"');       
        if($qry)
        {
            return $qry->result();
        }
    }

    function profile_adder($img, $opts) 
    {
        $permission = 2;
        $optional_inserts = '';
        $optional_vals = '';
        
        $rand = substr(sha1(rand(10000001,99999999)), 0, 9);
        
        $password = hash("sha256", $rand);

        if($opts[0]->option_title === 'advanced accounts')
        {
            $optional_inserts = "address, city, state, country, phone, fax, website, company, ";

            $optional_vals = "
                '".$this->input->post('address')."',
                '".$this->input->post('city')."',
                '".$this->input->post('state_prov')."',
                '".$this->input->post('country')."',
                '".$this->input->post('phone')."',
                '".$this->input->post('fax')."',
                '".$this->input->post('website')."',
                '".$this->input->post('company')."',";
        }

        if($this->input->post('user_name') > ''){
    
            $sql = "INSERT INTO 
                    users(user_name, user_email, user_pass, owner, permission, status, ".$optional_inserts."lat, lng, location, full_name, user_state, img) 
                VALUES( '".$this->input->post('user_name')."', 
                        '".$this->input->post('user_email')."',
                        '".$password."',
                        '".$this->session->userdata('user_id')."',
                        '".$permission."',
                        'authorized',
                        ".$optional_vals."
                        '".$this->input->post('latitude')."',
                        '".$this->input->post('longitude')."',
                        '".$this->input->post('location')."',
                        '".$this->input->post('full_name')."',
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
        $qry = $this->db->query('DELETE FROM users WHERE user_id ='.$id.' AND permission > 0');     
        if($qry)
        {
            return true;
        }
    }
    
    function search_accounts($term) 
    {
        $qry = $this->db->query('SELECT * FROM `users` WHERE user_name LIKE "%'.$term.'%" AND user_id != 1 ORDER BY full_name ASC');      
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

        $qry = $this->db->query('SELECT * FROM `users` WHERE user_name LIKE "%'.$term.'%" AND user_id != 1
                                || full_name LIKE "%'.$term.'%" AND user_id != 1
                                || user_email LIKE "%'.$term.'%" AND user_id != 1
                                || location LIKE "%'.$term.'%" AND user_id != 1
                                 ORDER BY full_name DESC LIMIT '.$offset.', '.$limit);     
        if($qry)
        {
            return $qry->result();
        }
    }
    
    function full_search_totals($name)
    {
        $qry = $this->db->query('SELECT * FROM `users` WHERE user_name LIKE "%'.$name.'%" AND user_id != 1
                                || full_name LIKE "%'.$name.'%" AND user_id != 1
                                || user_email LIKE "%'.$name.'%" AND user_id != 1
                                || location LIKE "%'.$name.'%" AND user_id != 1
                                 ORDER BY full_name DESC');        
        if($qry)
        {
            return count($qry->result());
        }
    }
    
    function editor($id)
    {
        $qry = $this->db->query('SELECT * FROM `users` WHERE user_id = '.$id);      
        if($qry)
        {
            return $qry->result();
        }
    }
    
    function this_profile_update($img, $id, $opts)
    {
        $optional = '';

        if($opts[0]->option_title === 'advanced accounts')
        {
            $optional = "
                `address` = '".$this->input->post('address')."',
                `city` = '".$this->input->post('city')."',
                `state` = '".$this->input->post('state_prov')."',
                `country` = '".$this->input->post('country')."',
                `phone` = '".$this->input->post('phone')."',
                `fax` = '".$this->input->post('fax')."',
                `website` = '".$this->input->post('website')."',
                `company` = '".$this->input->post('company')."',";
        }

        $sql = "UPDATE 
                    users 
                SET 
                    `user_email` = '".$this->input->post('user_email')."',
                    `full_name` = '".$this->input->post('full_name')."',
                    ".$optional."
                    `location` = '".$this->input->post('location')."',
                    `lat` = '".$this->input->post('latitude')."',
                    `lng` = '".$this->input->post('longitude')."',
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
                    `status` = 'authorized'
                WHERE 
                    user_id =".$id;
                    
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
                    user_id =".$id;
                    
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
                    user_id =".$id;
                    
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
                    user_id =".$id;
                    
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
                    user_id =".$id;
                    
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
        $qry = $this->db->query('SELECT * FROM `users` WHERE user_id = '.$id.' ORDER BY user_name ASC LIMIT 1');
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
                                        ORDER BY user_name ASC LIMIT '.$offset.', '.$limit);
        }
        else
        {
            $qry = $this->db->query('   SELECT * 
                                        FROM `users` 
                                        WHERE permission > 1 
                                        AND permission < 50
                                        AND owner = '.$this->session->userdata('user_id').' 
                                        ORDER BY user_name ASC LIMIT '.$offset.', '.$limit);
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