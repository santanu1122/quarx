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

class Tools {

    public function length_check($string)
    {
        $endVal = "N/A";
        if ($string != "") $endVal = $string;

        return $endVal;
    }

    public function val_trim($val, $length)
    {
        if(strlen($val) > $length) return substr($val, 0, $length).'...';

        return $val;
    }

    public function strip_special_chars($str)
    {
        $stripped = preg_replace("/[^A-Za-z0-9 ]/", "", $str);
        $polished = str_replace(" ", "-", $stripped);

        return $polished;
    }

}
//End of File
?>