<?php /*
    Filename:   search.php
    Location:   /application/modeules/blog/views
*/ ?>

<div class="raw100 align-left">

    <div class="device">
    
        <h1>Search Results</h1>
        <div class="wide_box">
            <div class="reallyTall">
                <form id="SearchBox" method="post" action="<?php echo site_url('blog/search'); ?>">   
                    <input id="search" name="search" class="searchBar" value="Enter a Search Term" onfocus="resetSearch()" />
                </form>
            </div>
        </div>
        
        <div id="searchResults" class="wide_box tallBox">
            
            <?php if($results == 'error'){ ?>

                <?php echo '<p>Sorry, we don\'t have any matches.</p>'; ?>

            <?php }else{ ?>

            <?php foreach($results as $blog): ?>
                <div class="grid gridrow">
                    <div class="grid25"><p><a href="<?php echo site_url('blog/editor/'.encrypt($blog->blog_id)); ?>"><?php echo substr($blog->blog_title, 0, 30); ?></a></p></div>
                    <div class="grid25 mHide"><p><?php echo valCheck($blog->blog_date); ?></p></div>
                    <div class="grid25 mHide"><p><?php echo valTrim(strip_tags($blog->blog_entry, 20)); ?></p></div>
                    <div class="grid25 mHide"><p><?php echo getCatName($blog->blog_cat); ?></p></div>
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