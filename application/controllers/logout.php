<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// Author: Matt Lantz
     
class logout extends CI_Controller {

// Class logout
    
    public function index() {
        $this->load->helper('cookie');
        
        delete_cookie('quarx-uname');
        delete_cookie('quarx-pword');

        $this->session->sess_destroy();
        
        //configure the data to be transported to the view
        $data['root'] = base_url();
        $data['pageRoot'] = base_url().'index.php';
        $data['pagetitle'] = 'Sign Out';
        
        //load the view elements
        $this->load->view('common/header', $data);
        $this->load->view('common/mainmenu', $data);
        $this->load->view('core/login/logout', $data);
        $this->load->view('common/footer', $data);

    }

}
/* End of file logout.php */
/* Location: ./application/controllers/ */