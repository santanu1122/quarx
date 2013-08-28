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
     
class connect_to_atomic extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->model('modelsetup');
        $qry = $this->modelsetup->is_installed();

        if(!$qry)
        {
            redirect('setup/install');
        }
    }

/* Connect to Atomic
***************************************************************/

    public function index() 
    { 
        $this->load->model('modelsetup');
        $db_info = $this->modelsetup->get_db_info();

        $db_path = '../application/config/database.php';
        $db_file = file_get_contents($db_path);

        $dbs = $db_info[0]->option_data;
        $dbs = substr($dbs, 1, (strlen($dbs)-2));
        $dbs = explode(",", $dbs);

        $db_file = str_replace("{username}", trim($dbs[0]), $db_file);
        $db_file = str_replace("{password}", trim($dbs[1]), $db_file);
        $db_file = str_replace("{database}", trim($dbs[0]).'_'.trim($dbs[2]), $db_file);

        if ( ! file_put_contents($db_path, $db_file) )
        {
            $this->session->set_flashdata('error', 'Your connection to atomic was not successful');
            redirect('setup/master');
        }
        else
        {
            $this->modelsetup->connected_to("atomic");
            $this->session->set_flashdata('success', 'Your connection to atomic was successful');
            redirect('setup/master');
        }

    }

}
/* End of file connect_to_atomic.php */
/* Location: ./application/controllers/ */