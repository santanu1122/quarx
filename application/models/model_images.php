<?php

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

class Model_images extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }

    public function upload_img($img, $collection)
    {
        $this->img_location = site_url().'uploads/img/full/'.$img;
        $this->img_medium_location = site_url().'uploads/img/medium/'.$img;
        $this->img_thumb_location = site_url().'uploads/img/thumb/'.$img;
        $this->img_collection = $collection;

        return $this->db->insert('img', $this);
    }

    public function update_collection($id, $collection)
    {
        $this->img_collection = $collection;
        $this->db->where('img_id', $id);

        return $this->db->update('img', $this);
    }

    public function get_all_images($collection)
    {
        if ( ! is_null($collection)) $this->db->where("img_collection", $collection);

        $this->db->order_by("img_id", "DESC");
        return $this->db->get("img")->result();
    }

    public function get_collection_name($id)
    {
        $this->db->where("collection_id", $id);
        $query = $this->db->get("img_collections");
        $collection = $query->result();

        return $collection[0]->collection_name;
    }

    public function get_collections()
    {
        $this->db->order_by("collection_id", "DESC");
        $query = $this->db->get("img_collections");

        return $query->result();
    }

    public function delete_img($id)
    {
        $this->db->where("img_id", $id);
        $this->db->delete("img");

        return true;
    }

    public function find_img($id)
    {
        $this->db->where("img_id", $id);
        $query = $this->db->get("img");

        return $query->result();
    }

    public function delete_collection($id)
    {
        $this->db->where("img_collection", $id);
        $res = $this->db->get("img")->num_rows();

        if ($res > 0) return false;

        $this->db->where("collection_id", $id);
        $this->db->delete("img_collections");

        return true;
    }

/* Alt Title Tags
***************************************************************/

    public function set_alt_title($id, $alt, $title)
    {
        $data = array(
            'img_alt_tag' => $alt,
            'img_title_tag' => $title
        );

        $this->db->where("img_id", $id);
        return $this->db->update("img", $data);
    }

    public function get_alt_title($id)
    {
        $this->db->where("img_id", $id);
        $img_qry = $this->db->get("img");

        return $img_qry->result();
    }

    public function new_collection()
    {
        $data = array(
            "collection_name" => $this->input->post('collection_name')
        );

        return $this->db->insert('img_collections', $data);
    }

}
// End of File
?>