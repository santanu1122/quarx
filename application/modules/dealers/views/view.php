<?php /*
    Filename:   view.php
    Location:   /application/views/page
*/ ?>

<!-- Dialogs -->

<div id="dialog-confirm" class="dialogBox" title="Delete Confirmation">
    <p>Are you sure you want to delete this entry?</p>
</div>

<div id="dialog-archive" class="dialogBox" title="Archive Confirmation">
    <p>Are you sure you want to archive this entry?</p>
</div>

<div id="dialog-display" class="dialogBox" title="Display Confirmation">
    <p>Are you sure you want to display this entry?</p>
</div>

<!-- Content -->

<div class="device">

    <div class="raw100">
        <a href="#" data-role="button" onclick="showMenu()">Pages Menu</a>
    </div>

    <div class="raw100">
        <form id="SearchBox" method="post" action="<?php echo site_url('page/search'); ?>">
            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />    
            <input id="search" name="search" class="searchBar" value="Enter a Search Term" onfocus="resetSearch()" />
        </form>
    </div>

    <div class="raw100">
        <div class="raw25"><p><b>Title</b></p></div>
        <div class="raw25"><p><b>Parent Page</b></p></div>
        <div class="raw50"><p><b>Actions</b></p></div>
    </div>

    <?php foreach ($entries as $entry): ?>
        
    <div class="raw100">
        <div class="raw25 infoBlock"><p><?php echo valTrim($entry->page_title, 20); ?></p></div>
        <div class="raw25 infoBlock"><p><?php echo valCheck(getParentName($entry->page_parent)); ?></p></div>

        <div class="raw17"><button data-theme="c" onclick="window.location='<?php echo site_url('pages/editor/'.encrypt($entry->page_id)); ?>'">Edit</button></div>
        <?php if($entry->page_hide === '1'){ ?>
        <div class="raw16"><button data-theme="c" onclick="displayEntry('<?php echo encrypt($entry->page_id); ?>')">Display</button></div>
        <?php }else{ ?>
        <div class="raw16"><button data-theme="b" onclick="archiveEntry('<?php echo encrypt($entry->page_id); ?>')">Archive</button></div>
        <?php } ?>
        <div class="raw16"><button data-theme="e" onclick="deleteConfirm('<?php echo encrypt($entry->page_id); ?>')">Delete</button></div>
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
                    window.location="<?php echo site_url('pages/archive_entry').'/'; ?>"+id; 
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
                    window.location="<?php echo site_url('pages/display_entry').'/'; ?>"+id; 
                },
                Cancel: function() {
                    dialogDestroy('#dialog-display');
                }
            }
        });
    }

</script>
    
<?php //End of file ?>