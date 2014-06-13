<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* -----------------------------------------
 *  sanity.php
 *
 *  A simple sanity testing class for codeigniter enabling tests of
 *  controllers and models.
 *
 *  ** requires cURL **
 *
 *  Copyright 2013-2014 Matt Lantz
 *  http://mattlantz.ca
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

/* Example
*************************************/
// $test = array(
//     "function" => "disabledAccount",    [function name]
//     "controller" => "login",            [controller file name - without .php]
//     "type" => "post",                   [post, get]
//     "data" => "",                       [array, variables]
//     "expect" => ""                      [is_string, is_obj, is_int, is_float, is_false, is_true, is_array, is_bool, other string of your choice]
// );

/* Example
*************************************/
// $toCheck - data that needs referencing
// $expect - what your expecting [is_string, is_obj, is_int, is_float, is_false, is_true, is_array, is_bool, other string of your choice]
// $name - A name/title to be displayed

class Sanity {

    public function __construct()
    {
        $CI =& get_instance();

        $this->url = 'http://localhost:8888/_open_source/quarx/quarx5/index.php';

        $this->loginFunction = 'login/validate';

        $this->standardTest = array("function" => "","name" => "","type" => "","data" => "","code" => "","expect" => "","userdata" => "");
    }

    public function controller_test($t)
    {
        $ch = curl_init($this->url.'/'.$t['function']);

        $userSession = @$t['userdata'] ?: null;

        if ( ! is_null($userSession))
        {
            if ( ! $this->user_login($t['userdata'])) return "F -> Failed to login";

            curl_setopt($ch, CURLOPT_COOKIEFILE, 'application/cache/cookie.txt');
            curl_setopt($ch, CURLOPT_COOKIESESSION);
        }

        curl_setopt($ch, CURLOPT_USERAGENT, "SanityTestBot");
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");

        if ($t['type'] == "post") curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");

        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($t['data']));

        $res = curl_exec($ch);

        $title = preg_match('!<title>(.*?)</title>!i', $res, $matches) ? $matches[1] : 'No title found';

        $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);

        $code = @$t["code"];

        if ( ! @$t["code"]) $code = "200";

        if ($this->test_result($res, $t["expect"]) && $http_status == $code) return ".\n";

        return "F -> ".$t['name']."\n";
    }

    public function user_login($data)
    {
        $fp = fopen('application/cache/cookie.txt', 'w');

        fclose($fp);

        $ch = curl_init($this->url.'/'.$this->loginFunction);

        $headers[] = "Accept: */*";
        $headers[] = "Connection: Keep-Alive";

        curl_setopt($ch, CURLOPT_HTTPHEADER,  $headers);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);

        curl_setopt($ch, CURLOPT_COOKIEJAR, 'application/cache/cookie.txt');
        curl_setopt($ch, CURLOPT_COOKIEFILE, 'application/cache/cookie.txt');
        curl_setopt($ch, CURLOPT_COOKIESESSION, TRUE);

        curl_setopt($ch, CURLOPT_USERAGENT, "SanityTestBot");

        foreach ($data as $key => $value)
        {
            $data_string .= $key.'='.$value.'&';
        }

        curl_setopt($ch, CURLOPT_POST, count($data));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);

        $result = curl_exec($ch);

        $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);

        $title = preg_match('!<title>(.*?)</title>!i', $result, $matches) ? $matches[1] : 'No title found';

        if ($http_status == 200) return true;
        return false;
    }

    public function result_test($toCheck, $expect, $name)
    {
        if ($this->test_result($toCheck, $expect)) return ".\n";

        return "F -> ".$name."\n";
    }

    public function header_test($t, $error_test = false)
    {
        $ch = curl_init($this->url.'/'.$t['function']);

        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");

        if ($t['type'] === "post") curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");

        $userSession = @$t['userdata'] ?: null;

        if ( ! is_null($userSession))
        {
            if ( ! $this->user_login($t['userdata'])) return "F -> Failed to login";

            curl_setopt($ch, CURLOPT_COOKIEFILE, 'application/cache/cookie.txt');
            curl_setopt($ch, CURLOPT_COOKIESESSION);
        }

        curl_setopt($ch, CURLOPT_USERAGENT, "SanityTestBot");
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($t['data']));

        $res = curl_exec($ch);

        $title = preg_match('!<title>(.*?)</title>!i', $res, $matches) ? $matches[1] : 'No title found';
        $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ( ! stristr($title, "Error") && $error_test) $http_status = "Fail";

        switch ($http_status)
        {
            case '200':
                return ".\n";
                break;

            default:
                return "F -> ".$t['name']."\n";
                break;
        }

        return "F -> ".$t['name']."\n";
    }

    public function test_result($res, $expect)
    {
        switch ($expect)
        {
            case 'is_string':
                if (is_string($res)) return true;
                return false;
                break;

            case 'is_page':
            case 'is_redirect':
                if (empty($res)) return true;
                return false;
                break;

            case 'is_int':
                if ($res == "") $res = 0;
                if (is_numeric($res)) return true;
                if (is_int($res)) return true;
                return false;
                break;

            case 'is_obj':
                if (is_object($res)) return true;
                return false;
                break;

            case 'is_true':
                if ($res) return true;
                return false;
                break;

            case 'is_false':
                if (!$res) return true;
                return false;
                break;

            case 'is_array':
                if (is_array($res)) return true;
                return false;
                break;

            case 'is_bool':
                if (is_bool($res)) return true;
                return false;
                break;

            case 'is_float':
                if (is_float($res)) return true;
                return false;
                break;

            default:
                if ($res === $expect) return true;
                return false;
                break;
        }
    }
}

//End of File
?>
