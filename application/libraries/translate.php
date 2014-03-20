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