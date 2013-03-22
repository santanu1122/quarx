<?php

/*
    Filename:   modeladmin.php
    Location:   /application/models/
*/

class modeladmin extends CI_Model {
    
// admin options ==========================================================

    function account_opts() {
        $qry = $this->db->query("SELECT * FROM `admin`");
        $res = $qry->result();

        return $res;
    }

    function get_db_info() {
        $qry = $this->db->query("SELECT * FROM `admin` WHERE admin_opts = 2");
        $res = $qry->result();

        return $res;
    }

}

// End of File

?>