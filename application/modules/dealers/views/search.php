<?php /*
    Filename:   full_search_results.php
    Location:   /application/views/core
*/ ?>

<div class="raw100">
    <div class="quarx-device">
            <div class="raw100">
                <form id="memberSearch" method="post" action="<?php echo site_url('dealers/search'); ?>"> 
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                    <input id="search" name="search" class="searchBar" data-deefault="Enter a Search Term" />
                </form>
            </div>
            <div class="raw100">
                <p>You searched for: <?php echo $searchTerm; ?></p>
            </div>
            <div id="searchResults" class="raw100">
                
            <?php if(isset($empty_result)){ ?>

                <p><?php echo $empty_result; ?></p>

            <?php }else{ ?>

            <?php foreach($results as $member): ?>

                <div class="quarx-account-info-row raw100 quarx-bordered quarx-clickable" onclick="window.location='<?php echo site_url('dealers/editor/'.encrypt($member->user_id)); ?>'">
                    <div class="raw25"><p><?php echo $member->user_name; ?></p></div>
                    <div class="raw25 mHide"><p><?php echo valCheck($member->user_email); ?></p></div> 
                    <div class="raw25 mHide"><p><?php echo valCheck($member->full_name); ?></p></div> 
                    <div class="raw25 mHide"><p><?php echo valCheck($member->location); ?></p></div> 
                </div>

            <?php endforeach; ?>

            <?php } ?>

            </div>
            <?php echo $this->pagination->create_links(); ?>
    </div>
</div>

<script>
    
    $("#search").deefault();

    $(document).ready(function(e) {     
        $('#memberSearch').submit(function(){
            if($('#search').val().length < 3 ){
                alert('Sorry, your search must have at least three characters');
                return false;
            }else{
                return true;
            }
        });
    });
    
</script>
    
<?php //End of File ?>