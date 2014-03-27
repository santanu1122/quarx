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

?>

<div class="quarx-img-box">

    <a href="#imageLibraryMenu" data-rel="popup" data-role="button" data-theme="a" data-transition="fade">Images Menu</a>

    <div data-role="popup" id="imageLibraryMenu">
        <ul data-role="listview" data-inset="true" style="width:240px;" data-theme="a">
            <li><a href="<?php echo site_url('images/add'); ?>">Upload Images</a></li>
            <li><a href="<?php echo site_url('images/library'); ?>">View All Collections</a> </li>
            <li><a href="<?php echo site_url('images/manager'); ?>">Manage Collections</a></li>
        </ul>
    </div>

</div>