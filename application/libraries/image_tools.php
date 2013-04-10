<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* Filename: image_tools.php
 * Location: application/libraries/
 */

class image_tools{
    
    public function image_tools(){ 

        function imgLibrarySelect(){
            $CI =& get_instance();
            $CI->load->model('modelimg');

            $collection = $CI->modelimg->get_collections();

            $data = '<div class="raw100 align-center">';

            $data .= '<p>If you\'d like to add an image library please select one below.</p>';

            $data .= '<select id="selectLibrary-Collections" data-theme="a" name="gallery">';
            $data .= '<option value="0">None</option>';

                foreach ($collection as $col) {
                    
                    $data .= '<option value="'.$col->collection_id.'">'.$col->collection_name.'</option>';

                }

            $data .= '</select></div>';
        
            return $data;

        }
    }
}

//End of File
?>