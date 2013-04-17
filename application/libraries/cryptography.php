<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//Author: Matt Lantz

class cryptography {
    
    public function cryptography(){

        function url_base64_encode($str){
            return strtr(base64_encode($str),
                array(
                    '+' => '.',
                    '=' => '-',
                    '/' => '~'
            ));
        }
         
        function url_base64_decode($str){
            return base64_decode(strtr($str,
                array(
                    '.' => '+',
                    '-' => '=',
                    '~' => '/'
            )));
        }

        function encrypt($string){
            $CI =& get_instance();
            $config_key = $CI->config->item('encryption_key');
            $sess = $CI->session->userdata('session_id');

            $key = substr($config_key.$sess, 0, 30);

            $encrypted = rawurlencode( url_base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $key, $string, MCRYPT_MODE_ECB)) );
            
            return trim($encrypted); 
        }
        
        function decrypt($string){
            $CI =& get_instance();
            $config_key = $CI->config->item('encryption_key');
            $sess = $CI->session->userdata('session_id');

            $key = substr($config_key.$sess, 0, 30);

            $decrypted =  mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key, url_base64_decode(rawurldecode($string)), MCRYPT_MODE_ECB);
            
            return trim($decrypted);
        }
    }

}
//End of File
?>