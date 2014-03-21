<?php /*
    Filename:   search.php
    Location:   /views
*/ ?>

<div class="raw100 align-left">

    <div class="quarx-device">

        <div class="raw100">
            <a href="#" data-role="button" onclick="showMenu()">Events Menu</a>
        </div>
    
        <div class="raw100">
            <div class="reallyTall">
                <form id="SearchBox" method="post" action="<?php echo site_url('events/search'); ?>">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                    <input id="search" name="search" class="searchBar" data-deefault="Enter a Search Term" />
                </form>
            </div>
        </div>
        
        <div id="searchResults" class="wide_box tallBox">
            
            <?php if($results == 'error'){ ?>

                <?php echo '<p>Sorry, we don\'t have any matches.</p>'; ?>

            <?php }else{ ?>

            <?php foreach($results as $events): ?>
                <div class="raw100">
                    <div class="raw25"><p><a href="<?php echo site_url('events/editor/'.encrypt($events->event_id)); ?>"><?php echo substr($events->event_title, 0, 30); ?></a></p></div>
                    <div class="raw25 mHide"><p><?php echo valCheck($events->event_start_date); ?></p></div>
                    <div class="raw25 mHide"><p><?php echo valTrim(strip_tags($events->event_entry, 20)); ?></p></div>
                    <div class="raw25 mHide"><p><?php echo getCatName($events->event_cat); ?></p></div>
                </div>
            <?php endforeach; ?>
            
            <?php } ?>

        </div>

    </div>

</div>

<script>
    
    $('#search').deefault();

</script>
    
<?php //End of file ?>