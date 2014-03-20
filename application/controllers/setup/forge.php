<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

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

class Forge extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        $with_tables = true;

        if ($this->quarx->is_installed($with_tables))
        {
            redirect('login');
        }

        if ($_SERVER['HTTP_REFERER'] !== site_url("setup/install"))
        {
            redirect('setup/install');
        }
    }

    /**
     * Connect to the database
     * @return redirect
     */
    public function index()
    {
        $this->load->model('model_setup');
        $this->load->helper('file');

        $username = $this->input->post('db_uname');
        $password = $this->input->post('db_password');
        $database = $this->input->post('db_name');

        if ($username == "" || $password == "")
        {
            $this->session->set_flashdata('error', 'You\'re missing certain credentials.');
            redirect("setup/error");
        }

        $db_path = './application/config/database.php';

        $db_file = file_get_contents($db_path);
        $db_file = str_replace("{username}", $username, $db_file);
        $db_file = str_replace("{password}", $password, $db_file);
        $db_file = str_replace("{database}", $database, $db_file);

        if ( ! file_put_contents($db_path, $db_file))
        {
            $this->session->set_flashdata('error', 'Unable to set up the database. Please recheck your information and try agian.');
            redirect("setup/error");
        }
        else
        {
            $this->load->database('default');

            $db_array = array(
                "db_uname" => $username,
                "db_password" => $password,
                "db_name" => $database
            );

            $this->session->set_userdata("db_array", $db_array);

            redirect('setup/user');
        }
    }

}

/* End of file Forge.php */
/* Location: ./application/controllers/setup */