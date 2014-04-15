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

class Atomic extends CI_Controller {

    function __construct()
    {
        parent::__construct();

        if ( ! $this->session->userdata('logged_in')) redirect('error/login?r='.($_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']));

        if ($this->session->userdata('user_id') != 1)
        {
            $this->session->set_flashdata('error', 'You do not have sufficient permission to access this');
            redirect('error');
        }

        $this->lang->load(config_item('language_abbr'), config_item('language'));
    }

    public function index()
    {
        $url  = 'https://github.com/mlantz/atomic/archive/master.zip';
        $path = '../../atomic.latest.zip';

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $data = curl_exec($ch);

        curl_close($ch);

        file_put_contents($path, $data);

        $zip = new ZipArchive;

        $message = array("error", "Your deployment of atomic failed");

        if ($zip->open($path) === TRUE)
        {
            $zip->extractTo('../');
            $zip->close();

            $message = array("success", "Your deployment of atomic was successful");
        }

        exec('rm -rf ../../atomic.latest.zip');

        $this->session->set_flashdata('message', $message);
        redirect('admin');
    }
}

/* End of file deploy_atomic.php */
/* Location: ./application/controllers/setup */