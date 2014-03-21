<?php /*
    Filename:   search.php
    Location:   /application/modeules/users/views
*/ ?>

<div class="raw100 align-left">

    <div class="quarx-device">

        <div class="raw100">
            <a href="#" data-role="button" onclick="showMenu()">Users Menu</a>
        </div>
    
        <div class="raw100">
            <div class="reallyTall">
                <form id="SearchBox" method="post" action="<?php echo site_url('users/search'); ?>">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                    <input id="search" name="search" class="searchBar" data-deefault="Enter a Search Term" />
                </form>
            </div>
        </div>
        
        <div id="searchResults" class="wide_box tallBox">
            
            <?php if($results == 'error'){ ?>

                <?php echo '<p>Sorry, we don\'t have any matches.</p>'; ?>

            <?php }else{ ?>

            <?php foreach($results as $user): ?>
                <div class="raw100">
                    <div class="raw25"><p><a href="<?php echo site_url('users/editor/'.encrypt($user->user_id)); ?>"><?php echo substr($user->user_fullname, 0, 30); ?></a></p></div>
                    <div class="raw25 mHide"><p><?php echo valCheck($user->user_name); ?></p></div>
                    <div class="raw25 mHide"><p><?php echo valTrim(strip_tags($user->user_email), 20); ?></p></div>
                    <div class="raw25 mHide"><p><?php echo $user->last_login; ?></p></div>
                </div></a>
            <?php endforeach; ?>
            
            <?php } ?>

        </div>

    </div>

</div>

<script type="text/javascript">

    $('#search').deefault();

</script>
    
<?php //End of file ?>