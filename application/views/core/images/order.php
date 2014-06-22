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

<!-- main content -->

<div class="raw100 raw-left">
    <div class="quarx-small-device">
        <div class="raw100 raw-left">
            <div class="raw100 raw-left">
                <div class="quarx-img-box">
                    <?php $this->load->view("core/images/common/menu"); ?>
                    <select id="collectionsOrder" data-theme="a">
                        <?php

                            foreach ($collections as $collection)
                            {
                                echo '<option value="'.$collection->collection_id.'">'.$collection->collection_name.'</option>';
                            }


                        ?>
                    </select>
                </div>
            </div>
            <div class="raw100 raw-left order-container raw-margin-top-20">
                <!-- populated by ajax -->
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    var _collectionID = <?= $collections[0]->collection_id; ?>;
</script>

<?php $this->carabiner->display("quarx-images-js"); ?>

<script type="text/javascript">
    loadCollection(_collectionID);
</script>

<!-- End of File -->