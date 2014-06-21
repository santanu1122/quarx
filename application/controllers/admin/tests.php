<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Quarx
 *
 * A modular CMS application
 *
 * @package     Quarx
 * @author      Matt Lantz
 * @copyright   Copyright (c) 2013 - 2014 Matt Lantz
 * @license     https://ottacon.co/docs/quarx/license.html
 * @link        https://github.com/mlantz/quarx
 * @since       Version 1.0
 *
 */

class Tests extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        $this->load->library("unit");

        $this->lang->load(config_item('language_abbr'), config_item('language'));

        if ( ! $this->input->is_cli_request())
        {
            redirect("error");
        }
    }

    public function index()
    {
        $testCount = 0;

        $this->benchmark->mark('code_start');

        $tests = scandir('application/controllers/tests');

        foreach ($tests as $test)
        {
            if ($test != '.' && $test != '..' )
            {
                echo exec('php index.php tests '.str_replace(".php", "", $test))."\n";
                $testCount++;
            }
        }

        $this->benchmark->mark('code_end');

        echo "You ran: ".$testCount." test(s)\n";
        echo "Your Tests took: ".$this->benchmark->elapsed_time('code_start', 'code_end')."\n";
    }

}

/* End of file Tests.php */
/* Location: ./application/controllers/admin */