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

<div class="quarx-small-device">
    <h1 class="quarx-epic">Error</h1>
    <h1>Ops! You caught us offguard.</h1>
    <p>It seems that we've made a terrible error. We'll be doing our best to make sure this is fixed as soon as possible.</p>
    <p><?php if($this->session->flashdata('error')){ echo $this->session->flashdata('error'); } ?></p>
    <button onclick="javascript:history.back()">Back</button>
</div>

<?php //End of File ?>