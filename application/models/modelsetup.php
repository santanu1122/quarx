<?php

/*
    Filename:   modelsetup.php
    Location:   /application/models/
*/

class modelsetup extends CI_Model {

/* Create Database
***************************************************************/

function connect_to_db($user, $pass){
    $db_connect = mysql_connect('localhost', $user, $pass);

    if(!$db_connect){
        return false;
    }else{
        return true;
    }
}

function createdb($user, $name){
    $qry = mysql_query("CREATE DATABASE `".$user."_".$name."`");
    if(!$qry){
        return false;
    }else{
        return true;
    }
}

function find_db($user, $pass, $name){
    $db_connect = mysql_connect('localhost', $user, $pass);
    $qry = mysql_select_db($name, $db_connect);

    if(!$qry){
        return false;
    }else{
        return true;
    }
}

function current_version(){
    $qry = $this->db->query("SELECT * FROM admin WHERE admin_opts = 5");
    if($qry){
        return $qry->result();
    }
}

function update_version($ver){
    $qry = $this->db->query("UPDATE admin SET option_title = '".$ver."' WHERE admin_opts = 5");
    if(!$qry){
        return false;
    }else{
        return true;
    }
}

/* Add User Details
***************************************************************/

    function add_user_table($extras) {
        if($extras === true){
            $optional = 
               '`phone` varchar(255) NOT NULL,
                `fax` varchar(255) NOT NULL,
                `address` varchar(255) NOT NULL,
                `city` varchar(255) NOT NULL,
                `state` varchar(255) NOT NULL,
                `country` varchar(255) NOT NULL,
                `website` varchar(255) NOT NULL,
                `company` varchar(255) NOT NULL,';
        }else{
            $optional = '';
        }

        $qry = mysql_query('
            CREATE TABLE `users` (
                `user_id` int(8) NOT NULL AUTO_INCREMENT,
                `user_name` varchar(40) NOT NULL,
                `user_pass` varchar(40) NOT NULL,
                `user_email` varchar(50) NOT NULL,
                `permission` int(2) NOT NULL,
                `owner` int(8) NOT NULL,
                `status` varchar(40) NOT NULL,
                `full_name` varchar(255) NOT NULL,'.
                $optional
                .'`img` varchar(255) NOT NULL DEFAULT \'default.jpg\',
                `location` varchar(255) NOT NULL,
                `lat` decimal(9,6) NOT NULL,
                `lng` decimal(9,6) NOT NULL,
                `user_state` varchar(40) NOT NULL,
                PRIMARY KEY (`user_id`),
                UNIQUE KEY `user_name` (`user_name`)
            ) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;');
        
        if(!$qry){
            return false;
        }
    }

    function add_master_user($username, $userpass){
        $qry = mysql_query("INSERT INTO `users` (`user_id`, `user_name`, `user_pass`, `user_email`, `permission`, `full_name`, `img`, `location`, `lat`, `lng`, `user_state`, `status`) 
            VALUES
            (1, '".$username."', '".sha1($userpass)."', '', 1, '', '".site_url()."uploads/img/thumb/default.jpg', '', 0.000000, 0.000000, 'enabled', 'authorized');");
        
        if(!$qry){
            return false;
        }
    }

/* Add Admin Details
***************************************************************/

    function add_admin_table() {
        $qry = mysql_query('
            CREATE TABLE `admin` (
                `admin_opts` int(8) NOT NULL AUTO_INCREMENT,
                `option_title` varchar(50) NOT NULL,
                `db_uname` varchar(50) NOT NULL,
                `db_password` varchar(50) NOT NULL,
                `db_name` varchar(50) NOT NULL,
                PRIMARY KEY (`admin_opts`)
            ) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;');
        
        if(!$qry){
            return false;
        }
    }

    function add_admin_opts($avdAccounts, $master, $version, $db_array){
        $adv_acc_qry = mysql_query("INSERT INTO `admin` (`admin_opts`, `option_title`) 
            VALUES
            (1, '".$avdAccounts."');");

        $master_qry = mysql_query("INSERT INTO `admin` (`admin_opts`, `option_title`) 
            VALUES
            (3, '".$master."');");

        $version_qry = mysql_query("INSERT INTO `admin` (`admin_opts`, `option_title`) 
            VALUES
            (5, '".$version."');");
        
        $this->add_admin_db_opts($db_array);
        
        if(!$master_qry && !$adv_acc_qry){
            return false;
        }
    }

    function add_admin_db_opts($db_array){
        $qry = mysql_query("INSERT INTO `admin` (`admin_opts`, `option_title`, `db_uname`, `db_password`, `db_name`) 
            VALUES
            (2, '".$avdAccounts."', '".$db_array['db_uname']."', '".$db_array['db_password']."', '".$db_array['db_name']."');");
        
        if(!$qry){
            return false;
        }
    }

    function connected_to($system){
        $qry = mysql_query("INSERT INTO `admin` (`admin_opts`, `option_title`) 
            VALUES
            (4, '".$system."');");
        
        if(!$qry){
            return false;
        }
    }

    function is_connected_to(){
        $qry = $this->db->query("SELECT * FROM admin WHERE option_title = 'atomic'");
        
        if($qry){
            return $qry->result();
        }
    }

    function get_db_info(){
        $qry = $this->db->query("SELECT * FROM admin WHERE admin_opts = 2");
        
        if($qry){
            return $qry->result();
        }
    }

/* Img Details
***************************************************************/

    function add_img_table() {
        $qry = mysql_query('
            CREATE TABLE `img` (
                `img_id` int(8) NOT NULL AUTO_INCREMENT,
                `img_location` varchar(250) NOT NULL,
                `img_thumb_location` varchar(250) NOT NULL,
                `category_type` varchar(40) NOT NULL,
                `img_collection` varchar(255) NOT NULL,
                `favorite` int(2) NOT NULL DEFAULT "0",
                `img_alt_tag` varchar(255) NOT NULL,
                `img_title_tag` varchar(255) NOT NULL,
                PRIMARY KEY (`img_id`)
            ) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=27 ;');

        if(!$qry){
            return false;
        }
    }

/* Plugin Details
***************************************************************/

    function add_plugin_tables() {
        $plugin_tbl_exists = mysql_query('SELECT * FROM plugins'); 
        
        if(! $plugin_tbl_exists ){
            $qry = mysql_query('
                CREATE TABLE `plugins` (
                    `plugin_id` int(8) NOT NULL AUTO_INCREMENT,
                    `plugin_name` varchar(40) NOT NULL,
                    `plugin_id_tag` int(8) NOT NULL,
                    `plugin_title` varchar(40) NOT NULL,
                    `plugin_pages` varchar(255) NOT NULL,
                    `plugin_version` varchar(40) NOT NULL,
                    `plugin_active` varchar(40) NOT NULL,
                    PRIMARY KEY (`plugin_id`)
                ) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;');
            
            if(!$qry){
                return true;
            }
        }

        $cat_tbl_exists = mysql_query('SELECT * FROM categories'); 
        
        if(! $cat_tbl_exists ){
            $cat_qry = mysql_query('
                CREATE TABLE `categories` (
                    `cat_id` int(8) NOT NULL AUTO_INCREMENT,
                    `cat_title` varchar(255) NOT NULL,
                    `cat_url_title` varchar(255) NOT NULL,
                    `cat_type` varchar(50) NOT NULL,
                    `cat_parent` int(8) NOT NULL,
                    PRIMARY KEY (`cat_id`)
                ) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3');
            
            if(!$cat_qry){
                return true;
            }
        }

        return false;
    }

    function installed_plugins() {
        $query = mysql_query('SELECT * FROM plugins');
        if($query){
            $qry = $this->db->query("SELECT * FROM plugins ORDER BY plugin_name ASC");
            return $qry->result();
        }
        
    }

    function remove_plugin_table($plugin) {
        $sql = "DELETE FROM plugins WHERE plugin_name = '".$plugin."'";
        $qry = mysql_query($sql);
        if($qry){
            $sql = "DROP TABLE ".$plugin;
            $qry = mysql_query($sql);
        }

        return true;
    }

    function disable_plugin($plugin) {
        $query = mysql_query('UPDATE `plugins` SET plugin_active = "no" WHERE plugin_name = "'.$plugin.'"');
        if($query){
            return true;
        }
    }

    function enable_plugin($plugin) {
        $query = mysql_query('UPDATE `plugins` SET plugin_active = "yes" WHERE plugin_name = "'.$plugin.'"');
        if($query){
            return true;
        }
    }

    function update_plugin($plugin, $plugin_version){
        $query = mysql_query('UPDATE `plugins` SET plugin_version = "'.$plugin_version.'" WHERE plugin_name = "'.$plugin.'"');
        if($query){
            return true;
        }
    }

/* Install Members
***************************************************************/

function install_members(){
    $qry = mysql_query("INSERT INTO `plugins` (`plugin_id_tag`, `plugin_name`, `plugin_title`, `plugin_active`) 
        VALUES
        ('0000', 'members', 'Members', 'yes');");
    
    if(!$qry){
        return false;
    }
}

/* Edit Setup
***************************************************************/

    function edit_account_config($avdAccounts){
        $qry = mysql_query("UPDATE 
                            `admin` 
                            SET 
                            `option_title`= '".$avdAccounts."' 
                            WHERE `admin_opts`= 1");

        if($avdAccounts === 'advanced accounts'){
            mysql_query("ALTER TABLE `users` ADD `address` VARCHAR( 250 ) NOT NULL");
            mysql_query("ALTER TABLE `users` ADD `city` VARCHAR( 250 ) NOT NULL");
            mysql_query("ALTER TABLE `users` ADD `state` VARCHAR( 250 ) NOT NULL");
            mysql_query("ALTER TABLE `users` ADD `country` VARCHAR( 250 ) NOT NULL");
            mysql_query("ALTER TABLE `users` ADD `phone` VARCHAR( 250 ) NOT NULL");
            mysql_query("ALTER TABLE `users` ADD `fax` VARCHAR( 250 ) NOT NULL");
            mysql_query("ALTER TABLE `users` ADD `website` VARCHAR( 250 ) NOT NULL");
            mysql_query("ALTER TABLE `users` ADD `company` VARCHAR( 250 ) NOT NULL");
        }
        
        if(!$qry){
            return false;
        }
    }

    function edit_master_access_config($masterAccess){
        $qry = mysql_query("UPDATE 
                            `admin` 
                            SET 
                            `option_title`= '".$masterAccess."' 
                            WHERE `admin_opts`= 3");
        if(!$qry){
            return false;
        }
    }

}

// End of File

?>