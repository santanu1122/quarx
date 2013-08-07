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

<select id="quarx-select-library-collections" data-theme="a" name="gallery">
    <option value="0">Collections</option>
    <?php foreach ($collection as $col) { ?>
        
        <?php echo '<option value="'.$col->collection_id.'">'.$col->collection_name.'</option>'; ?>

    <?php } ?>
</select>

<!-- End of File -->