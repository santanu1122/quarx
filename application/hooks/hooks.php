<?php

/**
 * Quarx
 *
 * A modular application framework built on CodeIgniter
 *
 * @package     Quarx
 * @author      Matt Lantz
 * @copyright   Copyright (c) 2013 Matt Lantz
 * @license     http://ottacon.co/quarx/license
 * @link        http://ottacon.co/quarx
 * @since       Version 1.0
 * 
 */ 
     
class hooks {
    var $CI;

    function hooks() {
        $this->CI =& get_instance();
    }

/* Main Functions
***************************************************************/

    function init()
    {
        $GLOBALS["quarx-image-gallery-enabled"] = FALSE;
    }

}

/* End of file hooks.php */
/* Location: ./application/hooks/ */