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
     
class Error extends CI_Controller {

/* Main Login
***************************************************************/

    public function index()
    {      
        $refURL = $_SERVER['REQUEST_URI'];
        $browser = $_SERVER['HTTP_USER_AGENT'];
        $user = $_SERVER['REMOTE_ADDR'];

        $to = '';
        $from = "Website Error";
        $message = "The following website: ".$root." recieved a 404 error: ".$refURL." when user: ".$user.", while using the following browser: ".$browser;

        mail($to, $from, $message);

        $data['root'] = base_url();
        $data['pageRoot'] = base_url().'index.php';
        $data['pagetitle'] = 'Error';
        $data['page'] = 'Error';

        $this->load->view('common/header', $data);
        $this->load->view('core/errors/general', $data);
        $this->load->view('common/footer', $data);
    }

    public function e_404() 
    {
        $refURL = $_SERVER['REQUEST_URI'];
        $browser = $_SERVER['HTTP_USER_AGENT'];
        $user = $_SERVER['REMOTE_ADDR'];

        $to = '';
        $from = "Website Error";
        $message = "The following website: ".$root." recieved a 404 error: ".$refURL." when user: ".$user.", while using the following browser: ".$browser;

        mail($to, $from, $message);

        $data['root'] = base_url();
        $data['pageRoot'] = base_url().'index.php';
        $data['pagetitle'] = 'Error';
        $data['page'] = 'Error';

        $this->load->view('common/header', $data);
        $this->load->view('core/errors/e_404', $data);
        $this->load->view('common/footer', $data);
    }
}
/* End of file settings.php */
/* Location: ./application/controllers/ */