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

/**
 * The model for the images library
 */
class Model_images extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Upload an image and add it to the database
     *
     * @param  string   $img           The image file location
     * @param  int      $collection    The collection ID
     * @param  string   $original_name The original file name
     * @param  int      $order         The collection ordering
     *
     * @return boolean
     */
    public function upload_img($img, $collection, $original_name, $order)
    {
        $this->img_location = site_url().'uploads/img/full/'.$img;
        $this->img_medium_location = site_url().'uploads/img/medium/'.$img;
        $this->img_thumb_location = site_url().'uploads/img/thumb/'.$img;
        $this->original_name = $original_name;
        $this->collection_order = $order;
        $this->img_collection = $collection;

        return $this->db->insert('img', $this);
    }

    /**
     * Update what collection an image belongs to
     *
     * @param  int $id         image id
     * @param  int $collection the collection ID
     *
     * @return boolean
     */
    public function update_collection($id, $collection)
    {
        $this->img_collection = $collection;
        $this->db->where('img_id', $id);

        return $this->db->update('img', $this);
    }

    /**
     * Set an image as published or not
     *
     * @param  int $id    image ID
     * @param  string $state publish state
     *
     * @return boolean
     */
    public function publish_image($id, $state)
    {
        $pub = 0;
        if ($state == "true") $pub = 1;

        $this->published = $pub;
        $this->db->where('img_id', $id);

        return $this->db->update('img', $this);
    }

    /**
     * The the order of an image
     *
     * @param int $id    image ID
     * @param int $order position
     *
     * @return  boolean
     */
    public function set_image_order($id, $order)
    {
        $this->collection_order = $order;
        $this->db->where('img_id', $id);

        return $this->db->update('img', $this);
    }

    /**
     * Get all images of a collection
     *
     * @param  int $collection collection ID
     *
     * @return array
     */
    public function get_all_images($collection)
    {
        if ( ! is_null($collection)) $this->db->where("img_collection", $collection);

        $this->db->order_by("collection_order", "ASC");
        return $this->db->get("img")->result();
    }

    /**
     * Get a collection's name
     *
     * @param  int $id collection ID
     *
     * @return string
     */
    public function get_collection_name($id)
    {
        $this->db->where("collection_id", $id);
        $query = $this->db->get("img_collections");
        $collection = $query->result();

        return $collection[0]->collection_name;
    }

    /**
     * Get the collections
     *
     * @return array
     */
    public function get_collections()
    {
        $this->db->order_by("collection_id", "DESC");
        $query = $this->db->get("img_collections");

        return $query->result();
    }

    /**
     * Delete an image
     *
     * @param  int $id image ID
     *
     * @return boolean
     */
    public function delete_img($id)
    {
        $this->db->where("img_id", $id);
        $this->db->delete("img");

        return true;
    }

    /**
     * Find an image
     *
     * @param  int $id image ID
     *
     * @return array
     */
    public function find_img($id)
    {
        $this->db->where("img_id", $id);
        $query = $this->db->get("img");

        return $query->result();
    }

    /**
     * Delete an image collection
     *
     * @param  int $id collection ID
     *
     * @return boolean
     */
    public function delete_collection($id)
    {
        $this->db->where("img_collection", $id);
        $res = $this->db->get("img")->num_rows();

        if ($res > 0) return false;

        $this->db->where("collection_id", $id);
        $this->db->delete("img_collections");

        return true;
    }

    /**
     * Set an image alt and title tags
     *
     * @param imt       $id    image ID
     * @param string    $alt   Alt tag
     * @param string    $title Title tag
     *
     * @return boolean
     */
    public function set_alt_title($id, $alt, $title)
    {
        if ($alt == "Alt Tag") $alt = "";
        if ($title == "Title Tag") $alt = "";

        $data = array(
            'img_alt_tag' => $alt,
            'img_title_tag' => $title
        );

        $this->db->where("img_id", $id);
        return $this->db->update("img", $data);
    }

    /**
     * Get an images alt and title tags
     *
     * @param  int $id image ID
     *
     * @return array
     */
    public function get_alt_title($id)
    {
        $this->db->where("img_id", $id);
        $img_qry = $this->db->get("img");

        return $img_qry->result();
    }

    /**
     * Create a new collection
     *
     * @return boolean
     */
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