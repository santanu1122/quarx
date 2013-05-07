<?php /*
    Filename:   editor.php
    Location:   /application/views/core
*/ ?>

<!-- dialogs -->

<div id="dialog-delete" class="dialogBox" title="Delete Confirmation">
    <p>Are you sure you want to delete this account?</p>
</div>

<div id="dialog-enable" class="dialogBox" title="Enable Confirmation">
    <p>Are you sure you want to enable this account?</p>
</div>

<div id="dialog-disable" class="dialogBox" title="Disable Confirmation">
    <p>Are you sure you want to disable this account? This will not delete the account or its information.</p>
</div>

<div id="dialog-upgrade" class="dialogBox" title="Upgrade Confirmation">
    <p>Are you sure you want to give this user full master access?</p>
</div>

<div id="dialog-downgrade" class="dialogBox" title="Downgrade Confirmation">
    <p>Are you sure you want to remove this users master status?</p>
</div>

<!-- content -->

<div class="raw100">

<?php if(isset($success)){ ?>
<div id="success" class="updateBox">
<p><?php echo $success; ?></p>
</div>
<?php } ?>

<?php if(isset($error)){ ?>
<div id="error" class="errorBox">
<p><?php echo $error; ?></p>
</div>
<?php } ?> 

<?php foreach($profile as $profile): endforeach; ?>
    <div class="device">

        <div class="raw100">
            <div class="raw50 mHide">    
                <div class="profileImageBox">
                    <?php if($profile->img){ echo '<img src="'.$profile->img.'" />'; } ?>
                </div>
            </div>

            <div class="raw50">
                
                <div id="formHolder" class="raw100 form">

                    <form method="post" enctype="multipart/form-data" action="<?php echo site_url('accounts/profile_editor'); ?>">
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                        <!-- // These are the hidden fields with the lat and lng values -->
                        <input id="latBox" type="hidden" name="latitude" size="30" value="<?php echo $profile->lat; ?>" />
                        <input id="lngBox" type="hidden" name="longitude" size="30" value="<?php echo $profile->lng; ?>" />

                        <!-- // Get to  the actual form! -->
                        <input type="hidden" name="user_id" value="<?php echo $profile->user_id; ?>" />
                        
                        <div class="raw100">
                            <div class="raw33"><p>Username</p></div>
                            <div class="raw66"><p><?php echo $profile->user_name; ?></p></div>
                        </div>
                        
                        <?php if($profile->owner > 0){ ?>
                        <div class="raw100">
                            <div class="raw33"><p>Guarantor</p></div>
                            <div class="raw66"><p><?php echo getUserName($profile->owner); ?></p></div>
                        </div>
                        <?php } ?>

                        <div class="raw100">
                            <div class="raw33"><p>Email</p></div>
                            <div class="raw66"><input <?php if( $profile->status != 'authorized' ){ echo 'disabled="disabled"'; } ?> type="text" name="user_email" size="30" value="<?php echo $profile->user_email; ?>" /></div>
                        </div>
                        <div class="raw100">
                            <div class="raw33"><p>Full Name</p></div>
                            <div class="raw66"><input <?php if( $profile->status != 'authorized' ){ echo 'disabled="disabled"'; } ?> type="text" name="full_name" size="30" value="<?php echo $profile->full_name; ?>" /></div>
                        </div>

                        <?php if($opts[0]->option_title === 'advanced accounts' ){ ?>
                
                        <div class="raw100">
                           <div class="raw33"><p>Address</p></div>
                           <div class="raw66"><input <?php if( $profile->status != 'authorized' ){ echo 'disabled="disabled"'; } ?> type="text" name="address" size="30" value="<?php echo $profile->address; ?>" /></div>
                        </div>
                        <div class="raw100">
                           <div class="raw33"><p>City</p></div>
                           <div class="raw66"><input <?php if( $profile->status != 'authorized' ){ echo 'disabled="disabled"'; } ?> type="text" name="city" size="30" value="<?php echo $profile->city; ?>" /></div>
                        </div>
                        <div class="raw100">
                           <div class="raw33"><p>State/Province</p></div>
                           <div class="raw66"><input <?php if( $profile->status != 'authorized' ){ echo 'disabled="disabled"'; } ?> type="text" name="state_prov" size="30" value="<?php echo $profile->state; ?>" /></div>
                        </div>
                        <div class="raw100">
                           <div class="raw33"><p>Zip/Postal Code</p></div>
                           <div class="raw66"><input <?php if( $profile->status != 'authorized' ){ echo 'disabled="disabled"'; } ?> id="location" type="text" name="location" size="30" value="<?php echo $profile->location; ?>" onblur="locateMe('<?php echo $root; ?>', this.value, '<?php echo $profile->location; ?>')" /></div>
                        </div>
                        <div class="raw100">
                           <div class="raw33"><p>Country</p></div>
                           <div class="raw66"><input <?php if( $profile->status != 'authorized' ){ echo 'disabled="disabled"'; } ?> type="text" name="country" size="30" value="<?php echo $profile->country; ?>" /></div>
                        </div>
                        <div class="raw100">
                           <div class="raw33"><p>Phone</p></div>
                           <div class="raw66"><input <?php if( $profile->status != 'authorized' ){ echo 'disabled="disabled"'; } ?> type="text" name="phone" size="30" value="<?php echo $profile->phone; ?>" /></div>
                        </div>
                        <div class="raw100">
                           <div class="raw33"><p>Fax</p></div>
                           <div class="raw66"><input <?php if( $profile->status != 'authorized' ){ echo 'disabled="disabled"'; } ?> type="text" name="fax" size="30" value="<?php echo $profile->fax; ?>" /></div>
                        </div>
                        <div class="raw100">
                           <div class="raw33"><p>Website</p></div>
                           <div class="raw66"><input <?php if( $profile->status != 'authorized' ){ echo 'disabled="disabled"'; } ?> type="text" name="website" size="30" value="<?php echo $profile->website; ?>" /></div>
                        </div>
                        <div class="raw100">
                           <div class="raw33"><p>Company</p></div>
                           <div class="raw66"><input <?php if( $profile->status != 'authorized' ){ echo 'disabled="disabled"'; } ?> type="text" name="company" size="30" value="<?php echo $profile->company; ?>" /></div>
                        </div>
                        
                        <?php }else{ ?>

                        <div class="raw100">
                            <div class="raw33"><p>Location</p></div>
                            <div class="raw66"><input <?php if( $profile->status != 'authorized' ){ echo 'disabled="disabled"'; } ?> id="location" type="text" name="location" size="30" value="<?php echo $profile->location; ?>" onblur="locateMe('<?php echo $root; ?>', this.value, '<?php echo $profile->location; ?>')" /></div>
                        </div>

                        <?php } ?>
                
                        <div class="raw100">
                            <div class="raw33"><p>Profile Image</p></div>
                            <div class="raw66"><input <?php if( $profile->status != 'authorized' ){ echo 'disabled="disabled"'; } ?> data-role="none" type="file" name="userfile" size="20" /></div>
                        </div>
                        <?php if( $profile->status == 'authorized' ){ ?>
                        <div class="raw100">
                            <div class="raw100"><input  data-theme="c" type="submit" value="Update Account" /></div>
                        </div>
                        <?php } ?>
                    </form>
                    <?php if( $profile->status == 'authorized' ){ ?>
                        <div class="raw100">
                        <?php if($profile->user_state == 'enabled'){ ?>
                            <button data-theme="b" onclick="disable(<?php echo $profile->user_id; ?>)">DISABLE</button>
                        <?php }else{ ?>
                            <button data-theme="c" onclick="enable(<?php echo $profile->user_id; ?>)">ENABLE</button>
                        <?php } ?>
                            <button data-theme="e" onclick="deleteConfirm(<?php echo $profile->user_id; ?>)">DELETE</button>
                        
                        <?php if($profile->permission > 1){ ?>
                            <button data-theme="d" style="margin-bottom: 30px;" onclick="master_upgrade(<?php echo $profile->user_id; ?>)">MASTER</button>
                        <?php }else{ ?> 
                            <button onclick="master_downgrade(<?php echo $profile->user_id; ?>)">STANDARD</button>
                        <?php } ?>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>

        <div class="raw100">
            <div class="device mHide">
                <div class="mapBox">
                    <div id="map" class="map">
                         <h3 style="padding: 40px;">Please enter your location, then click <br /> <u>here</u> </h3>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=false"></script>
<script type="text/javaScript" src="<?php echo $root; ?>js/googlemaps.js"></script>

<script>
    function deleteConfirm(id){
        $( "#dialog-delete" ).dialogbox({
            buttons: {
                Ok: function() {
                    window.location="<?php echo site_url('accounts/delete_user').'/'; ?>"+id; 
                },
                Cancel: function() {
                    dialogDestroy("#dialog-delete");
                }
            }
        });
    }

    function enable(id){
        $( "#dialog-enable" ).dialogbox({
            buttons: {
                Ok: function() {
                    window.location="<?php echo site_url('accounts/enable_user_editor').'/'; ?>"+id; 
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
                    window.location="<?php echo site_url('accounts/disable_user_editor').'/'; ?>"+id; 
                },
                Cancel: function() {
                    dialogDestroy("#dialog-disable");
                }
            }
        });
    }

    function master_upgrade(id){
        $( "#dialog-upgrade" ).dialogbox({
            buttons: {
                Ok: function() {
                    window.location="<?php echo site_url('accounts/master_user_upgrade').'/'; ?>"+id; 
                },
                Cancel: function() {
                    dialogDestroy("#dialog-upgrade");
                }
            }
        });
    }

    function master_downgrade(id){
        $( "#dialog-downgrade" ).dialogbox({
            buttons: {
                Ok: function() {
                    window.location="<?php echo site_url('accounts/master_user_downgrade').'/'; ?>"+id; 
                },
                Cancel: function() {
                    dialogDestroy("#dialog-downgrade");
                }
            }
        });
    }

    function hideSuccessErrors(){
        $('#success').fadeIn('fast').delay(3000).fadeOut('slow');
        $('#error').fadeIn('fast').delay(3000).fadeOut('slow');    
    }
    
    $(document).ready(function(e) {
        hideSuccessErrors();
        
        if($('#latBox').val() > 0){
            locateMeAlt();
        }
    });

    $(window).load(function(){ profileImageResize() });

</script>
    
<!-- End of File -->