<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Quarx
 *
 * A modular application framework built on CodeIgniter
 *
 * @package     Quarx
 * @author      Matt Lantz
 * @copyright   Copyright (c) 2013 Matt Lantz
 * @license     http://ottacon.co/quarx/license
 * @link        http://ottacon.co/quarx
 * @since       Version 1.0
 * 
 */ 
     
class Tests extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        $this->load->library("unit");

        if(ENVIRONMENT !== "development"){
            redirect("accounts");
        }

        $this->lang->load(config_item('language_abbr'), config_item('language'));
    } 


/* Primary Tools
*****************************************************************/

    public function index()
    {  
        $data['root'] = base_url();
        $data['pageRoot'] = base_url().'index.php';
        $data['pagetitle'] = 'Unit Tests';

        $this->benchmark->mark('code_start');

        /* Place test data here:
        ***************************************************************/
        $data['tests'] .= "<div class=\"raw100 raw-left\"><h2>Quarx Tests</h2></div>";
        $data['tests'] .= $this->test_quarx_setup();
        $data['tests'] .= $this->test_quarx_version();
        $data['tests'] .= "<div class=\"raw100 raw-left\"><h2>Login Tests</h2></div>";
        $data['tests'] .= $this->test_login();
        $data['tests'] .= $this->test_disabled_account();
        /**************************************************************/

        $this->benchmark->mark('code_end');

        $data['benchmark'] = $this->benchmark->elapsed_time('code_start', 'code_end');

        $this->load->view('common/header', $data);
        $this->load->view('core/admin/tests', $data);
        $this->load->view('common/footer', $data);
    }

/* Unit Test Functions
***************************************************************/

    /* Model Setup
    *************************************/

    function test_quarx_setup(){
        $this->load->model("modelsetup");
        $res = $this->modelsetup->is_installed();
        return $this->unit->test($res, "is_obj", "Quarx is installed - object");
    }

    function test_quarx_version(){
        $this->load->model("modelsetup");
        $res = $this->modelsetup->current_version();
        return $this->unit->test($res, "is_array", "Quarx - version check - array");
    }

    /* Model Login
    *************************************/

    function test_login(){
        $username = "test";
        $password = "test";

        $this->load->model("modellogin");
        $res = $this->modellogin->validAccount($username, $password);
        return $this->unit->test($res, "is_bool", "Login - validate user - boolean");
    }

    function test_disabled_account(){
        $username = "test";
        $password = "test";

        $this->load->model("modellogin");
        $res = $this->modellogin->disabledAccount($username, $password);
        return $this->unit->test($res, "is_bool", "Login - disabled account - boolean");
    }

}

/* End of file about.php */
/* Location: ./application/controllers/admin */