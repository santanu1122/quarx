<?php /*
    Filename:   search.php
    Location:   /application/modeules/page/views
*/ ?>

<div class="raw100 align-left">

    <div class="device">
        <div class="wide_box">
            <div class="reallyTall">
                <form id="SearchBox" method="post" action="<?php echo site_url('pages/search'); ?>">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                    <input id="search" name="search" class="searchBar" value="Enter a Search Term" onfocus="resetSearch()" />
                </form>
            </div>
        </div>
        
        <div id="searchResults" class="wide_box tallBox">
            
            <?php if($results == 'error'){ ?>

                <?php echo '<p>Sorry, we don\'t have any matches.</p>'; ?>

            <?php }else{ ?>

            <?php foreach($results as $page): ?>
                <div class="grid gridrow">
                    <div class="grid25"><p><a href="<?php echo site_url('pages/editor/'.encrypt($page->page_id)); ?>"><?php echo substr($page->page_title, 0, 30); ?></a></p></div>
                    <div class="grid25 mHide"><p><?php echo valCheck(getParentName($page->page_parent)); ?></p></div>
                    <div class="grid25 mHide"><p><?php echo valTrim(strip_tags($page->page_entry, 20)); ?></p></div>
                    <div class="grid25 mHide"><p><?php //echo getCatName($page->page_cat); ?></p></div>
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