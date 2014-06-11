<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class test_user_logged_in extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->lang->load(config_item('language_abbr'), config_item('language'));

        $this->load->library("sanity");

        if ( ! $this->input->is_cli_request())
        {
            redirect("errors/oops");
        }
    }

    public function index()
    {
        $data = array(
            //
        );

        $test = array(
            "function" => "login/validate",
            "name" => "User is logged in",
            "type" => "post",
            "data" => $data,
            "expect" => "is_string",
            "code" => "200",
            "userdata" => array(
                "username" => "master",
                "password" => "test"
            )
        );

        echo $this->sanity->controller_test($test);
    }
}

/* End of file test_oen_check.php */
/* Location: ./application/controllers/tests */