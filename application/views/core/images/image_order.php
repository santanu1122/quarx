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
 * @since       Version 5.0
 *
 */
?>

<?php

    $positions = count($images);

    foreach($images as $img)
    {
        ?>

        <div class="raw100 raw-left image-order-block">
            <div class="raw50 raw-left">
                <div class="quarx-img-thumb-holder">
                    <img style="visibility: hidden;" class="raw-margin-top-20 raw-margin-left-20" src="<?= $img->img_thumb_location; ?>" />
                </div>
            </div>
            <div class="raw50 raw-left">
                <div class="raw-padding-20">
                    <p class="image-name"><?= $this->tools->val_trim($img->original_name, 20); ?></p>
                    <select class="collection_order_setter" data-img-id="<?= $this->crypto->encrypt($img->img_id); ?>">
                        <?php
                            if ($img->collection_order == 0) echo '<option selected value="0">?</option>';

                            foreach (range(1, $positions) as $order)
                            {
                                $selected = ($img->collection_order == $order) ? "selected" : "";
                                echo '<option '.$selected.' value="'.$order.'">'.$order.'</option>';
                            }

                            if ($img->collection_order > $positions) echo '<option selected value="'.$img->collection_order.'">'.$img->collection_order.'</option>';

                            echo '<option value="0" data-placeholder="true">Order</option>';

                        ?>
                    </select>
                </div>
            </div>
        </div>

<?php
    }

?>