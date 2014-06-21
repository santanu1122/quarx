<?php

/**
 * Quarx
 *
 * A modular CMS application
 *
 * @package     Quarx
 * @author      Matt Lantz
 * @copyright   Copyright (c) 2013 - 2014 Matt Lantz
 * @license     https://ottacon.co/docs/quarx/license.html
 * @link        https://github.com/mlantz/quarx
 * @since       Version 1.0
 *
 */

class Hooks {

    protected $CI;

    public function hooks()
    {
        $this->CI =& get_instance();
    }

    public function init()
    {
        $GLOBALS["quarx"] = array(
            "quarx-image-library-enabled" => FALSE
        );

        $CI =& get_instance();

        $config = $CI->config->item('carabiner_config');
        $config['base_uri'] = base_url();

        $CI->carabiner->config($config);
        $CI->carabiner->empty_cache('both', 'yesterday');
    }

}

/* End of file hooks.php */
/* Location: ./application/hooks/ */