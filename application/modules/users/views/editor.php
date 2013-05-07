<?php /*
    Filename:   editor.php
    Location:   users/views
*/ ?>

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

<!-- Main Page -->

<div class="device">

    <div class="raw100">
        <a href="#" data-role="button" onclick="showMenu()">Users Menu</a>
    </div>

    <div class="raw50">
        <div class="profileImageBox mHide">  
            <?php if($u->user_img){ ?>
                <?php echo '<img src="'.$u->user_img.'" />'; ?>
            <?php } ?>
        </div>
    </div>
    <div class="raw50">
        <div id="formHolder" class="raw100 form">
            <form id="addAccount" method="post" enctype="multipart/form-data" action="<?php echo site_url('users/update_user'); ?>">
                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />

                <input type="hidden" name="user_id" size="30" value="<?php echo $u->user_id; ?>" />

                <!-- // Get to  the actual form! -->
                <div class="raw100">
                    <div class="raw33"><p>Username</p></div>
                    <div class="raw66"><p><?php echo $u->user_name; ?></p></div>
                </div>
                <div class="raw100">
                    <div class="raw33"><p>Email</p></div>
                    <div class="raw66"><input type="text" name="user_email" size="30" value="<?php echo $u->user_email; ?>" /></div>
                </div>
                <div class="raw100">
                    <div class="raw33"><p>Full Name</p></div>
                    <div class="raw66"><input class="vital" type="text" name="full_name" size="30" value="<?php echo $u->user_fullname; ?>" /></div>
                </div>
                <div class="raw100">
                    <div class="raw33"><p>Location</p></div>
                    <div class="raw66"><input id="location" type="text" name="location" size="30" value="<?php echo $u->user_location; ?>" /></div>
                </div>
                <div class="raw100">
                    <div class="raw33"><p>Bio</p></div>
                    <div class="raw66"><textarea id="bio" class="rtf" name="bio"><?php echo stripslashes($u->user_bio); ?></textarea></div>
                </div>

                <div class="raw100">
                    <div class="raw33"><p>Profile Image</p></div>
                    <div class="raw66"><input type="file" name="userfile" size="20" data-role="none" /></div>
                </div>
                <div class="raw100">
                    <div class="raw100"><input data-theme="c" class="fatButton" type="submit" value="Update User" /></div>
                </div>
            </form>
        </div>

        <?php if($u->user_status === 'disabled'){ ?>
        <div class="raw50 mHide"><button data-theme="c" onclick="enableUser('<?php echo encrypt($u->user_id); ?>')">Enable</button></div>
        <?php }else{ ?>
        <div class="raw50 mHide"><button data-theme="b" onclick="disableUser('<?php echo encrypt($u->user_id); ?>')">Disable</button></div>
        <?php } ?>
        <div class="raw50 mHide"><button data-theme="e" onclick="deleteConfirm('<?php echo encrypt($u->user_id); ?>')">Delete</button></div>
    </div>

</div>

<script type="text/javascript">

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

    $(window).load(function(){ profileImageResize() });

</script>
    
<?php //End of file ?>