<?php /*
    Filename:   view.php
    Location:   /modules/feedback/view
*/ ?>

<script type="text/javascript">

    function deleteEntry(id){
        $( "#dialog-delete" ).dialogbox({
            modal: true,
            buttons: {
                Ok: function() {
                    window.location="<?php echo site_url('feedback/delete_entry').'/'; ?>"+id; 
                },
                Cancel: function() {
                    dialogDestroy('#dialog-delete');
                }
            }
        });
    }

    function archiveEntry(id){
        $( "#dialog-archive" ).dialogbox({
            modal: true,
            buttons: {
                Ok: function() {
                    window.location="<?php echo site_url('feedback/archive_entry').'/'; ?>"+id; 
                },
                Cancel: function() {
                    dialogDestroy('#dialog-archive');
                }
            }
        });
    }

    function displayEntry(id){    
        $( "#dialog-display" ).dialogbox({
            modal: true,
            buttons: {
                Ok: function() {
                    window.location="<?php echo site_url('feedback/display_entry').'/'; ?>"+id; 
                },
                Cancel: function() {
                    dialogDestroy('#dialog-display');
                }
            }
        });
    }

</script>

<!-- notifications -->

<div id="dialog-delete" class="dialogBox" title="Delete Confirmation" style="display: none;">
    <p>Are you sure you want to delete this entry?</p>
</div>

<div id="dialog-archive" class="dialogBox" title="Archive Confirmation">
    <p>Are you sure you want to archive this entry?</p>
</div>

<div id="dialog-display" class="dialogBox" title="Display Confirmation" style="display: none;">
    <p>Are you sure you want to display this entry?</p>
</div>

<div class="device">

    <div class="raw100">
        <a href="#" data-role="button" onclick="showMenu()">Feedback Menu</a>
    </div>

    <div class="raw100">
        <div class="raw10"><p>Overall Rating</p></div>
        <div class="raw25"><p>Client Name</p></div>
        <div class="raw25"><p>Feedback Title</p></div>
        <div class="raw25"><p><b>Actions</b></p></div>
    </div>

    <?php foreach ($rating as $entry): ?>
        
    <div class="raw100 rowBox <?php if($entry->fbr_display === ''){ echo ' pending'; }?>">
        <div class="raw10"><p><?php echo overall_score($entry->fbr_id); ?></p></div>
        <div class="raw25"><p><?php echo valTrim(get_val($entry->fbr_feedback_id, 'fb_client_name'), 20); ?></p></div>
        <div class="raw25"><p><?php echo valTrim($entry->fbr_title, 24); ?></p></div>
        <div class="raw12"><button data-theme="c" onclick="window.location='<?php echo site_url('feedback/editor/'.encrypt($entry->fbr_id)); ?>'">Review</button></div>
        <?php if($entry->fbr_display === 'no'){ ?>
        <div class="raw12"><button data-theme="c" onclick="displayEntry('<?php echo encrypt($entry->fbr_id); ?>')">Display</button></div>
        <?php }else if($entry->fbr_display == "yes"){ ?>
        <div class="raw12"><button data-theme="b" onclick="archiveEntry('<?php echo encrypt($entry->fbr_id); ?>')">Hide</button></div>
        <?php } ?>
        <div class="raw12" style="margin: 8px 0 0 7px;"><button data-theme="a" data-icon="delete" data-iconpos="notext" onclick="deleteEntry('<?php echo encrypt($entry->fbr_id); ?>')"></button></div>
    </div>

    <?php endforeach; ?>

</div>
    
<!-- End of File -->