<?php /*
    Filename:   view.php
    Location:   /views/
*/ ?>

<!-- Notices -->

<div id="msg-box" class="<?php echo $status; ?>">
    <p><?php echo $message; ?></p>
</div>

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

        <div class="raw2 raw-block-10 mHide"></div>

        <div class="raw50" style="margin-top: 2px;">
            <form id="SearchBox" method="post" action="<?php echo site_url('inbox/search'); ?>">
                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />    
                <input id="search" name="search" class="searchBar" data-deefault="Enter a Search Term" />
            </form>
        </div>

    </div>

    <div class="raw100 mHide">
        <div class="raw15"><p><b>From</b></p></div>
        <div class="raw25"><p><b>Sent On</b></p></div>
        <div class="raw35"><p><b>Subject</b></p></div>
        <div class="raw25"><p><b>Actions</b></p></div>
    </div>

    <?php foreach ($messages as $m): ?>
        
    <div class="raw100 result-list-row">
        <div class="raw15 mName"><p><?php echo getUserName($m->inbox_user_id); ?></p></div>
        <div class="raw25 mHide"><p><?php echo $m->inbox_send; ?></p></div>
        <div class="raw35 mSubject"><p><?php echo $m->inbox_title; ?></p></div>
        <div class="raw25 mAction">
            <div class="raw50">
                <button data-theme="c" data-mini="true" onclick="window.location='<?php echo site_url('inbox/message/'.encrypt($m->inbox_id)); ?>'">View</button>
            </div>
            <div class="raw50">
                <button data-theme="e" data-mini="true" onclick="deleteConfirm('<?php echo encrypt($m->inbox_id); ?>')">Delete</button>
            </div>
        </div>
    </div>

    <?php endforeach; ?>

</div>

<script type="text/javascript">
    
    $('#search').deefault();

    $('#msg-box').fadeIn('fast').delay(3000).fadeOut('slow');    

/* Entry Actions
***************************************************************/

    function deleteConfirm(id){    
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

    $(function(){
        if($(window).width() < 680){
            $(".mName").css({ width: "25%" });
            $(".mSubject").css({ width: "25%" });
            $(".mAction, .mAction .raw50").css({ width: "50%" });
        }else{
            $(".mName").attr("style", "");
            $(".mSubject").attr("style", "");
            $(".mAction, .mAction .raw50").attr("style", "");
        }
    });

    $(window).resize(function(){
        if($(window).width() < 680){
            $(".mName").css({ width: "25%" });
            $(".mSubject").css({ width: "25%" });
            $(".mAction, .mAction .raw50").css({ width: "50%" });
        }else{
            $(".mAction, .mName").attr("style", "");
            $(".mSubject").attr("style", "");
            $(".mAction .raw50").attr("style", "");
        }
    });

</script>
    
<?php //End of file ?>