<?php /*
    Filename:   career_menu.php
    Location:   /application/modules/careers/views/
*/ ?>

<div id="gallery_menu" class="dialogBox" title="Gallery Menu">
    <a href="<?php echo site_url('gallery/add') ?>" data-role="button" data-corners="false">Add Product Gallery</a>
    <a href="<?php echo site_url('gallery/view') ?>" data-role="button" data-corners="false">View Product Gallery</a>
</div>

<script type="text/javascript">
    function showMenu(){
        $('#gallery_menu').dialogbox({
            modal: true
        });
    }
</script>

<?php //End of file ?>