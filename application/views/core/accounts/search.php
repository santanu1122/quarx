<?php

/**
 * Quarx
 *
 * A modular application framework built on CodeIgniter
 *
 * @package     Quarx
 * @author      Matt Lantz
 * @copyright   Copyright (c) 2013 Matt Lantz
 * @license     http://ottacon.co/quarx/license.html
 * @link        http://ottacon.co/quarx
 * @since       Version 1.0
 * 
 */

?>

<div class="raw100">
    <div class="quarx-device">
            <div class="raw100">
                <form id="quarx-member-search" method="post" action="<?php echo site_url('accounts/search'); ?>"> 
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" /> 
                    <input id="quarx-search" name="search" class="quarx-search-bar deefault" data-deefault="Enter a member name or email" onfocus="resetSearch()" />
                </form>
            </div>
            <div class="raw100">
                <p>You searched for: <?php echo $searchTerm; ?></p>
            </div>
            <div id="quarx-search-results" class="raw100">
                
            <?php if($empty_result){ ?>

                <p><?php echo $empty_result; ?></p>

            <?php }else{ ?>

            <?php foreach($results as $member): ?>

                <div class="quarx-account-info-row quarx-gridrow quarx-bordered quarx-clickable" onclick="window.location='<?php echo site_url('accounts/editor/'.encrypt($member->user_id)); ?>'">
                    <div class="grid25"><p><?php echo $member->user_name; ?></p></div>
                    <div class="grid25 mHide"><p><?php echo valCheck($member->user_email); ?></p></div> 
                    <div class="grid25 mHide"><p><?php echo valCheck($member->full_name); ?></p></div> 
                    <div class="grid25 mHide"><p><?php echo valCheck($member->location); ?></p></div> 
                </div>

            <?php endforeach; ?>

            <?php } ?>

            </div>
            <?php echo $this->pagination->create_links(); ?>
    </div>
</div>

<script>
    
    $(document).ready(function(e) {     
        $('#quarx-member-search').submit(function(){
            if($('#quarx-search').val().length < 3 ){
                alert('Sorry, your search must have at least three characters');
                return false;
            }else{
                return true;
            }
        });
    });
    
</script>
    
<?php //End of File ?>