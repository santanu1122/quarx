<?php /*
    Filename:   search.php
    Location:   /application/modeules/users/views
*/ ?>

<div class="raw100 align-left">

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
        
        <div class="raw100">
            
            <?php if($results == 'error'){ ?>

                <?php echo '<p>Sorry, we don\'t have any matches.</p>'; ?>

            <?php }else{ ?>

            <?php foreach($results as $m): ?>
                <div class="raw100 result-list-row quarx-clickable" onclick="window.location='<?php echo site_url('inbox/message/'.encrypt($m->inbox_id)); ?>'">
                    <div class="raw25"><p><?php echo $m->inbox_title; ?></p></div>
                    <div class="raw25 mHide"><p><?php echo $m->inbox_send; ?></p></div>
                    <div class="raw50 mHide"><p><?php echo valTrim(strip_tags($m->inbox_message), 20); ?></p></div>
                </div>
            <?php endforeach; ?>
            
            <?php } ?>

        </div>

    </div>

</div>

<script type="text/javascript">

    $('#search').deefault();

</script>
    
<?php //End of file ?>