<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Quarx
 *
 * A modular CMS application
 *
 * @package     Quarx
 * @author      Matt Lantz
 * @copyright   Copyright (c) 2013 Matt Lantz
 * @license     http://ottacon.co/quarx/license.html
 * @link        http://ottacon.co/quarx
 * @since       Version 1.0
 *
 */

class Manual extends CI_Controller {

    function __construct()
    {
        parent::__construct();

        if ( ! $this->session->userdata('logged_in')) redirect('error/login?r='.($_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']));

        $this->lang->load(config_item('language_abbr'), config_item('language'));
    }

    public function index()
    {
        if ($this->session->userdata('user_id') == 1) $data['displayMasterManual'] = true;
        if ($this->session->userdata('permission') == 1) $data['displayAdminManual'] = true;

        $js = array('views/quarx-manual.js');
        $this->carabiner->group("quarx-manual-js", array('js'=>$js));

        $data['root'] = base_url();
        $data['pageRoot'] = base_url().'index.php';
        $data['pagetitle'] = 'Manual';

        $this->load->view('common/header', $data);
        $this->load->view('core/manual', $data);
        $this->load->view('common/footer', $data);
    }

}

/* End of file Manual.php */
/* Location: ./application/controllers/admin */