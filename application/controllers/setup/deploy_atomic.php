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
     
class deploy_atomic extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->model('modelsetup');
        $qry = $this->modelsetup->is_installed();

        if(!$qry)
        {
            redirect('setup/install');
        }
    }

/* Deploy Atomic
***************************************************************/

    public function index()
    {
        $url  = 'http://www.ottacon.co/_quarx_/atomic.latest.zip';
        $path = '../../atomic.latest.zip';

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
     
        $data = curl_exec($ch);
     
        curl_close($ch);
     
        file_put_contents($path, $data);

        $zip = new ZipArchive;
        
        if ($zip->open($path) === TRUE) 
        {
            $zip->extractTo('../');
            $zip->close();
        }
        else
        {
            echo 'failed';
        }

        exec('rm -rf ../../atomic.latest.zip');
        $this->session->set_flashdata('success', 'Your deployment of atomic was successful');
        redirect('setup/master');
    }
}

/* End of file deploy_atomic.php */
/* Location: ./application/controllers/setup */