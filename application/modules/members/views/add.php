<?php /*
    Filename:   add.php
    Location:   /views
*/ ?>

<!-- Main Page -->

<div class="quarx-device">

    <div class="raw100">
        <a href="#" data-role="button" onclick="showMenu()">Users Menu</a>
    </div>

    <div id="formHolder" class="raw100 form">
        <form id="addAccount" method="post" enctype="multipart/form-data" action="<?php echo site_url('users/add_user'); ?>">
            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />

            <!-- // Get to  the actual form! -->
            <div class="raw100">
                <div class="raw33"><p>Username</p></div>
                <div class="raw66"><input id="u_name" type="text" name="user_name" size="30" value="" onkeyup="validationCheck(this.value)" /></div>
            </div>
            <div class="raw100">
                <div class="raw33"><p>Email</p></div>
                <div class="raw66"><input type="text" name="user_email" size="30" value="" /></div>
            </div>
            <div class="raw100">
                <div class="raw33"><p>Full Name</p></div>
                <div class="raw66"><input type="text" name="full_name" size="30" value="" /></div>
            </div>
            <div class="raw100">
                <div class="raw33"><p>Location</p></div>
                <div class="raw66"><input id="location" type="text" name="location" size="30" value="" /></div>
            </div>
            <div class="raw100">
                <div class="raw33"><p>Bio</p></div>
                <div class="raw66"><textarea id="bio" class="rtf" name="bio"></textarea></div>
            </div>

            <div class="raw100">
                <div class="raw33"><p>Profile Image</p></div>
                <div class="raw66"><input type="file" name="userfile" size="20" data-role="none" /></div>
            </div>
            <div class="raw100">
                <div class="raw100"><input id="adduser" class="fatButton" type="submit" value="Add User" /></div>
            </div>
        </form>
    </div>

</div>

<script type="text/javascript">

/* Page Functions
***************************************************************/

    function validationCheck(name){
        $.ajax({
            type: 'GET',
            url: "<?php echo site_url('users/unc'); ?>/"+name,
            dataType: "html",
            success: function(data){
                if(data == 1){
                    $('#u_name').parent().css({
                        border: '1px solid #f00'
                    });
                    $('#adduser').attr('disabled', 'disabled');
                }else{
                    $('#u_name').parent().css({
                        border: '1px solid #61B329'
                    });
                    $('#adduser').removeAttr('disabled');
                }
            }
        });
    }

</script>
    
<?php //End of file ?>