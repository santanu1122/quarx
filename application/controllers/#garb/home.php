<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class home extends CI_Controller {

    public function __construct(){
        parent::__construct();
        
        // $this->lang->load(config_item('language_abbr'), config_item('language'));
        // 
        // $this->load->library('mobile');
    }
     
/* Main Pages
***************************************************************/

    public function index() {
        // $data['mobile'] = $this->mobile->mobile_checker();
        // $this->output->cache(90);

        //set some data and parameters
        $data['root'] = base_url();
        $data['pageRoot'] = base_url().'index.php';
        $data['pagetitle'] = 'Home';
        
        // load the view components
        // $this->load->view('website/common/header', $data);
        // $this->load->view('website/common/menu', $data);
        $this->load->view('website/homepage', $data);
        // $this->load->view('website/common/footer', $data);
    }
    
    public function documentation() {
        $data['mobile'] = $this->mobile->mobile_checker();
        // $this->output->cache(90);

        //set some data and parameters
        $data['root'] = base_url();
        $data['pageRoot'] = base_url().'index.php';
        $data['pagetitle'] = 'Documentation';
        
        // load the view components
        $this->load->view('common/header', $data);
        $this->load->view('common/menu', $data);
        $this->load->view('documentation', $data);
        $this->load->view('common/footer', $data);
    }
    
}

/* End of file main.php */
/* Location: ./application/controllers/ */