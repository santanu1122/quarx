<?php /*
    Filename:   gallery_menu.php
    Location:   /application/modules/gallery/views/
*/ ?>

<div id="gallery_menu" class="dialogBox" title="Gallery Menu">
    <a href="<?php echo site_url('gallery/add') ?>" data-role="button" data-corners="false">Add Entry</a>
    <a href="<?php echo site_url('gallery/view') ?>" data-role="button" data-corners="false">View Entries</a>
</div>

<script type="text/javascript">
    function showMenu(){
        $('#gallery_menu').dialogbox({
            modal: true
        });
    }
</script>

<?php //End of file ?>