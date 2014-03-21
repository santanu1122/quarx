<?php /*
    Filename:   users_menu.php
    Location:   /views/
*/ ?>

<div id="inbox_menu" class="dialogBox" title="Inbox Menu">
    <a href="<?php echo site_url('inbox/compose') ?>" data-role="button" data-corners="false">Compose</a>
    <a href="<?php echo site_url('inbox/view') ?>" data-role="button" data-corners="false">View Inbox</a>
    <a href="<?php echo site_url('inbox/settings') ?>" data-role="button" data-corners="false">Settings</a>
</div>

<script type="text/javascript">

    function showMenu(){
        $('#inbox_menu').dialogbox({
            modal: true
        });
    }

</script>

<?php //End of file ?>