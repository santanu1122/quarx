<?php /*
    Filename:   message.php
    Location:   /views/
*/ ?>

<!-- Dialogs -->

<div id="dialog-confirm" class="dialogBox" title="Delete Confirmation">
    <p>Are you sure you want to delete this message?</p>
</div>

<!-- Content -->

<div class="quarx-device">

    <div class="raw100">

        <div class="raw48 raw-margin-bottom-15">
            <a href="#" data-role="button" onclick="showMenu()">Inbox Menu</a>
        </div>

        <div class="raw2 raw-block-10"></div>

        <div class="raw50" style="margin-top: 2px;">
            <form id="SearchBox" method="post" action="<?php echo site_url('inbox/search'); ?>">
                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />    
                <input id="search" name="search" class="searchBar" data-deefault="Enter a Search Term" />
            </form>
        </div>

    </div>

    <div class="raw100 inbox-message">

    <?php foreach ($messages as $m): ?>
        
        <div class="raw100">
            <div class="raw15">
                <p><b>From</b></p>
            </div>
            <div class="raw85">
                <p><?php echo getUserName($m->inbox_from); ?></p>
            </div>
        </div>

        <div class="raw100">
            <div class="raw15">
                <p><b>Subject</b></p>
            </div>
            <div class="raw85">
                <p><?php echo $m->inbox_title; ?></p>
            </div>
        </div>

        <div class="raw100">
            <div class="raw15">
                <p><b>Message</b></p>
            </div>
            <div class="raw85">
                <p><?php echo $m->inbox_message; ?></p>
            </div>
        </div>

    <?php endforeach; ?>

    </div>

</div>

<div class="raw100 inbox-tools">
    <div class="tool-set">
        <div class="raw50">
            <button data-theme="d" data-mini="true" onclick="reply('<?php echo getUserName($m->inbox_user_id); ?>')">Reply</button>
        </div>
        <div class="raw50">
            <button data-theme="e" data-mini="true" onclick="deleteConfirm('<?php echo encrypt($m->inbox_id); ?>')">Delete</button>
        </div>
    </div>
</div>

<script type="text/javascript">
    
    $('#search').deefault();

    $('#msg-box').fadeIn('fast').delay(3000).fadeOut('slow');    

/* Entry Actions
***************************************************************/

    function deleteConfirm(id) {    
        $( "#dialog-confirm" ).dialogbox({
            buttons: {
                Ok: function() {
                    window.location="<?php echo site_url('inbox/delete_message').'/'; ?>"+id; 
                },
                Cancel: function() {
                    dialogDestroy('#dialog-confirm');
                }
            }
        });
    }

    function reply(id) {
        window.location = "<?php echo site_url('inbox/compose'); ?>/"+id
    }

</script>
    
<?php //End of file ?>