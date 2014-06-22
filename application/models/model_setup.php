<?php

/**
 * Quarx
 *
 * A modular application structure built on CodeIgniter
 *
 * @package     Quarx
 * @author      Matt Lantz
 * @copyright   Copyright (c) 2013 - 2014 Matt Lantz
 * @license     https://ottacon.co/docs/quarx/license.html
 * @link        https://github.com/mlantz/quarx
 * @since       Version 1.0
 *
 */

class Model_setup extends CI_Model {

    /**
     * Check if database is installed
     *
     * @return boolean
     */
    public function is_installed($with_tables)
    {
        if (is_null($with_tables) && !$this->load->database("default", TRUE)->conn_id) return false;

        return true;
    }

    /**
     * Get current Quarx version
     * @return string
     */
    public function current_version()
    {
        $this->db->select();
        $this->db->get("admin");
        $qry = $this->db->where("admin_opts", 5);

        if ($qry) return $qry->result();
    }

    /**
     * Update the quarx version
     * @param  string $ver
     * @return boolean
     */
    public function update_version($ver)
    {
        $qry = $this->db->query("UPDATE admin SET option_title = '".$ver."' WHERE admin_opts = 5");

        if (!$qry) return false;

        return true;
    }

    /**
     * For the user table
     * @param bool $extras
     */
    public function add_user_table($extras)
    {
        $this->load->dbforge();

        $this->dbforge->add_field("`id` INT(14) NOT NULL auto_increment");
        $this->dbforge->add_field("`username` VARCHAR(160) NOT NULL");
        $this->dbforge->add_field("`password` VARCHAR(160) NOT NULL");
        $this->dbforge->add_field("`email` VARCHAR(255) NOT NULL");
        $this->dbforge->add_field("`permission` INT(2) NOT NULL");
        $this->dbforge->add_field("`owner` INT(14) NOT NULL");
        $this->dbforge->add_field("`account_status` VARCHAR(40) NOT NULL");
        $this->dbforge->add_field("`full_name` VARCHAR(255) NOT NULL");

        if ($extras === true)
        {
            $this->dbforge->add_field("`phone` VARCHAR(150) NOT NULL");
            $this->dbforge->add_field("`fax` VARCHAR(150) NOT NULL");
            $this->dbforge->add_field("`address` VARCHAR(255) NOT NULL");
            $this->dbforge->add_field("`city` VARCHAR(155) NOT NULL");
            $this->dbforge->add_field("`state_prov` VARCHAR(155) NOT NULL");
            $this->dbforge->add_field("`country` VARCHAR(155) NOT NULL");
            $this->dbforge->add_field("`website` VARCHAR(255) NOT NULL");
            $this->dbforge->add_field("`company` VARCHAR(255) NOT NULL");
        }

        $this->dbforge->add_field("`img` VARCHAR(255) NOT NULL default 'default.jpg'");
        $this->dbforge->add_field("`location` VARCHAR(255) NOT NULL");
        $this->dbforge->add_field("`last_login` DATE NOT NULL");
        $this->dbforge->add_field("`login_counter` INT(10) NOT NULL");
        $this->dbforge->add_field("`lat` decimal(9,6) NOT NULL");
        $this->dbforge->add_field("`lng` decimal(9,6) NOT NULL");

        $this->dbforge->add_key('id', TRUE);
        $qry = $this->dbforge->create_table('users', TRUE);

        $this->db->query("CREATE UNIQUE INDEX `username` ON users (`username`)");

        $this->add_settings_table();

        if (!$qry) return false;
    }

    /**
     * Build the settings table
     */
    public function add_settings_table()
    {
        $this->load->dbforge();

        $this->dbforge->add_field("`setting_id` INT(14) NOT NULL AUTO_INCREMENT");
        $this->dbforge->add_field("`user_id` INT(14) NOT NULL");
        $this->dbforge->add_field("`setting_title` VARCHAR(80) NOT NULL");
        $this->dbforge->add_field("`setting_data` VARCHAR(255) NOT NULL");

        $this->dbforge->add_key('setting_id', TRUE);
        $qry = $this->dbforge->create_table('settings', TRUE);

        return $qry;
    }

    /**
     * Add the master user
     *
     * @param string $username
     * @param string $userpass
     */
    public function add_master_user($username, $password)
    {
        $data = array(
            'id' => 1,
            'username' => $username,
            'password' => hash("sha256", $password),
            'email' => '',
            'permission' => 1,
            'full_name' => '',
            'img' => site_url().'uploads/img/thumb/default.jpg',
            'location' => '',
            'lat' => 0.000000,
            'lng' => 0.000000,
            'account_status' => 'enabled'
        );

        $this->db->insert('users', $data);

        $settings_data = array(
            'user_id' => 1,
            'setting_title' => "notifications",
            'setting_data' => "1"
        );

        $this->db->insert('settings', $settings_data);

        return true;
    }

    /**
     * Dont't forget the admin table
     */
    public function add_admin_table()
    {
        $this->load->dbforge();

        $this->dbforge->add_field("`admin_opts` INT(14) NOT NULL AUTO_INCREMENT");
        $this->dbforge->add_field("`option_title` VARCHAR(80) NOT NULL");
        $this->dbforge->add_field("`option_data` VARCHAR(255) NOT NULL");

        $this->dbforge->add_key('admin_opts', TRUE);
        $qry = $this->dbforge->create_table('admin', TRUE);

        return $qry;
    }

    /**
     * Add the admin options
     *
     * @param string $avdAccounts
     * @param string $master
     * @param string $version
     * @param string $db_array
     */
    public function add_admin_opts($avdAccounts, $master, $version, $db_array)
    {
        $adv_acc_data = array(
            'admin_opts' => 1,
            'option_title' => 'account_type',
            'option_data' => $avdAccounts
        );

        $adv_acc_qry = $this->db->insert('admin', $adv_acc_data);

        $master_data = array(
            'admin_opts' => 3,
            'option_title' => 'access_type',
            'option_data' => $master
        );

        $master_qry = $this->db->insert('admin', $master_data);

        $version_data = array(
            'admin_opts' => 5,
            'option_title' => 'quarx_version',
            'option_data' => $version
        );

        $version_qry = $this->db->insert('admin', $version_data);

        $joining_data = array(
            'admin_opts' => 7,
            'option_title' => 'enable_joining',
            'option_data' => 'no'
        );

        $joining_qry = $this->db->insert('admin', $joining_data);

        $auto_auth_data = array(
            'admin_opts' => 8,
            'option_title' => 'auto_auth',
            'option_data' => 'off'
        );

        $auto_auth_qry = $this->db->insert('admin', $auto_auth_data);

        $this->add_admin_db_opts($db_array);

        if(!$master_qry && !$adv_acc_qry)
        {
            return false;
        }
    }

    /**
     * Add the admin db opt
     * @param array $db_array
     */
    public function add_admin_db_opts($db_array)
    {
        $data = array(
            'admin_opts' => 6,
            'option_title' => 'db_info',
            'option_data' => json_encode(array($db_array['db_uname'], $db_array['db_password'], $db_array['db_name']))
        );

        return $this->db->insert('admin', $data);
    }

    /**
     * Connect to the database
     * @param  string $system
     * @return boolean
     */
    public function connected_to($system)
    {
        $data = array(
            'admin_opts' => 4,
            'option_title' => 'front_end_framework',
            'option_data' => $system
        );

        $this->db->insert('admin', $data);
    }

    /**
     * Check if connection exists
     *
     * @return boolean
     */
    public function is_connected_to()
    {
        $this->db->select();
        $this->db->get("admin");
        $qry = $this->db->where("admin", 4);

        return $qry->result();
    }

    /**
     * Get database info
     *
     * @return array
     */
    public function get_db_info()
    {
        $this->db->select();
        $this->db->get("admin");
        $qry = $this->db->where("admin", 6);

        return $qry->result();
    }

    /**
     * Create the img table
     */
    public function add_img_table()
    {
        $this->load->dbforge();

        $this->dbforge->add_field("`img_id` INT(14) NOT NULL AUTO_INCREMENT");
        $this->dbforge->add_field("`img_location` VARCHAR(255) NOT NULL");
        $this->dbforge->add_field("`img_medium_location` VARCHAR(255) NOT NULL");
        $this->dbforge->add_field("`img_thumb_location` VARCHAR(255) NOT NULL");
        $this->dbforge->add_field("`img_collection` INT(14) NOT NULL");
        $this->dbforge->add_field("`collection_order` int(14) NOT NULL");
        $this->dbforge->add_field("`favorite` int(2) NOT NULL DEFAULT '0'");
        $this->dbforge->add_field("`published` int(2) NOT NULL DEFAULT '1'");
        $this->dbforge->add_field("`original_name` varchar(255) NOT NULL DEFAULT 'undefined'");
        $this->dbforge->add_field("`img_alt_tag` varchar(255) NOT NULL");
        $this->dbforge->add_field("`img_title_tag` varchar(255) NOT NULL");
        $this->dbforge->add_key('img_id', TRUE);

        $img_table_qry = $this->dbforge->create_table('img', TRUE);

        $this->dbforge->add_field("`collection_id` INT(14) NOT NULL AUTO_INCREMENT");
        $this->dbforge->add_field("`collection_name` VARCHAR(255) NOT NULL");
        $this->dbforge->add_key('collection_id', TRUE);

        $img_collection_table_qry = $this->dbforge->create_table('img_collections', TRUE);

        $this->dbforge->add_field("`file_id` INT(14) NOT NULL AUTO_INCREMENT");
        $this->dbforge->add_field("`file_location` VARCHAR(255) NOT NULL");
        $this->dbforge->add_field("`file_name` VARCHAR(255) NOT NULL");
        $this->dbforge->add_field("`file_original_name` VARCHAR(255) NOT NULL");
        $this->dbforge->add_key('file_id', TRUE);

        $file_table_qry = $this->dbforge->create_table('files', TRUE);

        if(!$img_table_qry || !$img_collection_table_qry || !$file_table_qry)
        {
            return false;
        }
    }

    public function edit_config($value, $type)
    {
        $data = array(
            'option_data' => $value
        );

        switch ($type) {
            case 'accounts':
                $admin_opt = 1;
                if ($value == 'advanced accounts') $this->edit_account_config();
                break;

            case 'access':
                $admin_opt = 3;
                break;

            case 'joining':
                $admin_opt = 7;
                break;

            case 'auth':
                $admin_opt = 8;
                break;
        }

        $this->db->where('admin_opts', $admin_opt);
        return $this->db->update('admin', $data);
    }

    private function edit_account_config()
    {
        $this->db->query("ALTER TABLE `users` ADD `address` VARCHAR( 250 ) NOT NULL");
        $this->db->query("ALTER TABLE `users` ADD `city` VARCHAR( 250 ) NOT NULL");
        $this->db->query("ALTER TABLE `users` ADD `state` VARCHAR( 250 ) NOT NULL");
        $this->db->query("ALTER TABLE `users` ADD `country` VARCHAR( 250 ) NOT NULL");
        $this->db->query("ALTER TABLE `users` ADD `phone` VARCHAR( 250 ) NOT NULL");
        $this->db->query("ALTER TABLE `users` ADD `fax` VARCHAR( 250 ) NOT NULL");
        $this->db->query("ALTER TABLE `users` ADD `website` VARCHAR( 250 ) NOT NULL");
        $this->db->query("ALTER TABLE `users` ADD `company` VARCHAR( 250 ) NOT NULL");

        return true;
    }

}

// End of File

?>