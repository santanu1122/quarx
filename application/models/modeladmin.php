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

class modeladmin extends CI_Model {

    function account_opts() 
    {
        $qry = $this->db->query("SELECT * FROM `admin`");
        $res = $qry->result();
        return $res;
    }

    function get_opt($opt) 
    {
        $qry = $this->db->query("SELECT * FROM `admin` WHERE option_title = '".$opt."'");
        $res = $qry->result();
        if($res){
            return $res[0]->option_data;
        }
    }

    function get_db_info() 
    {
        $qry = $this->db->query("SELECT * FROM `admin` WHERE admin_opts = 6");
        $res = $qry->result();
        return $res[0];
    }

    function get_permissions()
    {
        $qry = $this->db->query("SELECT * FROM `admin` WHERE admin_opts = 3");
        $res = $qry->result();
        return $res[0];
    }

}

// End of File

?>