<?php /*
    Filename:   search.php
    Location:   /application/modeules/gallery/views
*/ ?>

<div class="raw100 align-left">

    <div class="quarx-device">

        <div class="raw100">
            <a href="#" data-role="button" onclick="showMenu()">Gallery Menu</a>
        </div>
    
        <div class="raw100">
            <div class="reallyTall">
                <form id="SearchBox" method="post" action="<?php echo site_url('gallery/search'); ?>">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                    <input id="search" name="search" class="searchBar" data-deefault="Enter a Search Term" />
                </form>
            </div>
        </div>
        
        <div id="searchResults" class="raw100 tallBox">
            
            <?php if($results == 'error'){ ?>

                <?php echo '<p>Sorry, we don\'t have any matches.</p>'; ?>

            <?php }else{ ?>

            <?php foreach($results as $p): ?>
                <div class="raw100">
                    <div class="raw25"><p><a href="<?php echo site_url('gallery/editor/'.encrypt($p->gallery_id)); ?>"><?php echo substr($p->gallery_name, 0, 30); ?></a></p></div>
                    <div class="raw75 mHide"><p><?php echo strip_tags(valTrim($p->gallery_entry, 100)); ?></p></div>
                </div>
            <?php endforeach; ?>
            
            <?php } ?>

        </div>

    </div>

</div>

<script>
    
    $("#search").deefault();

</script>
    
<?php //End of file ?>