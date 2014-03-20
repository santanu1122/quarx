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

<select id="quarx-select-library-collections" data-theme="a" name="gallery">

</select>

<script type="text/javascript">

$("#quarx-select-library-collections").bind("click", function (){
    $.ajax({
        url: "<?php echo site_url('image/get_collections'); ?>",
        type: 'GET',
        dataType: "HTML",
        success: function(data) {
            var options = '<option value="0">None</option>'+data;
            $('#quarx-select-library-collections').html(options).selectmenu("refresh");
        }
    });
});
    
</script>

<!-- End of File -->