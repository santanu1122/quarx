<?php /*
    Filename:   full_search_results.php
    Location:   /application/views/core
    Author:     Matt Lantz
*/ ?>

<style>
    #pagination{
       margin-top: 30px;    
    }
    
    #pagination a, #pagination strong {
       background: #e3e3e3;
       padding: 4px 7px;
       text-decoration: none;
       border: 1px solid #cac9c9;
       color: #292929;
       font-size: 13px;
       font-weight: bold;
       font-family: Arial, Helvetica, sans-serif;
    }

    #pagination strong, #pagination a:hover {
       font-weight: bold;
       font-family: Arial, Helvetica, sans-serif;
       background: #cac9c9;
    }
</style>

<script>
    
    function resetSearch(){
        $('#search').val('');
        $('#search').css('color','#222');
    }
    
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

<div class="wide_box">  
    <div class="wide_box" style="text-align: center; min-height: 500px;">
        <div style="width: 90%; margin: 0 auto;">
            <div style="margin: 10px; text-align: left;">
                <br />
                <h1>Search Accounts</h1>
                <div style="width: 100%; min-height: 40px; text-align: center; margin: 20px auto;">
                    <form id="memberSearch" method="post" action="<?php echo site_url('accounts/search'); ?>"> 
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" /> 
                        <input id="search" name="search" class="searchBar" value="Enter a Search Term" onfocus="resetSearch()" />
                    </form>
                </div>
                
                <div id="searchResults" style="width: 90%; min-height: 300px; margin: 0 auto;">
                    
                <?php foreach($results as $member): ?>
                    
                    <div class="grid25 gridrow">
                        <div class="grid25"><a href="<?php echo site_url('accounts/editor/'.encrypt($member->user_id)); ?>">
                            <img src="<?php echo $member->img; ?>" style="float: left; width: 40px;" />
                        </a></div>
                        <div class="grid25"><h3><?php echo $member->user_name; ?></h3></div>
                        <div class="grid25"><p><?php echo valCheck($member->user_email); ?></p></div> 
                        <div class="grid25"><p><?php echo valCheck($member->full_name); ?></p></div> 
                    </div>

                <?php endforeach; ?>

                </div>
                <?php echo $this->pagination->create_links(); ?>
            </div>
        </div>
    </div>
</div>
    
<?php //End of File ?>