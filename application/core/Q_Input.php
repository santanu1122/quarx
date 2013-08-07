<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

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
            return mysql_real_escape_string($post);
        }

        return mysql_real_escape_string($this->_fetch_from_array($_POST, $index, $xss_clean));
    }

}