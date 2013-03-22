<?php /*
    Filename:   view.php
    Location:   /application/views/core
    Author:     Matt Lantz
*/ ?>

<script type="text/javascript">

    function authorize(id){
        $( "#dialog:ui-dialog" ).dialog( "destroy" );
    
        $( "#dialog-authorize" ).dialog({
            modal: true,
            buttons: {
                Ok: function() {
                    window.location="<?php echo site_url('accounts/authorize_user').'/'; ?>"+id; 
                },
                Cancel: function() {
                    $( this ).dialog( "close" );
                }
            }
        });
    }
    
    function deleteConfirm(id){
        $( "#dialog:ui-dialog" ).dialog( "destroy" );
    
        $( "#dialog-confirm" ).dialog({
            modal: true,
            buttons: {
                Ok: function() {
                    window.location="<?php echo site_url('accounts/delete_user').'/'; ?>"+id; 
                },
                Cancel: function() {
                    $( this ).dialog( "close" );
                }
            }
        });
    }

    function masterConfirm(id){
        $( "#dialog:ui-dialog" ).dialog( "destroy" );
    
        $( "#dialog-master" ).dialog({
            modal: true,
            buttons: {
                Ok: function() {
                    window.location="<?php echo site_url('accounts/master_user_upgrade_view').'/'; ?>"+id; 
                },
                Cancel: function() {
                    $( this ).dialog( "close" );
                }
            }
        });
    }

    function standardConfirm(id){
        $( "#dialog:ui-dialog" ).dialog( "destroy" );
    
        $( "#dialog-downgrade" ).dialog({
            modal: true,
            buttons: {
                Ok: function() {
                    window.location="<?php echo site_url('accounts/master_user_downgrade_view').'/'; ?>"+id; 
                },
                Cancel: function() {
                    $( this ).dialog( "close" );
                }
            }
        });
    }

    function enable(id){
        $( "#dialog:ui-dialog" ).dialog( "destroy" );
    
        $( "#dialog-enable" ).dialog({
            modal: true,
            buttons: {
                Ok: function() {
                    window.location="<?php echo site_url('accounts/enable_user').'/'; ?>"+id; 
                },
                Cancel: function() {
                    $( this ).dialog( "close" );
                }
            }
        });
    }

    function disable(id){
        $( "#dialog:ui-dialog" ).dialog( "destroy" );
    
        $( "#dialog-disable" ).dialog({
            modal: true,
            buttons: {
                Ok: function() {
                    window.location="<?php echo site_url('accounts/disable_user').'/'; ?>"+id; 
                },
                Cancel: function() {
                    $( this ).dialog( "close" );
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
    });

</script>

<style>
    #pagination{
        margin-top: 10px;   
    }
    
    #pagination a, #pagination strong {
        background: #e3e3e3;
        padding: 4px 7px;
        text-decoration: none;
        border: 1px solid #cac9c9;
        color: #292929;
        font-size: 13px;
    }

    #pagination strong, #pagination a:hover {
        font-weight: normal;
        background: #cac9c9;
    }
</style>

<div id="dialog-confirm" title="Delete Confirmation" style="display: none;">
    <p>Are you sure you want to delete this account?</p>
</div>

<div id="dialog-enable" title="Enable Confirmation" style="display: none;">
    <p>Are you sure you want to enable this account?</p>
</div>

<div id="dialog-master" title="Enable Confirmation" style="display: none;">
    <p>Are you sure you want to give this account master status?</p>
</div>

<div id="dialog-downgrade" title="Enable Confirmation" style="display: none;">
    <p>Are you sure you want to revoke this accounts master status?</p>
</div>

<div id="dialog-authorize" title="Authorization Confirmation" style="display: none;">
    <p>Are you sure you want to authorize this account?</p>
</div>

<div id="dialog-disable" title="Disable Confirmation" style="display: none;">
    <p>Are you sure you want to disable this account? This will not delete the account or its information.</p>
</div>

<div class="wide_box">
            <div class="wide_box" style="text-align: center; min-height: 700px;">
    
            <div style="width: 100%; margin: 0 auto;"> 
                <div style="margin: 20px 0; text-align: left; width: 100%;">
                    <h2>Accounts</h2>
                    
                    <br />
                    <form id="memberSearch" method="post" action="<?php echo site_url('accounts/search'); ?>"> 
                        <input id="search" name="search" class="searchBar" value="Enter a Search Term" onfocus="resetSearch()" />
                    </form>
                    <br />

                    <div>
                        <div class="grid14 gridrowbordered">
                            <div class="grid14"><h3>Username</h3></div>
                            <div class="grid25"><h3>Email</h3></div> 
                            <div class="grid14"><h3>Full Name</h3></div> 
                            <div class="grid14"><h3>Location</h3></div> 
                            <div class="grid8"><h3></h3></div>
                            <div class="grid8"><h3></h3></div>  
                            <div class="grid8"><h3></h3></div>
                        </div>
                        <?php foreach($profiles as $accounts): ?>

                        <div class="grid14 gridrowbordered <?php if($accounts->status === 'unauthorized'){ echo ' unauthorized'; } ?>">
                            <div class="grid14"><h3><?php echo $accounts->user_name; ?></h3></div>
                            <div class="grid25"><p><?php echo valCheck($accounts->user_email); ?></p></div> 
                            <div class="grid14"><p><?php echo valCheck($accounts->full_name); ?></p></div> 
                            <div class="grid14"><p><?php echo valCheck($accounts->location); ?></p></div> 

                            <?php if($accounts->status === 'authorized'){ ?>

                            <div class="grid8"><p><button class="green" onclick="window.location='<?php echo site_url('accounts/editor').'/'.encrypt($accounts->user_id); ?>'">Edit</button></p></div>
                            
                            <?php if($accounts->user_state == 'enabled'){ ?>
                            <div class="grid8"><p><button class="yellow" onclick="disable(<?php echo $accounts->user_id; ?>)">Disable</button></p></div> 
                            <?php }else{ ?>
                            <div class="grid8"><p><button class="green" onclick="enable(<?php echo $accounts->user_id; ?>)">Enable</button></p></div> 
                            <?php } ?>
                            
                            <div class="grid8"><p><button class="red" onclick="deleteConfirm(<?php echo $accounts->user_id; ?>)">Delete</button></p></div>
                            
                            <?php if($accounts->permission > 1 ){ ?>
                            <div class="grid9"><p><button class="blue" onclick="masterConfirm(<?php echo $accounts->user_id; ?>)">Master</button></p></div> 
                            <?php }else{ ?>
                            <div class="grid9"><p><button class="red" onclick="standardConfirm(<?php echo $accounts->user_id; ?>)">Standard</button></p></div> 
                            <?php } ?>

                            <?php }else{ ?>                     
                            <div class="grid25"><p><button class="green" onclick="authorize(<?php echo $accounts->user_id; ?>)">Authorize</button></p></div> 
                            <?php } ?>
                        </div>
                        
                        <?php endforeach; ?>

                    </div>
                    <?php echo $this->pagination->create_links(); ?>
                </div>
            </div>
        </div>    
    </div>

<!-- End of File -->