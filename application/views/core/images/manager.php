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

<!-- dialogs -->

<div id="dialog-img" title="Delete Confirmation" class="dialogBox">
    <div class="dialogbox_body">
        <p>Are you sure you want to delete this image collection?</p>
    </div>
</div>

<div id="dialog-newColl" class="dialogBox" title="New Collection">
    <div class="dialogbox_body">
        <input onfocus="this.value=''" data-theme="a" id="collectionName" type="text" value="Collection Name" />
    </div>
</div>

<!-- main content -->

<?php $this->load->view("core/images/common/menu"); ?>

<div class="quarx-img-box align-center">
    <a id="quarx-new-collection" href="#" data-role="button" data-icon="plus" data-theme="a">New Collection</a>

    <?php

        foreach ($collection as $c)
        {
            echo '<a href="#" onclick="deleteMe(\''.$this->crypto->encrypt($c->collection_id).'\')" data-role="button" data-theme="e" data-icon="delete">'.$c->collection_name.'</a>';
        }

    ?>

</div>

<script type="text/javascript">

    var _quarxCollectionManager = true,
        _collectionID = 'null';

</script>

<?php $this->carabiner->display("quarx-images-js"); ?>

<!-- End of File -->