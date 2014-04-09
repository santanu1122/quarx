<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

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

class User_tools {

    public function getUserName($id)
    {
        $CI =& get_instance();
        $CI->load->model('model_users');

        $query = $CI->model_users->get_this_user($id);
        $res = $query->username;

        return $res;
    }

    public function getUserEmail($id)
    {
        $CI =& get_instance();
        $CI->load->model('model_users');

        $query = $CI->model_users->get_this_user($id);
        $res = $query->email;

        return $res;
    }

    public function getUserNotificationSettings()
    {
        $CI =& get_instance();
        $CI->load->model('model_users');

        $query = $CI->model_users->get_notifications_setting();

        if ($CI->session->userdata("logged_in"))
        {
            if ($query[0]->setting_data == 1) return true;

            return false;
        }

        return true;
    }
}

//End of File
?>