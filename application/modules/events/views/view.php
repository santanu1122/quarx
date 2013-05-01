<?php /*
    Filename:   view.php
    Location:   /application/views/event
*/ ?>

<!-- Dialogs -->

<div id="dialog-confirm" class="dialogBox" title="Delete Confirmation">
    <p>Are you sure you want to delete this event?</p>
</div>

<div id="dialog-archive" class="dialogBox" title="Archive Confirmation">
    <p>Are you sure you want to archive this event?</p>
</div>

<div id="dialog-display" class="dialogBox" title="Display Confirmation">
    <p>Are you sure you want to display this event?</p>
</div>

<!-- Content -->

<div class="device">
    <div class="raw100">
        <a href="#" data-role="button" onclick="showMenu()">Events Menu</a>
    </div>

    <div class="raw100">
        <form id="SearchBox" method="post" action="<?php echo site_url('events/search'); ?>">
            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />    
            <input id="search" name="search" class="searchBar" value="Enter a Search Term" onfocus="resetSearch()" />
        </form>
    </div>

    <div class="raw100">
        <div class="raw25"><p><b>Title</b></p></div>
        <div class="raw12 tHide mHide"><p><b>Start Date</b></p></div>
        <div class="raw13 tHide mHide"><p><b>Category</b></p></div>
        <div class="raw50 mHide"><p><b>Actions</b></p></div>
    </div>

    <?php foreach ($entries as $entry): ?>
        
    <div class="raw100">
        <div class="raw25 infoBlock"><p><a href="<?php echo site_url('events/editor/'.encrypt($entry->event_id)); ?>"><?php echo valTrim($entry->event_title, 20); ?></a></p></div>
        <div class="raw12 infoBlock tHide mHide"><p><?php echo valCheck($entry->event_start_date); ?></p></div>
        <div class="raw13 infoBlock tHide mHide"><p><?php echo valCheck(getCatName($entry->event_cat)); ?></p></div>

        <div class="raw17 mHide"><button data-theme="c" onclick="window.location='<?php echo site_url('events/editor/'.encrypt($entry->event_id)); ?>'">Edit</button></div>
        <?php if($entry->event_hide === '1'){ ?>
        <div class="raw16 mHide"><button data-theme="c" onclick="displayEntry('<?php echo encrypt($entry->event_id); ?>')">Display</button></div>
        <?php }else{ ?>
        <div class="raw16 mHide"><button data-theme="b" onclick="archiveEntry('<?php echo encrypt($entry->event_id); ?>')">Archive</button></div>
        <?php } ?>
        <div class="raw16 mHide"><button data-theme="e" onclick="deleteConfirm('<?php echo encrypt($entry->event_id); ?>')">Delete</button></div>
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
                    window.location="<?php echo site_url('events/archive_entry').'/'; ?>"+id; 
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
                    window.location="<?php echo site_url('events/display_entry').'/'; ?>"+id; 
                },
                Cancel: function() {
                    dialogDestroy('#dialog-display');
                }
            }
        });
    }

</script>
    
<?php //End of file ?>