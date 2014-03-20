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

<div class="quarx-small-device">
    <h1 class="quarx-epic">Error</h1>

    <h1>Ops! You caught us offguard.</h1>

    <p><?= $error ?: "It seems that we've made a terrible error. We'll be doing our best to make sure this is fixed as soon as possible."; ?></p>

    <button onclick="javascript:history.back()">Back</button>
</div>

<?php //End of File ?>