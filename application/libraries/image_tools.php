<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Quarx
 *
 * A modular CMS built on CodeIgniter
 *
 * @package     Quarx
 * @author      Matt Lantz
 * @copyright   Copyright (c) 2013 Matt Lantz
 * @license     http://ottacon.co/quarx/license
 * @link        http://quarx.ottacon.co
 * @since       Version 1.0
 * 
 */

class image_tools{
    
    public function image_tools()
    { 

        function getCollectionName($id)
        {
            $CI =& get_instance();
            $CI->load->model('modelimg');

            $qry = $CI->modelimg->get_collection_name($id);
            return $qry;
        }

        function imgLibrarySelect($img_collection = null)
        {
            $CI =& get_instance();
            $CI->load->model('modelimg');

            $collection = $CI->modelimg->get_collections();

            $data = '<div class="raw100 align-center">';

            $data .= '<p>If you\'d like to add an image library please select one below.</p>';

            $data .= '<select id="selectLibrary-Collections" data-theme="a" name="img_library">';

            if($img_collection != 0){
                $data .= '<option value="'.$img_collection.'">Currently: '.getCollectionName($img_collection).'</option>';
            }

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