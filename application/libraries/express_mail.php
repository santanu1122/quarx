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

class Express_mail {

    public function activated_account($to)
    {
        $CI =& get_instance();

        $from = 'do-not-reply';
        $subject = 'Your '.$_SERVER['HTTP_HOST'].' Account was Activated!';
        $message = '
<h4>Account Activated</h4><br />
<p>Success! You\'re account on '.$_SERVER['HTTP_HOST'].' has been activated. Feel free to login! Thanks.</p>';

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

        return true;
    }

    /* After many headaches here is a Mandrill api connector
    ***************************************************************/

    public function mandrill_message($key, $subject, $to, $to_name, $from, $from_name, $reply_to, $html)
    {
        if ($to_name == null) $to_name = "null";
        if ($from_name == null) $from_name = "null";
        if ($reply_to == null) $reply_to = "null";

        $api = "https://mandrillapp.com/api/1.0/messages/send.json";

        $request = '{
            "key": "'.$key.'",
            "message": {
                "html": "'.str_replace(array("\r", "\n"), '', $html).'",
                "subject": "'.$subject.'",
                "from_email": "'.$from.'",
                "from_name": "'.$from_name.'",
                "to": [
                    {
                        "email": "'.$to.'",
                        "name": "'.$to_name.'"
                    }
                ],
                "headers": {
                    "Reply-To": "'.$reply_to.'"
                }
            },
            "async": false,
            "ip_pool": "Main Pool"
        }';

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $api);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true );
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $request);

        $result = curl_exec($ch);

        if (curl_errno($ch)) $result = curl_error($ch);

        curl_close($ch);

        $out = json_decode($result);

        if ($out[0]->status == 'sent') return true;

        return false;
    }

}
//End of File
?>