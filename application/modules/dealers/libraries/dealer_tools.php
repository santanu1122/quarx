<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// Author: Matt Lantz

class dealer_tools {
    
    public function dealer_tools(){ 

        function accountType($val){
            $type = '';
            switch ($val) {
                case 51:
                    $type = 'Dealer';
                    break;

                case 52:
                    $type = 'Territory Manager';
                    break;
                
                default:
                    $type = 'Dealer';
                    break;
            }

            return $type;
        }

        function getTmName($id = null){
            if($id == null){
                return 'None';
            }else{
                $res = '';
                $CI =& get_instance();

                $CI->load->model('model_dealers');
                $tm = $CI->model_dealers->get_tm($id);

                if(!$tm){
                    return 'Baumalight';
                }

                return $tm[0]->company;

            }
        }

        function get_my_dealers($id){
            $res = '';
            $CI =& get_instance();

            $CI->load->model('model_dealers');
            $dealers = $CI->model_dealers->get_my_dealers($id);

            return $dealers;
        }
    }
}

//End of File
?>