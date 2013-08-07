<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Quarx
 *
 * A modular CMS built on CodeIgniter
 *
 * @package     Quarx
 * @author      Matt Lantz
 * @copyright   Copyright (c) 2013 Matt Lantz
 * @license     http://ottacon.co/quarx/license
 * @link        http://ottacon.co/quarx/
 * @since       Version 1.0
 * 
 */
     
class DB_connect extends CI_Controller {

    function __construct()
    {
        parent::__construct();

        if($_SERVER['HTTP_REFERER'] !== site_url("setup/install"))
        {
            redirect('setup/install');
        }
    }

/* Initial Setup and Install
***************************************************************/

    public function index() 
    {
        $this->load->model('modelsetup');
        $this->load->helper('file');

        $name = $this->input->post('db_uname');
        $password = $this->input->post('db_password');

        $db_path = './application/config/database.php';
        $db_file = file_get_contents($db_path);

        $db_file = str_replace("{username}", $name, $db_file);
        $db_file = str_replace("{password}", $password, $db_file);

        if ( ! file_put_contents($db_path, $db_file) )
        {     
             echo 'Unable to set up the database. Please recheck your information and try agian.';
        }
        else
        {
            $db = $this->input->post('db_name');
            redirect("setup/db_connect/connect/".encrypt($name)."/".encrypt($password)."/".encrypt($db));
        }
    }

    public function connect($name, $pword, $db) 
    {
        $this->load->model('modelsetup');

        $username = decrypt($name); 
        $password = decrypt($pword); 
        $database = decrypt($db);

        $query = $this->modelsetup->createdb($username, $database);

        $db_exists = $this->modelsetup->find_db( $username, $password, $username.'_'.$database );

        if(!$query)
        {
            if($db_exists)
            {
                $this->session->set_flashdata('error', 'You need to manually add your database due to a lack of permission or incorrect credentials, sorry...');
                redirect('setup/error');
            }

            echo "Sorry, we are unable to forge your database.";
            exit;
        }
    
        $db_path = './application/config/database.php';
        $db_file = file_get_contents($db_path);

        $db_file = str_replace("{database}", $username.'_'.$database, $db_file);

        if ( ! file_put_contents($db_path, $db_file) )
        {
            echo 'Unable to set up the database. Please recheck your information and try agian.';
        }
        else
        {
            $db_array = array(
                "db_uname" => $username,
                "db_password" => $password,
                "db_name" => $database
            );

            $this->session->set_userdata("db_array", $db_array);

            @unlink('index.html');

            redirect('setup/user');
        }
    }
}

/* End of file db_complete.php */
/* Location: ./application/controllers/setup */