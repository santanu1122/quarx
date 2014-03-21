<?php /*
    Filename:   view.php
    Location:   /application/views/page
*/ ?>

<!-- Notices -->

<?php if(isset($_GET['fail'])){ ?>
<div id="error" class="error-box">
    <p>Sorry, we were unable to add this user. Please try again.</p>
</div>
<?php } ?>

<?php if(isset($_GET['efail'])){ ?>
<div id="error" class="error-box">
    <p>Sorry, we were unable to edit this user. Please try again.</p>
</div>
<?php } ?>

<?php if(isset($_GET['dfail'])){ ?>
<div id="error" class="error-box">
    <p>Sorry, we were unable to delete this user. Please try again.</p>
</div>
<?php } ?>

<?php if(isset($_GET['success'])){ ?>
<div id="success" class="success-box">
    <p>You've successfully updated a users profile!</p>
</div>
<?php } ?>

<!-- Dialogs -->

<div id="dialog-confirm" class="dialogBox" title="Delete Confirmation">
    <p>Are you sure you want to delete this user?</p>
</div>

<div id="dialog-disable" class="dialogBox" title="Disable Confirmation">
    <p>Are you sure you want to disable this user?</p>
</div>

<div id="dialog-enable" class="dialogBox" title="Enable Confirmation">
    <p>Are you sure you want to enable this user?</p>
</div>

<!-- Content -->

<div class="quarx-device">

    <div class="raw100 raw-margin-bottom-15">
        <a href="#" data-role="button" onclick="showMenu()">Users Menu</a>
    </div>

    <div class="raw100">
        <form id="SearchBox" method="post" action="<?php echo site_url('users/search'); ?>">
            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
            <input id="search" name="search" class="searchBar" data-deefault="Enter a Search Term" />
        </form>
    </div>

    <div class="raw100 mHide">
        <div class="raw25 raw-left"><p><b>User Name</b></p></div>
        <div class="raw25 raw-left"><p><b>Last Visit</b></p></div>
        <div class="raw50 raw-left"><p><b>Actions</b></p></div>
    </div>

    <?php foreach ($users as $u): ?>

    <div class="raw100">
        <div class="raw25 raw-left infoBlock"><a href="<?php echo site_url('users/editor/'.encrypt($u->user_id)); ?>"><?php echo valTrim($u->user_name, 20); ?></a></div>

        <div class="raw25 raw-left infoBlock mHide"><p><?php echo valTrim($u->last_login, 20); ?></p></div>

        <div class="raw17 raw-left mHide"><button data-theme="c" onclick="window.location='<?php echo site_url('users/editor/'.encrypt($u->user_id)); ?>'">Edit</button></div>
        <?php if($u->user_status === 'disabled'){ ?>
        <div class="raw16 raw-left mHide"><button data-theme="c" onclick="enableUser('<?php echo encrypt($u->user_id); ?>')">Enable</button></div>
        <?php }else{ ?>
        <div class="raw16 raw-left mHide"><button data-theme="b" onclick="disableUser('<?php echo encrypt($u->user_id); ?>')">Disable</button></div>
        <?php } ?>
        <div class="raw16 raw-left mHide"><button data-theme="e" onclick="deleteConfirm('<?php echo encrypt($u->user_id); ?>')">Delete</button></div>
    </div>

    <?php endforeach; ?>

</div>

<script type="text/javascript">

    $('#search').deefault();

    function deleteConfirm(id){
        $( "#dialog-confirm" ).dialogbox({
            buttons: {
                Ok: function() {
                    window.location="<?php echo site_url('users/delete_user').'/'; ?>"+id;
                },
                Cancel: function() {
                    dialogDestroy('#dialog-confirm');
                }
            }
        });
    }

    function enableUser(id){
        $( "#dialog-enable" ).dialogbox({
            buttons: {
                Ok: function() {
                    window.location="<?php echo site_url('users/enable_user').'/'; ?>"+id;
                },
                Cancel: function() {
                    dialogDestroy('#dialog-enable');
                }
            }
        });
    }

    function disableUser(id){
        $( "#dialog-disable" ).dialogbox({
            buttons: {
                Ok: function() {
                    window.location="<?php echo site_url('users/disable_user').'/'; ?>"+id;
                },
                Cancel: function() {
                    dialogDestroy('#dialog-disable');
                }
            }
        });
    }

    $(document).ready(function(){
        hideSuccessErrors();
    });

</script>

<?php //End of file ?>