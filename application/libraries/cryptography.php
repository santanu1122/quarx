<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//Author: Matt Lantz

class cryptography {
	
	public function cryptography(){
		
		function encrypt($string){
			$CI =& get_instance();
			$key = $CI->config->item('encryption_key');

			$iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
			$iv = mcrypt_create_iv($iv_size, $key);

			$encrypted = urlencode( base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $key, $string, MCRYPT_MODE_CBC, $iv)) );
			
			return $encrypted; 
		}
		
		function decrypt($string){
			$CI =& get_instance();
			$key = $CI->config->item('encryption_key');

			$iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
			$iv = mcrypt_create_iv($iv_size, $key);

			$decrypted =  mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key, base64_decode(urldecode($string)), MCRYPT_MODE_CBC, $iv);
			
			return '"'.$decrypted.'"';
		}
	}

}
//End of File
?>