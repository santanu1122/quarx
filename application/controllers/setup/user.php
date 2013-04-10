<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
     
class user extends CI_Controller {

/* Initial Setup and Install
***************************************************************/

    public function index() {
        $data['root'] = base_url();
        $data['pageRoot'] = base_url().'index.php';
        $data['pagetitle'] = 'Setup';
        $data['masterPage'] = true;

        $this->load->view('core/setup/header', $data);
        $this->load->view('core/setup/initial', $data);
    }

}
/* End of file setup.php */
/* Location: ./application/controllers/ */