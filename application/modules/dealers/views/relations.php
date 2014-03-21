<?php /*
    Filename:   view.php
    Location:   /application/views/core
*/ ?>

<!-- dialogs -->

<div id="dialog-confirm" class="dialogBox" title="Delete Confirmation">
    <p>Are you sure you want to delete this account?</p>
</div>

<div id="dialog-enable" class="dialogBox" title="Enable Confirmation">
    <p>Are you sure you want to enable this account?</p>
</div>

<div id="dialog-master" class="dialogBox" title="Enable Confirmation">
    <p>Are you sure you want to give this account master status?</p>
</div>

<div id="dialog-downgrade" class="dialogBox" title="Enable Confirmation">
    <p>Are you sure you want to revoke this accounts master status?</p>
</div>

<div id="dialog-authorize" class="dialogBox" title="Authorization Confirmation">
    <p>Are you sure you want to authorize this account?</p>
</div>

<div id="dialog-disable" class="dialogBox" title="Disable Confirmation">
    <p>Are you sure you want to disable this account? This will not delete the account or its information.</p>
</div>

<!-- content -->

<div class="raw100">
    <div class="quarx-device">

        <div class="raw100">
            <a href="#" data-role="button" onclick="showMenu()">Dealer Manager Menu</a>
        </div>

        <div class="raw100"> 
            <div class="raw100">
                <form id="memberSearch" method="post" action="<?php echo site_url('dealers/search'); ?>"> 
                    <input id="search" name="search" class="searchBar" value="Enter a Search Term to Find Someone" onfocus="resetSearch()" />
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                </form>
            </div>

            <div id="editBox" class="raw100 editDropBox">
                <p>Drag a use here to edit them, or drag and drop dealers between territory managers <img src="<?php echo $root.'application/modules/dealers/img/edit.png'; ?>" style="width: 18px;" /></p>
            </div>

            <div class="raw100 dealerListingBox">

                <div class="tmBox raw20 bordered">
                    <h2><a href="<?php echo site_url('dealers/editor').'/'.encrypt($tm->user_id); ?>">Baumalight</a></h2>
                    <p>Wallenstien</p>

                    <div id="tm_<?php echo $tm->user_id; ?>" class="tmBoxDealers">
                    <?php foreach (get_my_dealers(0) as $d): ?>

                    <div data-id="d_<?php echo $d->user_id; ?>" class="dealerList raw100">
                        <p class="padded10"><?php echo $d->company; ?> - <?php echo $d->city; ?></p>
                    </div>

                    <?php endforeach; ?>
                    </div>

                </div>
                <div class="raw5 tall"></div>

                <?php foreach($profiles as $tm): ?>

                <div class="tmBox raw20 bordered">
                    <h2><a href="<?php echo site_url('dealers/editor').'/'.encrypt($tm->user_id); ?>"><?php echo $tm->company; ?></a></h2>
                    <p><?php echo $tm->city; ?></p>

                    <div id="tm_<?php echo $tm->user_id; ?>" class="tmBoxDealers">
                    <?php foreach (get_my_dealers($tm->user_id) as $d): ?>

                    <div data-id="d_<?php echo $d->user_id; ?>" class="dealerList raw100">
                        <p class="padded10"><?php echo $d->company; ?> - <?php echo $d->city; ?></p>
                    </div>

                    <?php endforeach; ?>
                    </div>

                </div>
                <div class="raw5 tall"></div>
                
                <?php endforeach; ?>

            </div>
        </div>
        <?php if(count($profiles) == 0){ ?>
            <div class="raw100 muted align-center padded20">
                <h2>You should add some members.</h2>
            </div>
        <?php } ?>
    </div>
       
</div>

<script type="text/javascript">
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

        $('a .accessControls').buttonMarkup({ corners: false });

        // binder();
    });

    $(function(){
        $('.dealerList').draggable({onSelectCSS: 'border: #444 1px solid; background: #fff;'});
        
        $('.tmBoxDealers').droppable({retain: 'true'});
        $(".tmBoxDealers").on( "drop", function( event, result ) {

            own = $(this).attr('id').substring(3, $(this).attr('id').length);;
            id = result.substring(2, result.length);

            $.ajax({
                url: "<?php echo site_url('dealers/switch_owners'); ?>",
                type: 'POST',
                data: { owner: own, dealer: id, <?php echo $this->security->get_csrf_token_name(); ?>: "<?php echo $this->security->get_csrf_hash(); ?>"},
                dataType: 'text',
                success: function(data){
                }
            });

        });

        $('#editBox').droppable();
        $("#editBox").on( "drop", function(event, result){ 
            
            id = result.substring(2, result.length);

            $.ajax({
                url: "<?php echo site_url('dealers/get_encrypted_string'); ?>",
                type: 'GET',
                data: { key: id },
                dataType: 'text',
                success: function(data){
                    window.location='<?php echo site_url('dealers/editor').'/'; ?>'+data;
                }
            });
        });
    });

</script>

<!-- End of File -->