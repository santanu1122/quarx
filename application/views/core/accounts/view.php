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
    <div class="device">
        <div class="raw100"> 
            <div class="raw100">
                <form id="memberSearch" method="post" action="<?php echo site_url('accounts/search'); ?>"> 
                    <input id="search" name="search" class="searchBar" value="Enter a Search Term to Find Someone" onfocus="resetSearch()" />
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                </form>

                <div class="raw100">
                    <div class="gridrow bordered">
                        <div class="grid20"><h3>Username</h3></div>
                        <div class="grid20 mHide"><h3>Email</h3></div> 
                        <div class="grid20 mHide"><h3>Full Name</h3></div> 
                        <div class="grid20 mHide"><h3>Last Login</h3></div>
                        <div class="grid20 mHide"><h3></h3></div>
                    </div>

                    <?php foreach($profiles as $accounts): ?>

                    <div class="accountInfoRow gridrow bordered <?php if($accounts->status == 'unauthorized'){ echo ' unauthorized'; } ?>">

                        <div class="accountControls">

                            <div id="controlbox" class="raw100">
                            <?php if($accounts->status === 'authorized'){ ?>

                                <div class="grid20"><button data-role="button" class="green" onclick="window.location='<?php echo site_url('accounts/editor').'/'.encrypt($accounts->user_id); ?>'">Edit</button></div>

                            <?php if($accounts->user_state == 'enabled'){ ?>
                                <div class="grid20 mHide"><button data-role="button" class="yellow" onclick="disable(<?php echo $accounts->user_id; ?>)">Disable</button></div> 
                            <?php }else{ ?>
                                <div class="grid20 mHide"><button data-role="button" class="green" onclick="enable(<?php echo $accounts->user_id; ?>)">Enable</button></div> 
                            <?php } ?>
                            
                                <div class="grid20 mHide"><button data-role="button" class="red" onclick="deleteConfirm(<?php echo $accounts->user_id; ?>)">Delete</button></div>
                            
                            <?php if($accounts->permission > 1 ){ ?>
                                <div class="grid20 mHide"><button data-role="button" class="blue" onclick="masterConfirm(<?php echo $accounts->user_id; ?>)">Master</button></div> 
                            <?php }else{ ?>
                                <div class="grid20 mHide"><button data-role="button" class="red" onclick="standardConfirm(<?php echo $accounts->user_id; ?>)">Standard</button></div> 
                            <?php } ?>

                            <?php }else{ ?>
                                <div class="grid20"><button data-role="button" class="green" onclick="window.location='<?php echo site_url('accounts/editor').'/'.encrypt($accounts->user_id); ?>'">View</button></div>

                                <div class="grid20"><button data-role="button" class="green" onclick="authorize(<?php echo $accounts->user_id; ?>)">Authorize</button></div> 
                            <?php } ?>

                                <div class="grid20"><button class="closer" data-role="button" data-icon="delete">Close</button></div>

                            </div>

                        </div>

                        <div class="accountInfo">
                            <div class="grid20"><p><a href="<?php echo site_url('accounts/editor').'/'.encrypt($accounts->user_id); ?>"><?php echo valTrim($accounts->user_name, 20); ?></a></p></div>
                            <div class="grid20 mHide"><p><?php echo valTrim(valCheck($accounts->user_email), 15); ?></p></div> 
                            <div class="grid20 mHide"><p><?php echo valTrim(valCheck($accounts->full_name), 20); ?></p></div> 
                            <div class="grid20 mHide"><p><?php echo valTrim(valCheck($accounts->last_login), 20); ?></p></div> 
                            <div class="grid20 mHide">
                                <?php if($accounts->user_state == 'enabled'){ ?>
                                <img src="<?php echo site_url(); ?>/images/active.png" title="active" class="raw15 padded5" />
                                <?php }else{ ?>
                                <img src="<?php echo site_url(); ?>/images/inactive.png" title="Inactive" class="raw15 padded5" />
                                <?php } ?>
                                <?php if($accounts->status == 'unauthorized'){ ?>
                                <img src="<?php echo site_url(); ?>/images/lock.png" title="Unathorized" class="raw12 padded5" />
                                <?php } ?>

                                <img src="<?php echo site_url(); ?>/images/settings.png" title="Edit Account" class="action_Btn raw20 padded5 rightFloat clickable" />
                            </div> 
                        </div>

                    </div>
                    
                    <?php endforeach; ?>
                
                </div>
                <?php echo $this->pagination->create_links(); ?>
            </div>
            <?php if(count($profiles) == 0){ ?>
                <div class="raw100 muted align-center padded20">
                    <h2>You should add some members.</h2>
                </div>
            <?php } ?>
        </div>
    </div>    
</div>

<script type="text/javascript">
    $('.closer').bind('click', function(){
        $('.accountControls').hide();
    });

    function binder(){
        $('.action_Btn').bind('click', function(){
            $('.accountControls').hide();
            $(this).parent().parent().parent().children('.accountControls').show();
        });
    }

    function authorize(id){
        $( "#dialog-authorize" ).dialogbox({
            buttons: {
                Ok: function() {
                    window.location="<?php echo site_url('accounts/authorize_user').'/'; ?>"+id; 
                },
                Cancel: function() {
                    dialogDestroy("#dialog-authorize");
                }
            }
        });
    }
    
    function deleteConfirm(id){
        $( "#dialog-confirm" ).dialogbox({
            buttons: {
                Ok: function() {
                    window.location="<?php echo site_url('accounts/delete_user').'/'; ?>"+id; 
                },
                Cancel: function() {
                    dialogDestroy("#dialog-confirm");
                }
            }
        });
    }

    function masterConfirm(id){
        $( "#dialog-master" ).dialogbox({
            buttons: {
                Ok: function() {
                    window.location="<?php echo site_url('accounts/master_user_upgrade_view').'/'; ?>"+id; 
                },
                Cancel: function() {
                    dialogDestroy("#dialog-master");
                }
            }
        });
    }

    function standardConfirm(id){
        $( "#dialog-downgrade" ).dialogbox({
            buttons: {
                Ok: function() {
                    window.location="<?php echo site_url('accounts/master_user_downgrade_view').'/'; ?>"+id; 
                },
                Cancel: function() {
                    dialogDestroy("#dialog-downgrade");
                }
            }
        });
    }

    function enable(id){
        $( "#dialog-enable" ).dialogbox({
            buttons: {
                Ok: function() {
                    window.location="<?php echo site_url('accounts/enable_user').'/'; ?>"+id; 
                },
                Cancel: function() {
                    dialogDestroy("#dialog-enable");
                }
            }
        });
    }

    function disable(id){
        $( '#dialog-disable' ).dialogbox({
            buttons: {
                Ok: function() {
                    window.location="<?php echo site_url('accounts/disable_user').'/'; ?>"+id; 
                },
                Cancel: function() {
                    dialogDestroy("#dialog-disable");
                }
            }
        });
    }

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

        binder();
    });

</script>

<!-- End of File -->