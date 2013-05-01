<?php /*
    Filename:   search.php
    Location:   /views
*/ ?>

<div class="raw100 align-left">

    <div class="device">

        <div class="raw100">
            <a href="#" data-role="button" onclick="showMenu()">Events Menu</a>
        </div>
    
        <div class="raw100">
            <div class="reallyTall">
                <form id="SearchBox" method="post" action="<?php echo site_url('events/search'); ?>">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" /> 
                    <input id="search" name="search" class="searchBar" value="Enter a Search Term" onfocus="resetSearch()" />
                </form>
            </div>
        </div>
        
        <div id="searchResults" class="wide_box tallBox">
            
            <?php if($results == 'error'){ ?>

                <?php echo '<p>Sorry, we don\'t have any matches.</p>'; ?>

            <?php }else{ ?>

            <?php foreach($results as $events): ?>
                <div class="grid gridrow">
                    <div class="grid25"><p><a href="<?php echo site_url('events/editor/'.encrypt($events->event_id)); ?>"><?php echo substr($events->event_title, 0, 30); ?></a></p></div>
                    <div class="grid25 mHide"><p><?php echo valCheck($events->event_start_date); ?></p></div>
                    <div class="grid25 mHide"><p><?php echo valTrim(strip_tags($events->event_entry, 20)); ?></p></div>
                    <div class="grid25 mHide"><p><?php echo getCatName($events->event_cat); ?></p></div>
                </div>
            <?php endforeach; ?>
            
            <?php } ?>

        </div>

    </div>

</div>

<script>
    
    function resetSearch(){
        $('#search').val('');
        $('#search').css('color','#222');
    }

</script>
    
<?php //End of file ?>