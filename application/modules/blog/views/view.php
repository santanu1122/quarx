<?php /*
    Filename:   view.php
    Location:   /application/views/blog
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
    <h1>Blog Entries</h1>
    <div class="reallyTall">
        <form id="SearchBox" method="post" action="<?php echo site_url('blog/search'); ?>">
            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />    
            <input id="search" name="search" class="searchBar" value="Enter a Search Term" onfocus="resetSearch()" />
        </form>
    </div>
</div>

<div class="device">

    <div class="raw100">
        <div class="raw25"><p><b>Title</b></p></div>
        <div class="raw12"><p><b>Date</b></p></div>
        <div class="raw13"><p><b>Category</b></p></div>
        <div class="raw50"><p><b>Actions</b></p></div>
    </div>

    <?php foreach ($entries as $entry): ?>
        
    <div class="raw100">
        <div class="raw25 infoBlock"><p><?php echo valTrim($entry->blog_title, 20); ?></p></div>
        <div class="raw12 infoBlock"><p><?php echo valCheck($entry->blog_date); ?></p></div>
        <div class="raw13 infoBlock"><p><?php echo valCheck(getCatName($entry->blog_cat)); ?></p></div>

        <div class="raw17"><button data-theme="c" onclick="window.location='<?php echo site_url('blog/editor/'.encrypt($entry->blog_id)); ?>'">Edit</button></div>
        <?php if($entry->blog_hide === '1'){ ?>
        <div class="raw16"><button data-theme="c" onclick="displayEntry('<?php echo encrypt($entry->blog_id); ?>')">Display</button></div>
        <?php }else{ ?>
        <div class="raw16"><button data-theme="b" onclick="archiveEntry('<?php echo encrypt($entry->blog_id); ?>')">Archive</button></div>
        <?php } ?>
        <div class="raw16"><button data-theme="e" onclick="deleteConfirm('<?php echo encrypt($entry->blog_id); ?>')">Delete</button></div>
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
                    window.location="<?php echo site_url('blog/delete_entry').'/'; ?>"+id; 
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
                    window.location="<?php echo site_url('blog/archive_entry').'/'; ?>"+id; 
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
                    window.location="<?php echo site_url('blog/display_entry').'/'; ?>"+id; 
                },
                Cancel: function() {
                    dialogDestroy('#dialog-display');
                }
            }
        });
    }

</script>
    
<?php //End of file ?>