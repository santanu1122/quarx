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

<!-- content -->

<div class="raw100 raw-left">
    <div class="quarx-device">

        <div class="raw100 raw-left">
            <div class="raw100 raw-left">
                <?php $this->load->view("core/images/common/menu"); ?>
            </div>
            <div class="raw100 raw-left quarx-img-viewer">
            <?php

                echo '<p>Thumb (Generated)</p>';
                echo '<img class="quarx-full-size-img" src="'.$image->img_thumb_location.'" alt="'.$image->img_alt_tag.'" title="'.$image->img_title_tag.'" />';
                echo '<p>Medium (Generated)</p>';
                echo '<img class="quarx-full-size-img" src="'.$image->img_medium_location.'" alt="'.$image->img_alt_tag.'" title="'.$image->img_title_tag.'" />';
                echo '<p>Original (Scalled to fit)</p>';
                echo '<img class="quarx-full-size-img raw100" src="'.$image->img_location.'" alt="'.$image->img_alt_tag.'" title="'.$image->img_title_tag.'" />';

            ?>
            </div>
        </div>

    </div>
</div>

<!-- End of File -->