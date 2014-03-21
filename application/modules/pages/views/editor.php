<?php /*
    Filename:   pages.php
    Location:   /application/views/pages
*/ ?>

<!-- Notices -->

<div id="entryUpdated" class="success-box">
    <p>Your update was successful!</p>
</div>

<div id="entryAdded" class="success-box">
    <p>Your entry was successfully added!</p>
</div>

<div id="entryFailed" class="error-box">
    <p>Sorry, adding this entry failed. Are you sure you don't have an entry with the same title?</p>
</div>

<div id="catFailed" class="error-box">
    <p>Sorry, adding this category failed. Are you sure you don't have a category with the same title?</p>
</div>

<!-- Dialogs -->

<div id="dialog-cat" class="dialogBox" title="Delete Confirmation">
    <p>Are you sure you want to delete this category?</p>
</div>

<div id="dialog-oops" class="dialogBox" title="Oops!">
    <p>Sorry, but you can't delete a category that has entries :(</p>
</div>

<div id="dialog-confirm" class="dialogBox" title="Delete Confirmation">
    <p>Are you sure you want to delete this entry?</p>
</div>

<div id="dialog-archive" class="dialogBox" title="Archive Confirmation">
    <p>Are you sure you want to archive this entry?</p>
</div>

<div id="dialog-display" class="dialogBox" title="Display Confirmation">
    <p>Are you sure you want to display this entry?</p>
</div>

<!-- Main Page -->

<div class="quarx-device">

    <div class="raw100">
        <a href="#" data-role="button" onclick="showMenu()">Pages Menu</a>
    </div>

    <div class="raw100">
        <?php echo imageGalleryButton(); ?>
    </div>

    <div class="raw100">
        <div class="raw100">
            <div id="PageEntries" class="wide_box align-left wide90">
                
                <div class="raw100">
                    
                    <div class="raw100">
                        <div class="pad15">
                            <input type="text" id="pagesName" name="pages_title" value="<?php echo htmlspecialchars($pages->page_title); ?>" />
                        </div>
                    </div>

                    <div class="raw100">
                        <select id="parentOptions" data-theme="a" name="page_parent">
                        <!-- // options are fed via ajax -->
                        </select>
                    </div>
                </div>
                <div class="raw100 tall">
                    <textarea id="pagesEntry" class="rtf" name="entry"><?php echo $pages->page_entry; ?></textarea>
                </div>

                <?php echo imgLibrarySelect($pages->page_img_library); ?>

                <div id="SubmitBtnBox" class="raw100">
                    <button id="addEntryButtonBox" data-theme="c" onclick="updateEntry(<?php echo $pages->page_id; ?>)">Update Entry</button>
                </div>

            </div>

            <div class="raw100">
                <?php if($pages->page_hide === '1'){ ?>
                <button data-theme="c" onclick="displayEntry('<?php echo encrypt($pages->page_id); ?>')">Display</button>
                <?php }else{ ?>
                <button  data-theme="b" onclick="archiveEntry('<?php echo encrypt($pages->page_id); ?>')">Archive</button>
                <?php } ?>
                <button  data-theme="e" onclick="deleteConfirm('<?php echo encrypt($pages->page_id); ?>')">Delete</button>
            </div> 

        </div>
        
    </div>

</div>

<script type="text/javascript">

/* Entry Functions
***************************************************************/

    function updateEntry(id) {
        var uppagesName = $("#pagesName").val(),
            uppagesDate = $("#pagesDate").val(),
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
                    page_date: uppagesDate,
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

/* Parent Functions
***************************************************************/

    function getParentOptions() {        
        $.ajax({
            url: "<?php echo site_url('pages/options'); ?>",
            type: 'GET',
            cache: false,
            dataType: 'html',
            success: function(data) {
                $("#parentOptions").html('<option value="<?php echo $pages->page_parent; ?>">Currently: <?php echo getParentName($pages->page_parent); ?></option>'+data).selectmenu('refresh', true);
            }
        });
    }

/* Entry Actions
***************************************************************/

    function deleteConfirm(id){    
        $( "#dialog-confirm" ).dialogbox({
            buttons: {
                Ok: function() {
                    window.location="<?php echo site_url('pages/delete_entry').'/'; ?>"+id; 
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
                    window.location="<?php echo site_url('pages/archive_this_entry').'/'; ?>"+id; 
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
                    window.location="<?php echo site_url('pages/display_this_entry').'/'; ?>"+id; 
                },
                Cancel: function() {
                    dialogDestroy('#dialog-display');
                }
            }
        });
    }

/* Page Functions
***************************************************************/
    
    $(document).ready(function(e) {
        getParentOptions();
    });

</script>
    
<?php //End of file ?>