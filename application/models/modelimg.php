<?php

/*
    Filename:   modelimg.php
    Location:   /application/models/
*/

class modelimg extends CI_Model {

    function __construct(){
        // Call the Model constructor
        parent::__construct();
    }
   
/* Upload Images
***************************************************************/

    function upload_img($img, $collection) {
        $this->img_location   = site_url().'uploads/img/full/'.$img;
        $this->img_medium_location   = site_url().'uploads/img/medium/'.$img;
        $this->img_thumb_location   = site_url().'uploads/img/thumb/'.$img;
        $this->img_collection = $collection;
        $this->db->insert('img', $this);
            
        return true;
    }

/* Update Collection
***************************************************************/

    function update_collection(){
        $this->img_collection = $this->input->post('collections');
        $this->db->where('img_id', $this->input->post('imageId'));
        $this->db->update('img', $this);

        return true;
    }

/* Gets
***************************************************************/
    
    function get_all_img($collection) {
        if($collection == null){
            $collection = '';
        }else{
            $collection = 'WHERE img_collection = '.$collection;
        }

        $query = $this->db->query("SELECT * FROM img ".$collection." ORDER BY img_id DESC");
        return $query->result();
    }

    function get_collection_name($id){
        $query = $this->db->query("SELECT * FROM img_collections WHERE collection_id = ".$id);
        $collection = $query->result();
        return $collection[0]->collection_name;
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

    function get_collections() {
        $query = $this->db->query("SELECT * FROM img_collections ORDER BY collection_id DESC");
        return $query->result();
    }

/* Delete Images/Collections
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

    function delete_collection(){
        $id = $this->input->post('idTag');
        $res = $this->db->query("SELECT * FROM img WHERE img_collection = '".$id."'");
        $res = $res->num_rows();

        if($res > 0){
            return false;
        }else{
            $query = $this->db->query("DELETE FROM img_collections WHERE collection_id = '".$id."'");
            if($query){
                return true;
            }
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

/* Collections
***************************************************************/

    function new_collection(){
        $this->collection_name = $this->input->post('collection_name');
        $this->db->insert('img_collections', $this);
            
        return true;
    }
    


}
// End of File
?>