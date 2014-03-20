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

class test_login extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        $this->load->library("unit");

        $this->lang->load(config_item('language_abbr'), config_item('language'));

        if ( ! $this->input->is_cli_request())
        {
            redirect("errors/oops");
        }
    }

    public function index()
    {
        /* Model Login Test
        *************************************/

        $username = "test";
        $password = "test";

        $this->load->model("model_login");
        $res = $this->model_login->cookie_validate($username, $password);

        echo $this->unit->test($res, "is_bool", "Login - validate user - boolean");
    }

}

/* End of file Tests.php */
/* Location: ./application/controllers/admin */