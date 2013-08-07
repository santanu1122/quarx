<?php

/**
 * Quarx
 *
 * A modular application framework built on CodeIgniter
 *
 * @package     Quarx
 * @author      Matt Lantz
 * @copyright   Copyright (c) 2013 Matt Lantz
 * @license     http://ottacon.co/quarx/license
 * @link        http://ottacon.co/quarx
 * @since       Version 1.0
 * 
 */ 

?>

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

<!-- notifications -->

<div class="raw100">
    <div id="quarx-msg-box" class="<?php echo $state; ?>">
        <p><?php echo $message; ?></p>
    </div>
</div>

<!-- content -->

<div class="raw100">
    <div class="quarx-device">
        <div class="raw100"> 
            <div class="raw100">
                <form id="quarx-member-search" method="post" action="<?php echo site_url('accounts/search'); ?>"> 
                    <input id="quarx-search" name="search" class="quarx-search-bar deefault" data-deefault="Enter a member name, email or location" onfocus="resetSearch()" />
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                </form>

                <div class="raw100">
                    <div class="quarx-gridrow quarx-bordered">
                        <div class="quarx-grid20"><h3>Username</h3></div>
                        <div class="quarx-grid20 mHide"><h3>Email</h3></div> 
                        <div class="quarx-grid20 mHide"><h3>Full Name</h3></div> 
                        <div class="quarx-grid20 mHide"><h3>Last Login</h3></div>
                        <div class="quarx-grid20 mHide"><h3></h3></div>
                    </div>

                    <?php foreach($profiles as $accounts): ?>

                    <div class="quarx-account-info-row quarx-gridrow quarx-bordered <?php if($accounts->a_status == 'unauthorized'){ echo ' unauthorized'; } ?>">

                        <div class="quarx-account-controls">

                            <div id="quarx-control-box" class="raw100">
                            <?php if($accounts->a_status === 'authorized'){ ?>

                                <div class="quarx-grid20"><button class="quarx-green" onclick="window.location='<?php echo site_url('accounts/editor').'/'.encrypt($accounts->user_id); ?>'">Edit</button></div>

                            <?php if($accounts->user_state == 'enabled'){ ?>
                                <div class="quarx-grid20 mHide"><button class="quarx-yellow" onclick="disable(<?php echo $accounts->user_id; ?>)">Disable</button></div> 
                            <?php }else{ ?>
                                <div class="quarx-grid20 mHide"><button class="quarx-green" onclick="enable(<?php echo $accounts->user_id; ?>)">Enable</button></div> 
                            <?php } ?>
                            
                                <div class="quarx-grid20 mHide"><button class="quarx-red" onclick="deleteConfirm(<?php echo $accounts->user_id; ?>)">Delete</button></div>
                            
                            <?php if($accounts->permission > 1 ){ ?>
                                <div class="quarx-grid20 mHide"><button class="quarx-blue" onclick="masterConfirm(<?php echo $accounts->user_id; ?>)">Master</button></div> 
                            <?php }else{ ?>
                                <div class="quarx-grid20 mHide"><button class="quarxred" onclick="standardConfirm(<?php echo $accounts->user_id; ?>)">Standard</button></div> 
                            <?php } ?>

                            <?php }else{ ?>
                                <div class="quarx-grid20"><button class="quarx-green" onclick="window.location='<?php echo site_url('accounts/editor').'/'.encrypt($accounts->user_id); ?>'">View</button></div>

                                <div class="quarx-grid20"><button class="quarx-green" onclick="authorize(<?php echo $accounts->user_id; ?>)">Authorize</button></div> 
                            <?php } ?>

                                <div class="quarx-grid20"><button class="closer" data-icon="delete">Close</button></div>

                            </div>

                        </div>

                        <div class="quarx-account-info">
                            <div class="quarx-grid20"><p><a href="<?php echo site_url('accounts/editor').'/'.encrypt($accounts->user_id); ?>"><?php echo valTrim($accounts->user_name, 20); ?></a></p></div>
                            <div class="quarx-grid20 mHide"><p><?php echo valTrim(valCheck($accounts->user_email), 15); ?></p></div> 
                            <div class="quarx-grid20 mHide"><p><?php echo valTrim(valCheck($accounts->full_name), 20); ?></p></div> 
                            <div class="quarx-grid20 mHide"><p><?php echo valTrim(valCheck($accounts->last_login), 20); ?></p></div> 
                            <div class="quarx-grid20 mHide">
                                <?php if($accounts->user_state == 'enabled'){ ?>
                                <img src="<?php echo site_url(); ?>/images/active.png" title="active" class="raw15 padded5" />
                                <?php }else{ ?>
                                <img src="<?php echo site_url(); ?>/images/inactive.png" title="Inactive" class="raw15 padded5" />
                                <?php } ?>
                                <?php if($accounts->a_status == 'unauthorized'){ ?>
                                <img src="<?php echo site_url(); ?>/images/lock.png" title="Unathorized" class="raw12 padded5" />
                                <?php } ?>

                                <img src="<?php echo site_url(); ?>/images/settings.png" title="Edit Account" class="quarx-action-btn raw20 padded5 rightFloat quarx-clickable" />
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
        $('.quarx-account-controls').hide();
    });

    function binder(){
        $('.quarx-action-btn').bind('click', function(){
            $('.quarx-account-controls').hide();
            $(this).parent().parent().parent().children('.quarx-account-controls').show();
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

    $(document).ready(function(e) {
        $('#quarx-msg-box').show().delay(3000).fadeOut('slow');

        $('#quarx-member-search').submit(function(){
            if($('#quarx-search').val().length < 3 ){
                alert('Sorry, your search must have at least three characters');
                return false;
            }else{
                return true;
            }
        });

        $('.quarx-account-controls button').buttonMarkup({ corners: false });
        $('.quarx-account-controls .ui-btn').css("margin", "0");

        binder();
    });

</script>

<!-- End of File -->