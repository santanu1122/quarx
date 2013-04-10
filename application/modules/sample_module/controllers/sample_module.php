<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class sample_module extends MX_Controller {

    public function __construct(){
        parent::__construct();

    }
     
/* Main Pages
***************************************************************/

    public function index() {
        $data['imageGalleryRequest'] = true;
        
        $data['pagetitle'] = "Sample Module";

        $data['username'] = $this->session->userdata('username');

        $this->load->view('common/header', $data);
        $this->load->view('sample_module', $data);
        $this->load->view('common/footer', $data);
    }
    
}

/* End of file sample_module.php */
/* Location: ./application/modules/sample_module/controlllers */