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
 * @link        http://quarx.ottacon.co
 * @since       Version 1.0
 * 
 */
     
class Connect_to_atomic extends CI_Controller {

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

        $db_file = str_replace("{username}", $db_info[0]->db_uname, $db_file);
        $db_file = str_replace("{password}", $db_info[0]->db_password, $db_file);
        $db_file = str_replace("{database}", $db_info[0]->db_uname.'_'.$db_info[0]->db_name, $db_file);

        if ( ! file_put_contents($db_path, $db_file) )
        {
            redirect('setup/master?e');
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