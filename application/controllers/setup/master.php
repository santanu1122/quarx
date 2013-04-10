<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
     
class master extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->model('modelsetup');
        $qry = $this->modelsetup->is_installed();

        if(!$qry){
            redirect('setup/install');
        }
    }

/* Master
***************************************************************/

    public function index() {
        $data['quarxInstalled'] = 'installed';
        
        $this->load->model('modelsetup');
        $atomic = $this->modelsetup->is_connected_to('atomic');
        $data['atomic'] = $atomic[0]->option_title;
    
        $data['root'] = base_url();
        $data['pageRoot'] = base_url().'index.php';
        $data['pagetitle'] = 'Setup';
        $data['masterPage'] = true;

        $this->load->view('core/setup/header', $data);
        $this->load->view('core/setup/master', $data);
    }
}
/* End of file master.php */
/* Location: ./application/controllers/setup */