<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* -----------------------------------------
 *  unit.php
 *
 *  A simple unit testing class for codeigniter enabling tests of
 *  controllers and models.
 *
 *  ** requires cURL **
 *
 *  Copyright 2013 Matt Lantz
 *  http://mattlantz.ca/docs/unit
 *
 *  Permission is hereby granted, free of charge, to any person obtaining
 *  a copy of this software and associated documentation files (the
 *  "Software"), to deal in the Software without restriction, including
 *  without limitation the rights to use, copy, modify, merge, publish,
 *  distribute, sublicense, and/or sell copies of the Software, and to
 *  permit persons to whom the Software is furnished to do so, subject to
 *  the following conditions:
 *
 *  The above copyright notice and this permission notice shall be
 *  included in all copies or substantial portions of the Software.
 *
 *  THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
 *  EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
 *  MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
 *  NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE
 *  LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION
 *  OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION
 *  WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 *
 * ------------------------------------------ */

// Keys to usage:
//
// if you need to test a post operation, and its inner
// functions, then run a c_test, if its just a grabbing
// of data from a model without a post, then use a test.
// Otherwise, use them as you need them, I recomend keeping
// all your tests in a single group of files.

class Unit {

    public function __construct()
    {
        $CI =& get_instance();
        $this->url = site_url();
    }

    /* Example
    *************************************/
    // $test = array(
    //     "function" => "disabledAccount",    [function name]
    //     "controller" => "login",            [controller file name - without .php]
    //     "type" => "post",                   [post, get]
    //     "test" => "",                       [array, variables]
    //     "expect" => ""                      [is_string, is_obj, is_int, is_float, is_false, is_true, is_array, is_bool, other string of your choice]
    // );

    public function c_test($t)
    {
        $status = "Failed";

        $ch = curl_init($this->url.'/'.$t['controller'].'/'.$t['function']);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");

        if ($t['type'] === "post") curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");

        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($t['test']));

        $res = curl_exec($ch);

        $status = "Fail";

        if ($this->test_result($res, $t["expect"])) $status = "Pass";

        return $status.' '.($status == "Fail" ? " - ".$t["name"] : "")."\n";
    }

    /* Example
    *************************************/
    // $toCheck - data that needs referencing
    // $expect - what your expecting [is_string, is_obj, is_int, is_float, is_false, is_true, is_array, is_bool, other string of your choice]
    // $name - A name/title to be displayed

    public function test ($toCheck, $expect, $name)
    {
        $status = "Fail";

        if ($this->test_result($toCheck, $expect)) $status = "Pass";

        return $status.' '.($status == "Fail" ? " - ".$t["name"] : "");
    }

    /* Private Functions
    ***************************************************************/

    private function test_result($totest, $expect){

        switch ($expect)
        {
            case 'is_string':
                if (is_string($totest)) return true;
                return false;
                break;

            case 'is_int':
                if (is_int($totest)) return true;
                return false;
                break;

            case 'is_obj':
                if (is_object($totest)) return true;
                return false;
                break;

            case 'is_true':
                if ($totest) return true;
                return false;
                break;

            case 'is_false':
                if (!$totest) return true;
                return false;
                break;

            case 'is_array':
                if (is_array($totest)) return true;
                return false;
                break;

            case 'is_bool':
                if (is_bool($totest)) return true;
                return false;
                break;

            case 'is_float':
                if (is_float($totest)) return true;
                return false;
                break;

            default:
                if ($totest === $expect) return true;
                return false;
                break;
        }
    }

}

//End of File
?>
