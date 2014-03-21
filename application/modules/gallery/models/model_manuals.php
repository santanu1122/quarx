<?php

/*
    Filename:   model_gallery.php
    Location:   /application/models/
*/

class model_gallery extends CI_Model {

    function __construct() 
    {
        parent::__construct();
    }
    
/* Add Entry
***************************************************************/

    function add_entry($img, $fileCollection, $fileNameCollection) 
    {
        if($this->input->post('gallery_name') > ''){
            
            $url_name = strip_special_chars(strtolower($this->input->post('gallery_name')));

            $sql = "INSERT INTO 
                        gallery(
                            gallery_name, 
                            gallery_url_name, 
                            gallery_product_code, 
                            gallery_serial_number, 
                            gallery_entry, 
                            gallery_img,
                            gallery_hide
                            ) 
                    VALUES( '".$this->db->escape_str($this->input->post('gallery_name'))."',
                            '".$this->db->escape_str($url_name)."',
                            '".$this->db->escape_str($this->input->post('gallery_product_code'))."',
                            '".$this->db->escape_str($this->input->post('gallery_serial_number'))."',
                            '".$this->db->escape_str($this->input->post('gallery_entry'))."',
                            '".$img."',
                            '0'
                            )";

            $qry = $this->db->query($sql);
            $id = $this->db->insert_id();

            if($qry){

                $i = 0;
                foreach ($fileCollection as $file) {
                    $sql = "INSERT INTO 
                                manual_file(
                                    manual_file_name, 
                                    manual_file_location,
                                    manual_file_owner
                                    ) 
                                VALUES( 
                                    '".$this->db->escape_str($fileNameCollection[$i])."',
                                    '".$this->db->escape_str($file)."',
                                    ".$id."
                                    )";

                    $qry = $this->db->query($sql);
                    $i++;
                
                }

                return array( "success" => true, "id" => $id );
            }else{
                return false;
            }
        }  
    }

/* Edit Entry
***************************************************************/

    function edit_entry($id, $img, $fileCollection, $fileNameCollection) 
    {  
        $title = strtolower($this->input->post('gallery_name'));
        $url_name = strip_special_chars(html_entity_decode($title));

        $sql = "UPDATE 
                    gallery
                SET 
                    `gallery_name` = '".$this->db->escape_str($this->input->post('gallery_name'))."',
                    `gallery_url_name` = '".$this->db->escape_str($url_name)."',
                    `gallery_product_code` = '".$this->db->escape_str($this->input->post('gallery_product_code'))."',
                    `gallery_serial_number` = '".$this->db->escape_str($this->input->post('gallery_serial_number'))."',
                    `gallery_entry` = '".$this->db->escape_str($this->input->post('gallery_entry'))."',
                    `gallery_img` = '".$img."'
                WHERE 
                    gallery_id = ".$id;
                    
        $qry = $this->db->query($sql);
        
        if($qry){

            $i = 0;
            foreach ($fileCollection as $file) {
                $sql = "INSERT INTO 
                            manual_file(
                                manual_file_name,
                                manual_file_location,
                                manual_file_owner
                                ) 
                            VALUES( 
                                '".$this->db->escape_str($fileNameCollection[$i])."',
                                '".$this->db->escape_str($file)."',
                                ".$id."
                                )";

                $qry = $this->db->query($sql);
                $i++;
            }

            return true;
        }
    }
    
/* Gets
***************************************************************/

    function get_all_entries() 
    {
        $qry = $this->db->query('SELECT * FROM `gallery` ORDER BY gallery_id DESC');        
        if($qry){
            return $qry->result();
        }
    }

    function get_selected_entries($offset=null, $limit=null) 
    {
        if($offset == null){ 
            $offset = 0;
        }

        $qry = $this->db->query('SELECT * FROM `gallery` ORDER BY gallery_name DESC LIMIT '.$this->db->escape_str($offset).','.$this->db->escape_str($limit));

        if($qry){
            return $qry->result();
        }
    }

    function get_this_entry($id) 
    {
        $qry = $this->db->query('SELECT * FROM `gallery` WHERE gallery_id = '.$this->db->escape($id));        
        if($qry){
            return $qry->result();
        }
    }

    function get_product_tally() 
    {
        $qry = $this->db->query('SELECT * FROM `gallery`');        
        if($qry){
            return count($qry->result());
        }
    }

    function get_this_manual($id) 
    {
        $qry = $this->db->query('SELECT * FROM `manual_file` WHERE manual_file_id = '.$this->db->escape($id));        
        if($qry){
            return $qry->result();
        }
    }

    function get_this_products_gallery($id) 
    {
        $qry = $this->db->query('SELECT * FROM `manual_file` WHERE manual_file_owner = '.$this->db->escape($id));        
        if($qry){
            return $qry->result();
        }
    }

    function count_all_entries() 
    {
        $qry = $this->db->query('SELECT * FROM `gallery`');        
        if($qry){
            return $qry->num_row();
        }
    }

/* Quick Edits
***************************************************************/
    
    function display_entry($id) 
    {
        $qry = $this->db->query('UPDATE `gallery` SET gallery_hide = 0 WHERE gallery_id = '.$this->db->escape($id));        
        if($qry){
            return true;
        }
    }

    function archive_entry($id) 
    {
        $qry = $this->db->query('UPDATE `gallery` SET gallery_hide = 1 WHERE gallery_id = '.$this->db->escape($id));        
        if($qry){
            return true;
        }
    }

    function delete_entry($id) 
    {
        $qry = $this->db->query('DELETE FROM `gallery` WHERE gallery_id = '.$this->db->escape($id));

        if($qry){
            return true;
        }
    }

    function delete_manual($id) 
    {
        $qry = $this->db->query('DELETE FROM `manual_file` WHERE manual_file_id = '.$this->db->escape($id));        
        if($qry){
            return true;
        }
    }

/* Search Actions
***************************************************************/

    function search_gallery($term) 
    {
        $qry = $this->db->query('SELECT * FROM `gallery` WHERE gallery_name LIKE "%'.$this->db->escape_str($term).'%" AND gallery_hide = 0
                                || gallery_entry LIKE "%'.$this->db->escape_str($term).'%" AND gallery_hide = 0
                                ORDER BY gallery_id ASC');       
        if($qry){
            return $qry->result();
        }
    }

}
// End of File
?>