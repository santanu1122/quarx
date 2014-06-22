<?php

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

?>

<div class="quarx-small-device">
    <h2>Introduction</h2>
    <p>Quarx is a powerful and yet simplistic framework for building dynamic-modular web applications.</p>
    <p>Built on the power of CodeIgniter it provides a way to initiate a web application in minutes or add an administration layer to an existing web application.</p>

    <hr />

    <h2>Requirements</h2>
    <ul>
        <li>PHP 5.2.4+</li>
        <li>MySQL</li>
        <li>cURL</li>
    </ul>

    <hr />

    <h2>Installation</h2>
    <p><a href="<?= site_url('setup/install'); ?>">Click here to Install</a></p>

    <hr />

    <h2>Special Notes:</h2>
    <p>If you're adding Quarx to an exsiting database, you need to ensure there is not the following tables:<p>
    <ul>
        <li>users</li>
        <li>img</li>
        <li>img_categories</li>
        <li>admin</li>
    </ul>

    <p>If you wish to avoid using the installed please take the sql file and import it to the database. Then modify the following file: <b>/application/config/database.php</b>, and set it with the database user details. The master login for this install method is U: master P: master</p>

</div>
