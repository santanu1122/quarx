<?php /*
    Filename:   users_menu.php
    Location:   /views/
*/ ?>

<div id="users_menu" class="dialogBox" title="Users Menu">
    <a href="<?php echo site_url('users/add') ?>" data-role="button" data-corners="false">Add a User</a>
    <a href="<?php echo site_url('users/view') ?>" data-role="button" data-corners="false">View Users</a>
    <a href="<?php echo site_url('users/settings') ?>" data-role="button" data-corners="false">Settings</a>
</div>

<script type="text/javascript">

    function showMenu(){
        $('#users_menu').dialogbox({
            modal: true
        });
    }

</script>

<?php //End of file ?>