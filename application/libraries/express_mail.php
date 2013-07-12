<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Quarx
 *
 * A modular CMS built on CodeIgniter
 *
 * @package     Quarx
 * @author      Matt Lantz
 * @copyright   Copyright (c) 2013 Matt Lantz
 * @license     http://ottacon.co/quarx/license
 * @link        http://quarx.ottacon.co
 * @since       Version 1.0
 * 
 */

class express_mail {

    public function express_mail()
    {
        
        function activated_account($to)
        {
            $CI =& get_instance();

            $from = 'do-not-reply';
            $subject = 'Your Account was Activated!';
            $message = '
<h4>Account Activated</h4><br />
<p>Success! You\'re account has been activated. Feel free to login! Thanks.</p>';

            $CI->load->library('email');

            $config['charset'] = 'utf-8';
            $config['protocol'] = 'mail';
            $config['mailtype'] = 'html';
            $config['wordwrap'] = TRUE;
            
            $CI->email->initialize($config);
            
            $CI->email->from($from);
            $CI->email->to($to);
            $CI->email->subject($subject);
            $CI->email->message($message);
            
            $CI->email->send();
        }
    
    }

}
//End of File
?>