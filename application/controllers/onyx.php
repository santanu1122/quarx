<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    // Author: Matt Lantz
     
class quarx extends CI_Controller {

// index -------------------------------- //

    public function index() {   
        if($this->session->userdata('logged_in')){ 
            if($this->session->userdata('permission') == 1){
                //configured the data to be transported to the view
                $data['root'] = base_url();
                $data['pageRoot'] = base_url().'index.php';
                $data['pagetitle'] = 'Setup';
                
                //load the view elements
                $this->load->view('common/header', $data);
                $this->load->view('common/mainmenu', $data);
                $this->load->view('core/setup', $data);
                $this->load->view('common/footer', $data);
            }else{
                redirect('accounts/insufficient');
            }
        }else{
            redirect('login/error');
        }
    }

// download -------------------------------- //

    public function download() {   
        if($this->session->userdata('logged_in')){ 
            if($this->session->userdata('permission') == 1){
                //configured the data to be transported to the view
                $data['root'] = base_url();
                $data['pageRoot'] = base_url().'index.php';
                $data['pagetitle'] = 'Setup';
                
                //load the view elements
                $this->load->view('common/header', $data);
                $this->load->view('common/mainmenu', $data);
                $this->load->view('core/setup', $data);
                $this->load->view('common/footer', $data);
            }else{
                redirect('accounts/insufficient');
            }
        }else{
            redirect('login/error');
        }
    }
    
// install -------------------------------- //

    public function install(pkg) {   
        if($this->session->userdata('logged_in')){ 
            if($this->session->userdata('permission') == 1){
                //configured the data to be transported to the view
                $data['root'] = base_url();
                $data['pageRoot'] = base_url().'index.php';
                $data['pagetitle'] = 'Setup';
                
                //load the view elements
                $this->load->view('common/header', $data);
                $this->load->view('common/mainmenu', $data);
                $this->load->view('core/setup', $data);
                $this->load->view('common/footer', $data);
            }else{
                redirect('accounts/insufficient');
            }
        }else{
            redirect('login/error');
        }
    }
    

}
/* End of file quarx.php */
/* Location: ./application/controllers/quarx.php */