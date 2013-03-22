<?php 
    // toolbelt is a series of simple tools for php applications
?>  

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
    }

}
//End of File
?>