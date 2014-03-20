<?php

/**
 * Quarx
 *
 * A modular application framework built on CodeIgniter
 *
 * @package     Quarx
 * @author      Matt Lantz
 * @copyright   Copyright (c) 2013 Matt Lantz
 * @license     http://ottacon.co/quarx/license.html
 * @link        http://ottacon.co/quarx
 * @since       Version 1.0
 *
 */

?>

<div data-role="popup" id="quarx-image-library" data-overlay-theme="a" data-theme="a" data-corners="false">
    <a id="quarx-close-image-library" href="#" data-rel="back" data-role="button" data-icon="delete" data-iconpos="notext" class="ui-btn-right ui-btn-round"></a>
    <iframe src="<?= site_url('images'); ?>" class="quarx-popup" data-location="panel" seamless="true"></iframe>
</div>