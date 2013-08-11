<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Quarx
 *
 * A modular application framework built on CodeIgniter
 *
 * @package     Quarx
 * @author      Matt Lantz
 * @copyright   Copyright (c) 2013 Matt Lantz
 * @license     http://ottacon.co/quarx/license.html
 * @link        http://ottacon.co/quarx
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

        function imgLibrarySelect($img_collection = null, $id_tag = null)
        {
            if($id_tag == null){
                $id_tag = 'quarx-select-library-collections';
            }

            $CI =& get_instance();
            $CI->load->model('modelimg');

            $collection = $CI->modelimg->get_collections();

            $data = '<div class="raw100 align-center">';

            $data .= '<p>If you\'d like to add an image library please select one below.</p>';

            $data .= '<select id="'.$id_tag.'" data-theme="a" name="quarx_img_library">';

            if($img_collection != 0){
                $data .= '<option value="'.$img_collection.'">Currently: '.getCollectionName($img_collection).'</option>';
            }

            $data .= '<option value="0">None</option>';

                foreach ($collection as $col) {
                    $data .= '<option value="'.$col->collection_id.'">'.$col->collection_name.'</option>';
                }

            $data .= '</select></div>';

            $data .= '<script type="text/javascript">

                        $(document).ready(function(){
                            $("#quarx-select-library-collections-button").click(function(){

                                $.ajax({
                                    url: "'.site_url('image/get_collections').'",
                                    type: "GET",
                                    dataType: "HTML",
                                    success: function(data) {
                                        var options = \'<option value="0">None</option>\'+data;
                                        $(\'#quarx-select-library-collections\').html(options).selectmenu("refresh");
                                    }
                                });
                                
                            });
                        });
                            
                        </script>';
        
            echo $data;
        }

        function imageGalleryButton($str = null)
        {
            if(!$str){
                $str = "Image Library";
            }

            echo '<a href="#quarx-image-library" data-role="button" data-theme="d">'.$str.'</a>';
        }

        function addImageGallery()
        {
            $GLOBALS['quarx-image-gallery-enabled'] = TRUE;
        }
    }
}

//End of File
?>