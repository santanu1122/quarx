<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Quarx
 *
 * A modular CMS application
 *
 * @package     Quarx
 * @author      Matt Lantz
 * @copyright   Copyright (c) 2013 Matt Lantz
 * @license     http://ottacon.co/quarx/license.html
 * @link        http://ottacon.co/quarx
 * @since       Version 1.0
 *
 */

class Ajax extends CI_Controller {

    function __construct()
    {
        parent::__construct();

        @$referer = $_SERVER['HTTP_REFERER'];

        if ( ! stristr($referer, site_url()))
        {
            $this->session->set_flashdata('error', "This isn't really what you're looking for is it?");
            redirect("error");
        }
    }

    public function index()
    {
        if (isset($_GET['zip_postal']))
        {
            $addy = $_GET['zip_postal'];

            $trimmed = trim($addy);
            $trimmed = str_replace(" ", "", $trimmed);
            $url = "http://maps.googleapis.com/maps/api/geocode/xml?address=". $trimmed ."&sensor=false";
            $xml = simplexml_load_file($url);

            $lat = floatval($xml->result->geometry->location->lat);
            $lng = floatval($xml->result->geometry->location->lng);

            if($_GET['type'] == 'lat') echo $lat;
            if($_GET['type'] == 'lng') echo $lng;
        }
        else
        {
            $this->session->set_flashdata('error', "This isn't really what you're looking for is it?");
            redirect("error");
        }
    }

    public function unc($params)
    {
        $name = $params ?: '';

        if ($name > '')
        {
            $this->load->model('model_users');
            $query = $this->model_users->unc_validate($name);

            echo $query;
        }
        else
        {
            echo 0;
        }
    }
}

/* End of file Ajax.php */
/* Location: ./application/controllers/ */