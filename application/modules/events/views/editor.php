<?php /*
    Filename:   event.php
    Location:   /application/views/event
*/ ?>

<!-- Notices -->

<div id="entryUpdated" class="success-box">
    <p>Your update was successful!</p>
</div>

<div id="entryAdded" class="success-box">
    <p>Your entry was successfully added!</p>
</div>

<div id="entryFailed" class="error-box">
    <p>Sorry, adding this entry failed. Are you sure you don't have an event with the same title?</p>
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
    <p>Are you sure you want to delete this event?</p>
</div>

<div id="dialog-archive" class="dialogBox" title="Archive Confirmation">
    <p>Are you sure you want to archive this event?</p>
</div>

<div id="dialog-display" class="dialogBox" title="Display Confirmation">
    <p>Are you sure you want to display this event?</p>
</div>

<!-- Main Page -->

<div class="quarx-device">

    <div class="raw100">
        <a href="#" data-role="button" onclick="showMenu()">Event Menu</a>
    </div>

    <div class="raw100">
        <?php echo imageGalleryButton(); ?>
    </div>

    <div class="raw66">
        <div class="raw100">
            <div id="BlogEntries" class="wide_box align-left wide90">
                
                <div class="raw100">

                    <div class="raw100">
                        <div class="pad15">
                            <input type="text" id="eventName" name="event_title" value="<?php echo htmlspecialchars($events->event_title); ?>" />
                        </div>
                    </div>

                    <div class="raw50">
                        <div class="pad15">
                            <input id="eventStartDate" type="date" name="event_date" data-role="datebox" data-options='{"fixDateArrays": true, "blackDates":["2012-1-2","2012-01-04"], "mode": "calbox", "useNewStyle": true}' value="<?php echo $events->event_start_date; ?>" />
                        </div>
                    </div>

                    <div class="raw50">
                        <div class="pad15">
                            <input id="eventEndDate" type="date" name="event_date" data-role="datebox" data-options='{"fixDateArrays": true, "blackDates":["2012-1-2","2012-01-04"], "mode": "calbox", "useNewStyle": true}' value="<?php echo $events->event_end_date; ?>" />
                        </div>
                    </div>
                    
                    <div class="raw100">
                        <select id="catOptions" data-theme="a" name="event_cat">
                        <!-- // options are fed via ajax -->
                        </select>
                    </div>
                </div>
                <div class="raw100 tall">
                    <textarea id="eventEntry" class="rtf" name="entry"><?php echo $events->event_entry; ?></textarea>
                </div>

                <?php echo imgLibrarySelect($events->event_img_library, "img_lib"); ?>

                <div id="SubmitBtnBox" class="raw100">
                    <button id="addEntryButtonBox" data-theme="c" onclick="updateEntry(<?php echo $events->event_id; ?>)">Update Event</button>
                </div>

            </div>

            <div class="raw100">
                <?php if($events->event_hide === '1'){ ?>
                <button data-theme="c" onclick="displayEntry('<?php echo encrypt($events->event_id); ?>')">Display</button>
                <?php }else{ ?>
                <button  data-theme="b" onclick="archiveEntry('<?php echo encrypt($events->event_id); ?>')">Archive</button>
                <?php } ?>
                <button  data-theme="e" onclick="deleteConfirm('<?php echo encrypt($events->event_id); ?>')">Delete</button>
            </div> 

        </div>
        
    </div>

    <div class="raw33">
        <div class="pad15 form">
            <h2>Categories</h2>
            <div class="raw75">
                <input id="add_category" type="text" name="category" value="Add a Category" onfocus="this.value=''" />
            </div>
            <div class="raw25 plusBtn">
                <button onclick="addCategory()" data-iconpos="notext" data-icon="plus"></button>
            </div>
            <div id="view_cats" class="raw100 align-left" style="margin-top: 20px;">
        </div>
        
        </div>
    </div>

</div>

<script type="text/javascript">

/* Entry Functions
***************************************************************/

    function updateEntry(id) {
        var upeventName = $("#eventName").val(),
            upStartDate = $("#eventStartDate").val(),
            upEndDate = $("#eventEndDate").val(),
            upcatOptions = $("#catOptions").val(),
            upeventEntry = $("#eventEntry").val(),
            upevent_img_library = $('#img_lib').val();

        if(catOptions === ''){
            alert('Sorry we need more information.');
        }else{
            $.ajax({
                url: "<?php echo site_url('events/update_entry'); ?>",
                type: 'POST',
                cache: false,
                data: {
                    event_id: id,
                    event_name: upeventName, 
                    event_cat: upcatOptions,
                    event_start_date: upStartDate,
                    event_end_date: upEndDate,
                    event_entry: upeventEntry,
                    event_img_library: upevent_img_library,
                    <?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>'
                },
                success: function(data) {
                    $("#entryUpdated").fadeIn();
                    setTimeout(function(){ $("#entryUpdated").fadeOut(); }, 1500);
                }
            });
        }
    }

/* Category Functions
***************************************************************/

    function getCategories() {        
        $.ajax({
            url: "<?php echo site_url('events/event_categories/view'); ?>",
            type: 'GET',
            cache: false,
            dataType: 'html',
            success: function(data) {
                $("#view_cats").html(data).trigger('create');
            }
        });
    }

    function getCatOptions() {        
        $.ajax({
            url: "<?php echo site_url('events/event_categories/options'); ?>",
            type: 'GET',
            cache: false,
            dataType: 'html',
            success: function(data) {
                $("#catOptions").html('<option value="<?php echo $events->event_cat; ?>">Currently: <?php echo getCatName($events->event_cat); ?></option>'+data).selectmenu('refresh', true);
            }
        });
    }

    function addCategory() {
        var cat = $('#add_category').val();
        
        $.ajax({
            url: "<?php echo site_url('events/event_categories/check_title'); ?>",
            type: 'POST',
            cache: false,
            data: { cat_name: cat, <?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>' },
            success: function(data) {
                if(data == 'success'){
                    $.ajax({
                        url: "<?php echo site_url('events/event_categories/add'); ?>",
                        type: 'POST',
                        cache: false,
                        data: { cat_name: cat, <?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>' },
                        success: function(data) {
                            getCatOptions();
                            getCategories();
                            $('#add_category').val('');
                        }
                    });
                }else{
                    $("#catFailed").fadeIn();
                    setTimeout(function(){ $("#catFailed").fadeOut(); }, 3500);
                }
            }
        });
    }

    function deleteCat(id){
        $( "#dialog-cat" ).dialogbox({
            buttons: {
                Ok: function() {
                    $.ajax({
                        url: "<?php echo site_url('events/event_categories/delete'); ?>",
                        type: 'POST',
                        cache: false,
                        data: { cat_id: id, <?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>' },
                        success: function(data) {
                            if(data == 'success'){
                                getCategories();
                                getCatOptions();
                                dialogDestroy( "#dialog-cat" );    
                            }else{
                                dialogDestroy( "#dialog-cat" );
                                oops();
                            }
                            
                        }
                    });
                },
                Cancel: function() {
                    dialogDestroy( "#dialog-cat" );
                }
            }
        });
    }

    function oops(){
        $( "#dialog-oops" ).dialogbox({
            buttons: {
                Ok: function() {
                    dialogDestroy( "#dialog-oops" );
                },
                Cancel: false
            }
        });
    }

/* Entry Actions
***************************************************************/

    function deleteConfirm(id){    
        $( "#dialog-confirm" ).dialogbox({
            buttons: {
                Ok: function() {
                    window.location="<?php echo site_url('events/delete_entry').'/'; ?>"+id; 
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
                    window.location="<?php echo site_url('events/archive_this_entry').'/'; ?>"+id; 
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
                    window.location="<?php echo site_url('events/display_this_entry').'/'; ?>"+id; 
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
        getCategories();
        getCatOptions();
    });

</script>
    
<?php //End of file ?>