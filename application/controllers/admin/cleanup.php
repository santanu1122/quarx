<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Quarx
 *
 * A modular application structure built on CodeIgniter
 *
 * @package     Quarx
 * @author      Matt Lantz
 * @copyright   Copyright (c) 2013 - 2014 Matt Lantz
 * @license     https://ottacon.co/docs/quarx/license.html
 * @link        https://github.com/mlantz/quarx
 * @since       Version 1.0
 *
 */

class Cleanup extends CI_Controller {

    function __construct()
    {
        parent::__construct();

        if ( ! $this->session->userdata('logged_in')) redirect('error/login?r='.($_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']));

        if ($this->session->userdata('user_id') != 1)
        {
            $this->session->set_flashdata('error', 'You do not have sufficient permission to access this');
            redirect('error');
        }

        $this->lang->load(config_item('language_abbr'), config_item('language'));
    }

    public function index()
    {
        if (count(scandir('application/controllers/setup')) > 0)
        {
            $this->removeDirectory('application/controllers/setup');
        }

        if (count(scandir('application/view/core/setup')) > 0)
        {
            $this->removeDirectory('application/view/core/setup');
        }

        $this->session->set_flashdata('message', array("success", "Your Quarx installation has now been cleaned up."));
        redirect("admin");
    }

    private function removeDirectory($dir)
    {
        foreach (glob($dir . '/*') as $file)
        {
            if (is_dir($file)) rrmdir($file); else unlink($file);
        }

        rmdir($dir);
    }

}
/* End of file connect_to_atomic.php */
/* Location: ./application/controllers/ */