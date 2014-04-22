<?php

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

class Fatal {

    protected $CI;

    public function shutdown()
    {
        if (ENVIRONMENT != "development")
        {
            register_shutdown_function('reportShutdown');
        }
    }
}

function reportShutdown()
{
    if (($error = error_get_last()))
    {
        header("Location: http://".$_SERVER['HTTP_HOST']."/error");
    }
}

/* End of file fatal.php */
/* Location: ./application/hooks/ */