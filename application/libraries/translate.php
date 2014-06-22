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

class Translate{

    public function line($label, $obj){

        $return = $obj->lang->line($label);

        if ($return)
        {
            echo $return;
        }
        else
        {
            echo $label;
        }
    }
}

//End of File
?>