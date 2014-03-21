<?php /*
    Filename:   view.php
    Location:   /application/views/gallery
*/?>

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

<div class="quarx-device">

    <div class="raw100">
        <a href="#" data-role="button" onclick="showMenu()">Gallery Menu</a>
    </div>

    <div class="raw100">
        <form id="SearchBox" method="post" action="<?php echo site_url('gallery/search'); ?>">
            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />    
            <input id="search" name="search" class="searchBar" data-deefault="Enter a Search Term" />
        </form>
    </div>

    <div class="raw100 mHide">
        <div class="raw50"><p><b>Products</b></p></div>
        <div class="raw50"><p><b>Actions</b></p></div>
    </div>

    <?php foreach ($products as $p): ?>
        
    <div class="raw100 gallery-row">
        <div class="raw50"><a href="<?php echo site_url('gallery/editor/'.encrypt($p->gallery_id)); ?>"><?php echo valTrim($p->gallery_name, 60); ?></a></div>

        <div class="raw17 mHide"><button data-theme="c" data-mini="true" onclick="window.location='<?php echo site_url('gallery/editor/'.encrypt($p->gallery_id)); ?>'">Edit</button></div>
        <?php if($p->gallery_hide === '1'){ ?>
        <div class="raw16 mHide"><button data-theme="c" data-mini="true" onclick="displayEntry('<?php echo encrypt($p->gallery_id); ?>')">Display</button></div>
        <?php }else{ ?>
        <div class="raw16 mHide"><button data-theme="b" data-mini="true" onclick="archiveEntry('<?php echo encrypt($p->gallery_id); ?>')">Archive</button></div>
        <?php } ?>
        <div class="raw16 mHide"><button data-theme="e" data-mini="true" onclick="deleteConfirm('<?php echo encrypt($p->gallery_id); ?>')">Delete</button></div>
    </div>

    <?php endforeach; ?>

    <div class="raw100">
        <?php echo $this->pagination->create_links(); ?>
    </div>

</div>

<script type="text/javascript">

    $('#search').deefault();

/* Entry Actions
***************************************************************/

    function deleteConfirm(id) {
        $( "#dialog-confirm" ).dialogbox({
            buttons: {
                Ok: function() {
                    window.location="<?php echo site_url('gallery/delete_entry').'/'; ?>"+id; 
                },
                Cancel: function() {
                    dialogDestroy('#dialog-confirm');
                }
            }
        });
    }

    function archiveEntry(id) {
        $( "#dialog-archive" ).dialogbox({
            buttons: {
                Ok: function() {
                    window.location="<?php echo site_url('gallery/archive_entry').'/'; ?>"+id; 
                },
                Cancel: function() {
                    dialogDestroy('#dialog-archive');
                }
            }
        });
    }

    function displayEntry(id) {
        $( "#dialog-display" ).dialogbox({
            buttons: {
                Ok: function() {
                    window.location="<?php echo site_url('gallery/display_entry').'/'; ?>"+id; 
                },
                Cancel: function() {
                    dialogDestroy('#dialog-display');
                }
            }
        });
    }

</script>
    
<?php //End of file ?>