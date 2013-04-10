<?php

/* Filename: library.php
 * Location: application/views/core/image
 */

?>

<div data-role="panel" data-position="right" data-display="overlay" id="imageLibrary" class="imagePanel panelBox">
    
    <a id="imageLibraryCloseBtn" href="#" data-rel="close" data-role="button" data-icon="delete" data-iconpos="notext"></a>

    <div id="imageLibFrame"><iframe id="imageLibraryBox" src="<?php echo site_url('image'); ?>"></iframe></div>

</div>