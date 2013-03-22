<?php

/*
    Filename:   modelimg.php
    Location:   /application/models/
    Author:     Matt Lantz
*/

class modelimg extends CI_Model {

    function __construct(){
        // Call the Model constructor
        parent::__construct();
    }
   
/* Upload Images
***************************************************************/

    function upload_img($img, $type, $plugin, $galId) {
        $this->img_location   = site_url().'uploads/img/full/'.$img;
        $this->img_thumb_location   = site_url().'uploads/img/thumb/'.$img;
        
        if($type === 'embeded'){
            $this->img_collection = $galId;
        }
        
        $this->category_type = $plugin;

        $this->db->insert('img', $this);
            
        return true;
    }

/* Gets
***************************************************************/
    
    function get_all_img($type) {
        $query = $this->db->query("SELECT * FROM img WHERE category_type = '".$type."' ORDER BY img_id DESC");
        return $query->result();
    }

    function get_img_collection($type, $id) {
        $query = $this->db->query("SELECT * FROM img WHERE category_type = '".$type."' AND img_collection = '".$id."' ORDER BY img_id DESC");
        return $query->result();
    }

    function favorite_img_set($id, $blog_id) {
        $sql = "UPDATE img SET `favorite` = 0 WHERE blog_id = ".$blog_id." || blog_id = 0";
        $qry = mysql_query($sql);
        if($qry){
            $query = "UPDATE img SET `favorite` = 1 WHERE img_id = ".$id;
            $res = mysql_query($query);
            if($res){
                return true;
            }
        }
    }

/* Delete Images
***************************************************************/

    function delete_img($id) {
        $query = $this->db->query("DELETE FROM img WHERE img_id = ".$id);
        if($query){
            return true;
        }
    }

    function find_img($id) {       
        $img_qry = $this->db->query('SELECT * FROM `img` WHERE img_id = '.$id);     
        if($img_qry){
            return $img_qry->result();
        }
    }

/* Alt Title Tags
***************************************************************/

    function set_alt_title($id, $alt, $title) {       
        $img_qry = $this->db->query('UPDATE img 
                                     SET 
                                        `img_alt_tag` = "'.$alt.'",
                                        `img_title_tag` = "'.$title.'"
                                     WHERE img_id = '.$id);     
        if(!$img_qry){
            return false;
        }
    }

    function get_alt_title($id) {       
        $img_qry = $this->db->query('SELECT * FROM `img` WHERE img_id = '.$id);     
        if($img_qry){
            return $img_qry->result();
        }
    }
}
// End of File
?>