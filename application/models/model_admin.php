<?php

/**
 * Quarx
 *
 * A modular CMS application
 *
 * @package     Quarx
 * @author      Matt Lantz
 * @copyright   Copyright (c) 2013 - 2014 Matt Lantz
 * @license     https://ottacon.co/docs/quarx/license.html
 * @link        https://github.com/mlantz/quarx
 * @since       Version 1.0
 *
 */

class Model_admin extends CI_Model {

    public function account_opts()
    {
        return $this->db->get("admin")->result();
    }

    public function get_opt($opt)
    {
        $this->db->where("option_title", $opt);
        $qry = $this->db->get("admin");
        $res = $qry->result();

        if ($res) return $res[0]->option_data;
    }

    public function get_db_info()
    {
        $this->db->where("option_title", "db_info");

        $res = $this->db->get("admin")->result();
        return $res[0];
    }

    public function get_permissions()
    {
        $this->db->where("option_title", "access_type");

        $res = $this->db->get("admin")->result();
        return $res[0];
    }

}

// End of File

?>