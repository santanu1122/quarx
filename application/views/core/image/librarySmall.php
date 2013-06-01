<?php

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

?>

<div data-role="panel" data-position="right" data-display="overlay" id="imageLibrary" class="imagePanel panelBox">
    
    <a id="imageLibraryCloseBtn" href="#" data-rel="close" data-role="button" data-icon="delete" data-iconpos="notext"></a>

    <div id="imageLibFrame"><iframe id="imageLibraryBox" src="<?php echo site_url('image'); ?>"></iframe></div>

</div>