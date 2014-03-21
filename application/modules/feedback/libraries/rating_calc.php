<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// Author: Matt Lantz
/* This library gives us a handful of general 
 * tools for category management.
 */

class rating_calc {
    
    public function rating_calc(){ 

        function overall_score($id){
            $CI =& get_instance();
            $CI->load->model('model_feedback');
            
            $res = $CI->model_feedback->get_this_rating($id);

            $professionalism = $res[0]->fbr_professionalism;
            $speed = $res[0]->fbr_speed;
            $cleanliness = $res[0]->fbr_cleanliness;
            $workmanship = $res[0]->fbr_workmanship;
            
            $experience = $res[0]->fbr_experience;
            $cost_value = $res[0]->fbr_cost_value;
            $sales_rep_rating = $res[0]->fbr_sales_rep_rating;
            $foreman_rating = $res[0]->fbr_foreman_rating;

            // set the percentages/weights

            $professionalism *= 0.145;
            $speed *= 0.145;
            $cleanliness *= 0.145;
            $workmanship *= 0.165;

            $experience *= 0.165;
            $cost_value *= 0.105;
            $sales_rep_rating *= 0.065;
            $foreman_rating *= 0.065;

            $result = round($professionalism + $speed + $cleanliness + $workmanship + $experience + $cost_value + $sales_rep_rating + $foreman_rating);

            return $result;
        }

        function get_val($id, $col){
            $CI =& get_instance();
            $CI->load->model('model_feedback');
            
            $res = $CI->model_feedback->get_this_feedback($id);
            
            return $res[0]->$col;
        }

    }
}

//End of File
?>