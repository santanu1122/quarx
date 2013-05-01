<?php /*
    Filename:   search.php
    Location:   /application/modeules/gallery/views
*/ ?>

<div class="raw100 align-left">

    <div class="device">

        <div class="raw100">
            <a href="#" data-role="button" onclick="showMenu()">Gallery Menu</a>
        </div>

        <div class="raw100">
            <div class="reallyTall">
                <form id="SearchBox" method="post" action="<?php echo site_url('gallery/search'); ?>"> 
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />   
                    <input id="search" name="search" class="searchBar" value="Enter a Search Term" onfocus="resetSearch()" />
                </form>
            </div>
        </div>
        
        <div id="searchResults" class="wide_box tallBox">
            
            <?php if($results == 'error'){ ?>

                <?php echo '<p>Sorry, we don\'t have any matches.</p>'; ?>

            <?php }else{ ?>

            <?php foreach($results as $gallery): ?>
                <div class="grid gridrow">
                    <div class="grid25"><p><a href="<?php echo site_url('gallery/editor/'.encrypt($gallery->gallery_id)); ?>"><?php echo substr($gallery->gallery_title, 0, 30); ?></a></p></div>
                    <div class="grid25 mHide"><p><?php echo valCheck($gallery->gallery_date); ?></p></div>
                    <div class="grid25 mHide"><p><?php echo valTrim(strip_tags($gallery->gallery_entry, 20)); ?></p></div>
                    <div class="grid25 mHide"><p><?php echo getCatName($gallery->gallery_cat); ?></p></div>
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