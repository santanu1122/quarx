<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class toolbelt {

    public function toolbelt(){
        
        function valCheck($string){
            $endVal = "N/A";
            if($string != ""){
                $endVal = $string;
            }
            return $endVal;
        }

        function valTrim($val, $length){
            if(strlen($val) > $length){
                return substr($val, 0, $length).'...';
            }else{
                return $val;
            }
        }
    
    }

}
//End of File
?>