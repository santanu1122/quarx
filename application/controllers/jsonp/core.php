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
     
class core extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        
        $this->valid_ips = array();
        
        if(check_jsonp_token($this->db->escape($this->input->get('token')))){
            array_push($this->valid_ips, $_SERVER['REMOTE_ADDR']);
        }else{
            echo 'failed()';
            exit;
        }

    }

/* Main Login
***************************************************************/

    public function login()
    { 
        if(in_array($_SERVER['REMOTE_ADDR'], $this->valid_ips));
        { 
            if($this->validate()){
                echo 'logged_in({ username: "'.$this->session->userdata('username').'" });';
            }else{
                echo 'failed()';
            }
            
        }

    }

    public function logout(){
        $this->session->sess_destroy();
        echo 'logged_out()';
    }

    public function check_login(){
        if($this->session->userdata("logged_in") == true){
            echo "logged_in({ username: '".$this->session->userdata('username')."' })";
        }else{
            echo "failed()";
        }
    }

/* Account Validation
***************************************************************/

    public function validate() 
    {
        $this->load->model('modellogin');
        $query = $this->modellogin->validAccount($this->db->escape($this->input->get('username')), hash("sha256", $this->db->escape($this->input->get('password'))));

        if($query)
        {
            $data = array(
                'username' => $this->db->escape($this->input->get('username')),
                'logged_in' => true
            );

            $this->session->set_userdata($data);

            return true;

        }else{

            return false;
        }

    }

}
/* End of file core.php */
/* Location: ./application/controllers/jsonp/ */