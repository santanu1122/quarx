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

class Crypto {

    public function encrypt($string)
    {
        $CI =& get_instance();
        $config_key = $CI->config->item('encryption_key');

        $key = $CI->session->userdata('session_id').$config_key;
        $iv = md5(md5($key));

        $encrypted = rawurlencode($this->url_base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), $string, MCRYPT_MODE_CBC, $iv)));
        return trim($encrypted);
    }

    public function decrypt($string)
    {
        $CI =& get_instance();
        $config_key = $CI->config->item('encryption_key');

        $key = $CI->session->userdata('session_id').$config_key;
        $iv = md5(md5($key));

        $decrypted =  mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($key), $this->url_base64_decode(rawurldecode($string)), MCRYPT_MODE_CBC, $iv);
        return trim($decrypted);
    }

    private function url_base64_encode($str)
    {
        return strtr(base64_encode($str),
            array(
                '+' => '.',
                '=' => '-',
                '/' => '~'
            )
        );
    }

    private function url_base64_decode($str)
    {
        return base64_decode(strtr($str,
            array(
                '.' => '+',
                '-' => '=',
                '~' => '/'
            )
        ));
    }

}
//End of File
?>