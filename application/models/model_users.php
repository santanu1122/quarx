<?php

/**
 * Quarx
 *
 * A modular CMS application
 *
 * @package     Quarx
 * @author      Matt Lantz
 * @copyright   Copyright (c) 2013 Matt Lantz
 * @license     http://ottacon.co/quarx/license.html
 * @link        http://ottacon.co/quarx
 * @since       Version 1.0
 *
 */

class Model_users extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    public function my_profile()
    {
        $this->db->where('id', $this->session->userdata("user_id"));
        $my_profile = $this->db->get('users')->result();

        return $my_profile[0];
    }

    public function unc_validate($name)
    {
        if ( ! $name) return 0;

        $this->db->where('username', $name);
        $query = $this->db->get('users');

        $unc_validity = ($query->num_rows() >= 1 ? 1 : 0);

        return $unc_validity;
    }

    public function get_this_user($id)
    {
        $this->db->where('id', $id);
        $profile = $this->db->get('users')->result();

        return $profile[0] ?: null;
    }

    public function settings_update()
    {
        $data = array(
            "setting_data" => $this->input->post("quarxNotificationSetting")
        );

        $this->db->where("user_id", $this->session->userdata("user_id"));
        $this->db->where("setting_title", "notifications");
        $this->db->update('settings', $data);

        return true;
    }

    public function get_notifications_setting()
    {
        $this->db->where("user_id", $this->session->userdata("user_id"));
        $this->db->where("setting_title", "notifications");
        return $this->db->get("settings")->result();
    }

    public function profile_update($img = null)
    {
        $data = array(
            'email' => $this->input->post('email'),
            'full_name' => $this->input->post('full_name'),
            'location' => $this->input->post('location'),
            'lat' => $this->input->post('latitude'),
            'lng' => $this->input->post('longitude')
        );

        if ($this->quarx->get_option("account_type") == 'advanced accounts')
        {
            $data['address'] = $this->input->post('address');
            $data['city'] = $this->input->post('city');
            $data['state'] = $this->input->post('state_prov');
            $data['country'] = $this->input->post('country');
            $data['phone'] = $this->input->post('phone');
            $data['fax'] = $this->input->post('fax');
            $data['website'] = $this->input->post('website');
            $data['company'] = $this->input->post('company');
        }

        if ( ! is_null($img))
        {
            $data['img'] = $img;
        }

        $this->db->where('id', $this->session->userdata("user_id"));
        $update = $this->db->update('users', $data);

        if ($update)
        {
            $this->session->set_userdata('email', $this->db->escape_str($this->input->post('email')));
            return true;
        }

        return false;
    }

    public function user_profile_update($img, $id)
    {
        $data = array(
            'email' => $this->input->post('email'),
            'full_name' => $this->input->post('full_name'),
            'location' => $this->input->post('location'),
            'lat' => $this->input->post('latitude'),
            'lng' => $this->input->post('longitude')
        );

        if ($this->quarx->get_option("account_type") == 'advanced accounts')
        {
            $data['address'] = $this->input->post('address');
            $data['city'] = $this->input->post('city');
            $data['state'] = $this->input->post('state_prov');
            $data['country'] = $this->input->post('country');
            $data['phone'] = $this->input->post('phone');
            $data['fax'] = $this->input->post('fax');
            $data['website'] = $this->input->post('website');
            $data['company'] = $this->input->post('company');
        }

        if ( ! is_null($img))
        {
            $data['img'] = $img;
        }

        $this->db->where('id', $id);
        $update = $this->db->update('users', $data);

        if ($update)
        {
            $this->session->set_userdata('email', $this->db->escape_str($this->input->post('email')));
            return true;
        }

        return false;
    }

    public function change_password()
    {
        $data = array(
            'password' => hash("sha256", $this->input->post('password'))
        );

        $this->db->where('id', $this->session->userdata("user_id"));
        $this->db->update('users', $data);

        if ($this->db->affected_rows() == 0) return false;
        return true;
    }

    public function username_checker()
    {
        if ($this->input->post("username") == '') return false;

        $this->db->where("username", $this->input->post('username'));
        $qry = $this->db->get("users");

        return (is_array($qry->result()) ? true : false);
    }

    public function add_profile($img, $password = null, $auto_auth = "off")
    {
        $permission = 2;
        $optional_inserts = '';
        $optional_vals = '';

        $rand = (is_null($password) ? substr(sha1(rand(10000001,99999999)), 0, 20) : $password);

        $password = hash("sha256", $rand);

        $data = array(
            'username' => $this->input->post('username'),
            'password' => $password,
            'email' => $this->input->post('email'),
            'full_name' => $this->input->post('full_name'),
            'location' => $this->input->post('location'),
            'permission' => 2,
            'lat' => $this->input->post('latitude') ?: "0.000000",
            'lng' => $this->input->post('longitude') ?: "0.000000"
        );

        $account_status = ($auto_auth == "on") ? "enabled" : "inactive";

        $data['account_status'] = $account_status;

        if ($this->quarx->get_option("account_type") == 'advanced accounts')
        {
            $data['address'] = $this->input->post('address') ?: "";
            $data['city'] = $this->input->post('city') ?: "";
            $data['state'] = $this->input->post('state_prov') ?: "";
            $data['country'] = $this->input->post('country') ?: "";
            $data['phone'] = $this->input->post('phone') ?: "";
            $data['fax'] = $this->input->post('fax') ?: "";
            $data['website'] = $this->input->post('website') ?: "";
            $data['company'] = $this->input->post('company') ?: "";
        }

        if ( ! is_null($img)) $data['img'] = $img;
        else $data['img'] = site_url()."uploads/img/thumb/default.jpg";

        $user = $this->db->insert('users', $data);

        $settings_data = array(
            'user_id' => $this->db->insert_id(),
            'setting_title' => "notifications",
            'setting_data' => "1"
        );

        $settings = $this->db->insert('settings', $settings_data);

        if (!$user || !$settings) return false;

        return $rand;
    }

    public function profile_deleter($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('users');

        return true;
    }

    public function search_accounts($name)
    {
        $this->db->like('username', $name);
        $qry = $this->db->get("users");

        return $qry->result();
    }

    public function search_accounts_full($term, $offset = null, $limit = null)
    {
        if ($offset == null) $offset = 0;

        $user_id = $this->session->userdata("user_id");
        $cleaned_term = $this->db->escape_str($term);

        if ($this->session->userdata("user_id") != 1)
        {
            $amster_user = "AND owner = {$user_id}";
        }

        $sql = "SELECT    *
                FROM      users
                WHERE     username   LIKE '%{$cleaned_term}%' AND id != 1 {$master_user}
                OR        full_name  LIKE '%{$cleaned_term}%' AND id != 1 {$master_user}
                OR        location   LIKE '%{$cleaned_term}%' AND id != 1 {$master_user}
                ORDER BY  full_name DESC
                LIMIT     {$offset}, {$limit}";

        return $this->db->query($sql)->result();
    }

    public function full_search_totals($term)
    {
        $user_id = $this->session->userdata("user_id");
        $cleaned_term = $this->db->escape_str($term);

        if ($this->session->userdata("user_id") != 1)
        {
            $amster_user = "AND owner = {$user_id}";
        }

        $sql = "SELECT    *
                FROM      users
                WHERE     username   LIKE '%{$cleaned_term}%' AND id != 1 {$master_user}
                OR        full_name  LIKE '%{$cleaned_term}%' AND id != 1 {$master_user}
                OR        location   LIKE '%{$cleaned_term}%' AND id != 1 {$master_user}
                ORDER BY  full_name DESC";

        return $this->db->query($sql)->num_rows();
    }

    public function set_user_profile($id, $field)
    {
        switch ($field) {
            case 'authorize':
                $data['account_status'] = "enabled";
                break;

            case 'enable':
                $data['account_status'] = "enabled";
                break;

            case 'disable':
                $data['account_status'] = "disabled";
                break;

            case 'master':
                $data['permission'] = 1;
                break;

            case 'standard':
                $data['permission'] = 2;
                break;
        }

        $this->db->where('id', $id);
        $this->db->update('users', $data);

        if ($this->db->affected_rows() == 0) return false;
        return true;
    }

/*
|--------------------------------------------------------------------------
| GETS
|--------------------------------------------------------------------------
*/

    public function get_a_name($id)
    {
        $this->db->where("id", $id);
        $this->db->order_by("username");
        $this->db->limit(1);
        return $this->db->get("users")->result();
    }

    public function all_profiles($offset = null, $limit = null)
    {
        if ($offset == null) $offset = 0;

        $offset = $this->db->escape_str($offset);
        $limit = $this->db->escape_str($limit);

        $permission = "WHERE permission > 1";
        $owner = 'AND owner = '.$this->session->userdata('user_id');

        if ($this->session->userdata('user_id') == 1)
        {
            $permission = "WHERE permission >= 1";
            $owner = 'AND id != 1';
        }

        $sql = "SELECT *
                FROM `users`
                {$permission}
                {$owner}
                ORDER BY username ASC LIMIT {$offset}, {$limit}";

        $qry = $this->db->query($sql);

        return $qry->result();
    }

    public function all_profiles_unlimited()
    {
        $this->db->where("permission >=", 1);
        $qry = $this->$this->db->get('users');

        return $qry->result();
    }

    public function all_profiles_tally()
    {

        $this->db->where("permission >=", 1);
        $qry = $this->db->get('users');

        return count($qry->result());
    }
}

// End of File
?>