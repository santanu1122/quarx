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

?>

<div data-role="panel" data-position="right" data-display="overlay" id="quarx-image-library" class="quarx-image-panel quarx-panel-box">
    
    <a id="quarx-image-library-close-btn" href="#" data-rel="close" data-role="button" data-icon="delete" data-iconpos="notext"></a>

    <div id="quarx-image-lib-frame"><iframe id="quarx-image-library-box" src="<?php echo site_url('image'); ?>"></iframe></div>

</div>