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

class modelsetup extends CI_Model {

/* Check setup state
***************************************************************/

function is_installed() 
{
    $qry = $this->db->query('SELECT * FROM admin');
    
    if($qry->num_rows() > 0){
        return true;
    }else{
        return false;
    }
}

function createdb($user, $name)
{
    $this->load->dbforge();
    $qry = $this->dbforge->create_database($user."_".$name);
    if(!$qry)
    {
        return false;
    }
    else
    {
        return true;
    }
}

function find_db($user, $pass, $name)
{
    $qry = $this->load->database($name);
    
    if(!$qry)
    {
        return false;
    }
    else
    {
        return true;
    }
}

function current_version()
{
    $qry = $this->db->query("SELECT * FROM admin WHERE admin_opts = 5");
    
    if($qry)
    {
        return $qry->result();
    }
}

function update_version($ver)
{
    $qry = $this->db->query("UPDATE admin SET option_title = '".$ver."' WHERE admin_opts = 5");
    
    if(!$qry)
    {
        return false;
    }
    else
    {
        return true;
    }
}

/* Add User Details
***************************************************************/

    function add_user_table($extras)
    {
        $this->load->dbforge();
        $this->dbforge->add_field("`user_id` INT(14) NOT NULL auto_increment");
        $this->dbforge->add_field("`user_name` VARCHAR(160) NOT NULL");
        $this->dbforge->add_field("`user_pass` VARCHAR(160) NOT NULL");
        $this->dbforge->add_field("`user_email` VARCHAR(255) NOT NULL");
        $this->dbforge->add_field("`permission` INT(2) NOT NULL");
        $this->dbforge->add_field("`owner` INT(14) NOT NULL");
        $this->dbforge->add_field("`a_status` VARCHAR(40) NOT NULL");
        $this->dbforge->add_field("`full_name` VARCHAR(255) NOT NULL");

        if($extras === true)
        {
            $this->dbforge->add_field("`phone` VARCHAR(150) NOT NULL");
            $this->dbforge->add_field("`fax` VARCHAR(150) NOT NULL");
            $this->dbforge->add_field("`address` VARCHAR(255) NOT NULL");
            $this->dbforge->add_field("`city` VARCHAR(155) NOT NULL");
            $this->dbforge->add_field("`state` VARCHAR(155) NOT NULL");
            $this->dbforge->add_field("`country` VARCHAR(155) NOT NULL");
            $this->dbforge->add_field("`website` VARCHAR(255) NOT NULL");
            $this->dbforge->add_field("`company` VARCHAR(255) NOT NULL");
        }

        $this->dbforge->add_field("`img` VARCHAR(255) NOT NULL default 'default.jpg'");
        $this->dbforge->add_field("`location` VARCHAR(255) NOT NULL");
        $this->dbforge->add_field("`user_state` VARCHAR(40) NOT NULL");
        $this->dbforge->add_field("`last_login` DATE NOT NULL");
        $this->dbforge->add_field("`login_counter` INT(10) NOT NULL");
        $this->dbforge->add_field("`lat` decimal(9,6) NOT NULL");
        $this->dbforge->add_field("`lng` decimal(9,6) NOT NULL");

        $this->dbforge->add_key('user_id', TRUE);
        $qry = $this->dbforge->create_table('users', TRUE);

        $this->db->query("CREATE UNIQUE INDEX `user_name` ON users (`user_name`)");

        if(!$qry)
        {
            return false;
        }
    }

    function add_master_user($username, $userpass)
    {
        $qry = $this->db->query("INSERT INTO `users` (`user_id`, `user_name`, `user_pass`, `user_email`, `permission`, `full_name`, `img`, `location`, `lat`, `lng`, `user_state`, `a_status`) 
            VALUES
            (1, '".$username."', '".hash("sha256", $userpass)."', '', 1, '', '".site_url()."uploads/img/thumb/default.jpg', '', 0.000000, 0.000000, 'enabled', 'authorized');");
        
        if(!$qry)
        {
            return false;
        }
    }

/* Add Admin Details
***************************************************************/

    function add_admin_table()
    {
        $this->load->dbforge();
        $this->dbforge->add_field("`admin_opts` INT(14) NOT NULL AUTO_INCREMENT");
        $this->dbforge->add_field("`option_title` VARCHAR(80) NOT NULL");
        $this->dbforge->add_field("`option_data` VARCHAR(255) NOT NULL");

        $this->dbforge->add_key('admin_opts', TRUE);
        $qry = $this->dbforge->create_table('admin', TRUE);

        if(!$qry)
        {
            return false;
        }
    }

    function add_admin_opts($avdAccounts, $master, $version, $db_array)
    {
        $adv_acc_qry = $this->db->query("INSERT INTO `admin` (`admin_opts`, `option_title`, `option_data`) 
            VALUES
            (1, 'account_type', '".$avdAccounts."');");

        $master_qry = $this->db->query("INSERT INTO `admin` (`admin_opts`, `option_title`, `option_data`) 
            VALUES
            (3, 'access_type', '".$master."');");

        $version_qry = $this->db->query("INSERT INTO `admin` (`admin_opts`, `option_title`, `option_data`) 
            VALUES
            (5, 'quarx_version', '".$version."');");

        $joining_qry = $this->db->query("INSERT INTO `admin` (`admin_opts`, `option_title`, `option_data`) 
            VALUES
            (7, 'enable_joining', 'no');");

        $auto_auth_qry = $this->db->query("INSERT INTO `admin` (`admin_opts`, `option_title`, `option_data`) 
            VALUES
            (8, 'auto_auth', 'off');");
        
        $this->add_admin_db_opts($db_array);
        
        if(!$master_qry && !$adv_acc_qry)
        {
            return false;
        }
    }

    function add_admin_db_opts($db_array)
    {
        $qry = $this->db->query("INSERT INTO `admin` (`admin_opts`, `option_title`, `option_data`) 
            VALUES
            (6, 'db_info', '[".$db_array['db_uname'].", ".$db_array['db_password'].", ".$db_array['db_name']."]');");
        
        if(!$qry)
        {
            return false;
        }
    }

    function connected_to($system)
    {
        $qry = $this->db->query("INSERT INTO `admin` (`admin_opts`, `option_title`, `option_data`) 
            VALUES
            (4, 'front_end_framework', '".$system."');");
        
        if(!$qry)
        {
            return false;
        }
    }

    function is_connected_to()
    {
        $qry = $this->db->query("SELECT * FROM admin WHERE options_data = 'atomic'");
        
        if($qry)
        {
            return $qry->result();
        }
    }

    function get_db_info()
    {
        $qry = $this->db->query("SELECT * FROM admin WHERE admin_opts = 6");
        
        if($qry)
        {
            return $qry->result();
        }
    }

/* Img Details
***************************************************************/

    function add_img_table()
    {
        $this->load->dbforge();
        $this->dbforge->add_field("`img_id` INT(14) NOT NULL AUTO_INCREMENT");
        $this->dbforge->add_field("`img_location` VARCHAR(255) NOT NULL");
        $this->dbforge->add_field("`img_medium_location` VARCHAR(255) NOT NULL");
        $this->dbforge->add_field("`img_thumb_location` VARCHAR(255) NOT NULL");
        $this->dbforge->add_field("`img_collection` INT(14) NOT NULL");
        $this->dbforge->add_field("`favorite` int(2) NOT NULL DEFAULT '0'");
        $this->dbforge->add_field("`img_alt_tag` varchar(255) NOT NULL");
        $this->dbforge->add_field("`img_title_tag` varchar(255) NOT NULL");

        $this->dbforge->add_key('img_id', TRUE);
        $qry = $this->dbforge->create_table('img', TRUE);

        $this->load->dbforge();
        $this->dbforge->add_field("`collection_id` INT(14) NOT NULL AUTO_INCREMENT");
        $this->dbforge->add_field("`collection_name` VARCHAR(255) NOT NULL");

        $this->dbforge->add_key('collection_id', TRUE);
        $qry = $this->dbforge->create_table('img_collections', TRUE);

        if(!$qry)
        {
            return false;
        }
    }

/* Edit Setup
***************************************************************/

    function edit_account_config($avdAccounts)
    {
        $qry = $this->db->query("UPDATE 
                            `admin` 
                            SET 
                            `option_data`= '".$avdAccounts."' 
                            WHERE `admin_opts`= 1");

        if($avdAccounts === 'advanced accounts')
        {
            $this->db->query("ALTER TABLE `users` ADD `address` VARCHAR( 250 ) NOT NULL");
            $this->db->query("ALTER TABLE `users` ADD `city` VARCHAR( 250 ) NOT NULL");
            $this->db->query("ALTER TABLE `users` ADD `state` VARCHAR( 250 ) NOT NULL");
            $this->db->query("ALTER TABLE `users` ADD `country` VARCHAR( 250 ) NOT NULL");
            $this->db->query("ALTER TABLE `users` ADD `phone` VARCHAR( 250 ) NOT NULL");
            $this->db->query("ALTER TABLE `users` ADD `fax` VARCHAR( 250 ) NOT NULL");
            $this->db->query("ALTER TABLE `users` ADD `website` VARCHAR( 250 ) NOT NULL");
            $this->db->query("ALTER TABLE `users` ADD `company` VARCHAR( 250 ) NOT NULL");
        }
        
        if(!$qry)
        {
            return false;
        }
    }

    function edit_master_access_config($masterAccess)
    {
        $qry = $this->db->query("UPDATE 
                            `admin` 
                            SET 
                            `option_data`= '".$masterAccess."' 
                            WHERE `admin_opts`= 3");
        if(!$qry)
        {
            return false;
        }
    }

    function edit_joining_config($joining)
    {
        $qry = $this->db->query("UPDATE 
                            `admin` 
                            SET 
                            `option_data`= '".$joining."' 
                            WHERE `admin_opts`= 7");
        if(!$qry)
        {
            return false;
        }
    }

    function edit_auto_auth_config($auto_auth)
    {
        $qry = $this->db->query("UPDATE 
                            `admin` 
                            SET 
                            `option_data`= '".$auto_auth."' 
                            WHERE `admin_opts`= 8");
        if(!$qry)
        {
            return false;
        }
    }

}

// End of File

?>