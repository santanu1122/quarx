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

class sample extends MX_Controller {
    
    public function __construct(){
        parent::__construct();

        if(!$this->session->userdata('logged_in')){
            redirect('login/error');
        }
        
        $this->lang->load(config_item('language_abbr'), config_item('language'));
    }

/* Main Pages
***************************************************************/

    public function index(){
        $this->load->model('model_sample');
        
        addImageGallery();

        $data['root'] = base_url();
        $data['pageRoot'] = base_url().'index.php';
        $data['pagetitle'] = 'Sample';
          
        $this->load->view('common/header', $data);
        $this->load->view('sample', $data);
        $this->load->view('common/footer', $data); 
    }
    
}

/* End of file sample.php */
/* Location: /controllers/ */