<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

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

class Q_Input extends CI_Input
{
    //Escape the posts automatically
    function post($index = NULL, $xss_clean = TRUE)
    {   
        if ($index === NULL AND ! empty($_POST))
        {
            $post = array();

            foreach (array_keys($_POST) as $key)
            {
                $post[$key] = $this->_fetch_from_array($_POST, $key, $xss_clean);
            }
            return trim($post);
        }

        return trim($this->_fetch_from_array($_POST, $index, $xss_clean));
    }

}