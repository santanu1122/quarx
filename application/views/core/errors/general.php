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

<div id="container">
    <div style="padding: 20px;">
        <h1>We've encountered an error.</h1>
        <?php echo $error; ?>
        <br />
        <br />
        <br />
        <button style="padding: 15px;" onclick="window.history.back()">Back</button>
    </div>
</div>

<?php //End of File ?>