<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class cryptography {
	
	public function cryptography(){
		
		function encrypt($string){
			$encrypted = urlencode( base64_encode($string) );
			return $encrypted; 
		}
		
		function decrypt($encoded){
			$decrypted = base64_decode( urldecode( $encoded ) );
			return $decrypted;
		}
	}

}
//End of File
?>