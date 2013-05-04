<?php /*
    Filename:   users.php
    Location:   /views
*/ ?>

<!-- Notices -->

<!-- <div id="entryUpdated" class="updateBox">
    <p>Your update was successful!</p>
</div>

<div id="entryAdded" class="updateBox">
    <p>Your entry was successfully added!</p>
</div>

<div id="entryFailed" class="errorBox">
    <p>Sorry, adding this entry failed. Are you sure you don't have an entry with the same title?</p>
</div>

<div id="catFailed" class="errorBox">
    <p>Sorry, adding this category failed. Are you sure you don't have a category with the same title?</p>
</div>
 -->
<!-- Dialogs -->

<!-- <div id="dialog-cat" class="dialogBox" title="Delete Confirmation">
    <p>Are you sure you want to delete this category?</p>
</div>

<div id="dialog-oops" class="dialogBox" title="Oops!">
    <p>Sorry, but you can't delete a category that has entries :(</p>
</div> -->

<!-- Main Page -->

<div class="device">

    <div class="raw100">
        <a href="#" data-role="button" onclick="showMenu()">Users Menu</a>
    </div>

    <div id="formHolder" class="raw100 form">
        <form id="addAccount" method="post" enctype="multipart/form-data" action="<?php echo site_url('accounts/add_profile'); ?>">
            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
            <!-- // These are the hidden fields with the lat and lng values -->
            <input id="latBox" type="hidden" name="latitude" size="30" value="" />
            <input id="lngBox" type="hidden" name="longitude" size="30" value="" />

            <!-- // Get to  the actual form! -->
            <div class="raw100">
                <div class="raw33"><p>Username</p></div>
                <div class="raw66"><input id="u_name" type="text" name="user_name" size="30" value="" onkeyup="validationCheck(this.value)" /></div>
            </div>
            <div class="raw100">
                <div class="raw33"><p>Email</p></div>
                <div class="raw66"><input data-type="Email" class="vital" type="text" name="user_email" size="30" value="" /></div>
            </div>
            <div class="raw100">
                <div class="raw33"><p>Full Name</p></div>
                <div class="raw66"><input class="vital" type="text" name="full_name" size="30" value="" /></div>
            </div>
            <div class="raw100">
                <div class="raw33"><p>Location</p></div>
                <div class="raw66"><input id="location" type="text" name="location" size="30" value="" onblur="locateMe('<?php echo $root; ?>', this.value, '')" /></div>
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
                <div class="raw100"><input class="fatButton" type="submit" value="Add User" /></div>
            </div>
        </form>
    </div>

</div>

<script type="text/javascript">

/* Entry Functions
***************************************************************/

    function addUser() {
        var pagesName = $("#pagesName").val(),
            parentOptions = $("#parentOptions").val(),
            pagesEntry = $("#pagesEntry").val(),
            pages_img_library = $('#selectLibrary-Collections').val();

        if(parentOptions === ''){
            alert('Sorry we need more information.');
        }else{
            $.ajax({
                url: "<?php echo site_url('pages/add_entry'); ?>",
                type: 'POST',
                cache: false,
                data: { 
                    page_name: pagesName, 
                    page_parent: parentOptions,
                    page_entry: pagesEntry,
                    page_img_library: pages_img_library,
                    <?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>'
                },
                success: function(data) {
                    if(data == 'duplicate title'){
                        $("#entryFailed").fadeIn();
                        setTimeout(function(){ $("#entryFailed").fadeOut(); }, 2500);
                    }else{
                        modeSwitch(data);
                        $("#entryAdded").fadeIn();
                        setTimeout(function(){ $("#entryAdded").fadeOut(); }, 1500);
                    }
                }
            });
        }
    }

    function updateUser(id) {
        var uppagesName = $("#pagesName").val(),
            upparentOptions = $("#parentOptions").val(),
            uppagesEntry = $("#pagesEntry").val(),
            uppages_img_library = $('#selectLibrary-Collections').val();

        if(upparentOptions === ''){
            alert('Sorry we need more information.');
        }else{
            $.ajax({
                url: "<?php echo site_url('pages/update_entry'); ?>",
                type: 'POST',
                cache: false,
                data: {
                    page_id: id,
                    page_name: uppagesName, 
                    page_parent: upparentOptions,
                    page_entry: uppagesEntry,
                    page_img_library: uppages_img_library,
                    <?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>'
                },
                success: function(data) {
                    $("#entryUpdated").fadeIn();
                    setTimeout(function(){ $("#entryUpdated").fadeOut(); }, 1500);
                }
            });
        }
    }

    function modeSwitch(id) {
        $("#addEntryButtonBox").attr('onclick', 'updateEntry('+id+')');
        $("#addEntryButtonBox").siblings('.ui-btn-inner').children('.ui-btn-text').text("Update Entry");
    }

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
                }else{
                    $('#u_name').parent().css({
                        border: '1px solid #61B329'
                    });
                }
            }
        });
    }

</script>
    
<?php //End of file ?>