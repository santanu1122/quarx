<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// Author: Matt Lantz
     
class ajax extends CI_Controller {
    
//View all gallery  
    public function gallery(){
        //In order to see all our lovely gallery
        $this->load->model('modelgallery');
        $data['gallery'] = $this->modelgallery->get_all_gallery();

        $data['root'] = base_url();
        $data['pageRoot'] = base_url().'index.php';
        $data['pagetitle'] = 'view gallery';
        
        //load the view elements
        $this->load->view('ajax/view', $data);
    }
}
/* End of file ajax.php */
/* Location: ./application/controllers/ */