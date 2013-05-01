<?php /*
    Filename:   blog_menu.php
    Location:   /application/modules/blog/views/
*/ ?>

<div id="blog_menu" class="dialogBox" title="Blog Menu">
    <a href="<?php echo site_url('blog/add') ?>" data-role="button" data-corners="false">Add Entry</a>
    <a href="<?php echo site_url('blog/view') ?>" data-role="button" data-corners="false">View Entries</a>
</div>

<script type="text/javascript">
    function showMenu(){
        $('#blog_menu').dialogbox({
            modal: true
        });
    }
</script>

<?php //End of file ?>