<?php /*
    Filename:   pages_menu.php
    Location:   /views/
*/ ?>

<div id="pages_menu" class="dialogBox" title="Pages Menu">
    <a href="<?php echo site_url('pages/add') ?>" data-role="button" data-corners="false">Add Page</a>
    <a href="<?php echo site_url('pages/view') ?>" data-role="button" data-corners="false">View Pages</a>
</div>

<script type="text/javascript">

    function showMenu(){
        $('#pages_menu').dialogbox({
            modal: true
        });
    }

</script>

<?php //End of file ?>