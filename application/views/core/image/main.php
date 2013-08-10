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

<!-- notifcations -->
<div class="raw100">
    <div id="quarx-msg-box" class="<?php echo $state; ?>">
        <p><?php echo $message; ?></p>
    </div>
</div> 

<?php $this->load->view("core/image/common/menu"); ?>

<!-- javascript -->
<script type="text/javascript">
    $("#quarx-msg-box").show().delay(2500).fadeOut("slow");
</script>

<!-- End of File -->