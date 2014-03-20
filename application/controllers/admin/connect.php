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

class Connect extends CI_Controller {

    function __construct()
    {
        parent::__construct();

        if (!$this->session->userdata('logged_in'))
        {
            redirect('error/login'); // Denied!
        }

        if ($this->session->userdata('user_id') != 1)
        {
            $this->session->set_flashdata('error', 'You do not have sufficient permission to access this');
            redirect('error');
        }

        $this->lang->load(config_item('language_abbr'), config_item('language'));
    }

    public function index()
    {
        $this->load->model('model_setup');
        $db_info = $this->model_setup->get_db_info();

        $db_path = '../application/config/database.php';
        $db_file = file_get_contents($db_path);

        $dbs = $db_info[0]->option_data;
        $dbs = substr($dbs, 1, (strlen($dbs)-2));
        $dbs = explode(",", $dbs);

        if ($dbs[0] == "sqlite" && $dbs[1] == "pdo")
        {
            $db_file = str_replace("{username}", "", $db_file);
            $db_file = str_replace("{password}", "", $db_file);
            $db_file = str_replace("{database}", "", $db_file);

            $db_file = str_replace("localhost", trim($dbs[0]), $db_file);
            $db_file = str_replace("mysql", "pdo", $db_file);
        }
        else
        {
            $db_file = str_replace("{username}", trim($dbs[0]), $db_file);
            $db_file = str_replace("{password}", trim($dbs[1]), $db_file);
            $db_file = str_replace("{database}", trim($dbs[0]).'_'.trim($dbs[2]), $db_file);
        }

        $message = array("error", "Your connection to atomic was not successful");

        if (file_put_contents($db_path, $db_file) )
        {
            $this->model_setup->connected_to("atomic");
            $message = array("success", "Your connection to atomic was successful");
        }

        $this->session->set_flashdata('message', $message);
        redirect('admin');

    }

}
/* End of file connect_to_atomic.php */
/* Location: ./application/controllers/ */