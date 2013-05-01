<?php /*
    Filename:   view.php
    Location:   /application/views/page
*/ ?>

<!-- Dialogs -->

<div id="dialog-confirm" class="dialogBox" title="Delete Confirmation">
    <p>Are you sure you want to delete this user?</p>
</div>

<div id="dialog-disable" class="dialogBox" title="Disable Confirmation">
    <p>Are you sure you want to disable this user?</p>
</div>

<div id="dialog-enable" class="dialogBox" title="Enable Confirmation">
    <p>Are you sure you want to enable this u?</p>
</div>

<!-- Content -->

<div class="device">

    <div class="raw100">
        <a href="#" data-role="button" onclick="showMenu()">Users Menu</a>
    </div>

    <div class="raw100">
        <form id="SearchBox" method="post" action="<?php echo site_url('user/search'); ?>">
            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />    
            <input id="search" name="search" class="searchBar" value="Enter a Search Term" onfocus="resetSearch()" />
        </form>
    </div>

    <div class="raw100 mHide">
        <div class="raw25"><p><b>User Name</b></p></div>
        <div class="raw25"><p><b>Last Visit</b></p></div>
        <div class="raw50"><p><b>Actions</b></p></div>
    </div>

    <?php foreach ($users as $u): ?>
        
    <div class="raw100">
        <div class="raw25 infoBlock"><a href="<?php echo site_url('users/editor/'.encrypt($u->user_id)); ?>"><?php echo valTrim($u->user_name, 20); ?></a></div>

        <div class="raw25 infoBlock mHide"><p><?php echo valTrim($u->last_login, 20); ?></p></div>

        <div class="raw17 mHide"><button data-theme="c" onclick="window.location='<?php echo site_url('users/editor/'.encrypt($u->user_id)); ?>'">Edit</button></div>
        <?php if($u->user_status === 'disabled'){ ?>
        <div class="raw16 mHide"><button data-theme="c" onclick="enableUser('<?php echo encrypt($u->user_id); ?>')">Enable</button></div>
        <?php }else{ ?>
        <div class="raw16 mHide"><button data-theme="b" onclick="disableUser('<?php echo encrypt($u->user_id); ?>')">Disable</button></div>
        <?php } ?>
        <div class="raw16 mHide"><button data-theme="e" onclick="deleteUser('<?php echo encrypt($u->user_id); ?>')">Delete</button></div>
    </div>

    <?php endforeach; ?>

</div>

<script type="text/javascript">

    function resetSearch(){
        $('#search').val('');
        $('#search').css('color','#222');
    }

/* Entry Actions
***************************************************************/

    function deleteConfirm(id){    
        $( "#dialog-confirm" ).dialogbox({
            buttons: {
                Ok: function() {
                    window.location="<?php echo site_url('pages/delete_u').'/'; ?>"+id; 
                },
                Cancel: function() {
                    dialogDestroy('#dialog-confirm');
                }
            }
        });
    }

    function archiveEntry(id){
        $( "#dialog-archive" ).dialogbox({
            buttons: {
                Ok: function() {
                    window.location="<?php echo site_url('pages/archive_u').'/'; ?>"+id; 
                },
                Cancel: function() {
                    dialogDestroy('#dialog-archive');
                }
            }
        });
    }

    function displayEntry(id){    
        $( "#dialog-display" ).dialogbox({
            buttons: {
                Ok: function() {
                    window.location="<?php echo site_url('pages/display_u').'/'; ?>"+id; 
                },
                Cancel: function() {
                    dialogDestroy('#dialog-display');
                }
            }
        });
    }

</script>
    
<?php //End of file ?>