<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class sanity_test extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->lang->load(config_item('language_abbr'), config_item('language'));
    }

    public function index($specified = null)
    {
        $i = 0;
        echo "commencing tests...\n";

        $this->benchmark->mark('code_start');

        $tests = (empty($specified)) ? scandir('application/controllers/tests') : array($specified.".php");

        foreach ($tests as $test)
        {
            if ($test != '.' && $test != '..' && $test != '.DS_Store' )
            {
                $res = exec('php index.php tests '.str_replace(".php", "", $test))."\n";
                echo $res;

                if (stristr($res, 'F ->'))
                {
                    exit(1);
                }

                $i++;
            }

        }

        $this->benchmark->mark('code_end');

        echo $i." tests completed in ".$this->benchmark->elapsed_time('code_start', 'code_end')." seconds\n";
    }
}

/* End of file sanity_tests.php */
/* Location: ./application/controllers/ */