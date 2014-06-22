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

class Model_login extends CI_Model {

    public function validate()
    {
        $username = $this->input->post("username");
        $password = $this->input->post("password");

        return $this->do_login($username, $password);
    }

    public function cookie_validate($username, $password)
    {
        return $this->do_login($username, $password);
    }

    public function user_validate()
    {
        $this->db->where('username', $this->input->post('username'));
        $this->db->where('email', $this->input->post('email'));
        $query = $this->db->get('users');

        if (is_bool($query)) return false;
        if ($query->num_rows() == 1) return true;
    }

    public function new_password($username, $email)
    {
        $rand = substr(sha1(rand(10000001,99999999)), 0, 20);
        $hashed = hash("sha256", $rand);

        $data = array(
            'password' => $hashed
        );

        $this->db->where('username', $username);
        $this->db->where('email', $email);
        $this->db->update('users', $data);

        return $rand;
    }

    /*
    |--------------------------------------------------------------------------
    | Private Methods
    |--------------------------------------------------------------------------
    */

    public function do_login($username, $password)
    {
        $this->db->where('username', $username);
        $this->db->where('password', hash("sha256", $password));
        $query = $this->db->get('users');

        $user_result = $query->result();

        if (empty($user_result)) return false;

        $user = $user_result[0];

        if ($user->account_status == "enabled")
        {
            $data = array(
                'last_login' => date('Y-m-d h:i:s')
            );

            $this->db->where('username', $username);
            $this->db->where('password', hash("sha256", $password));

            $this->db->update('users', $data);
        }

        return $user;
    }
}

// End of File

?>