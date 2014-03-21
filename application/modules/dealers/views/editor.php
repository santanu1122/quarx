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
    <p>Are you sure you want to give this user full manager access?</p>
</div>

<div id="dialog-downgrade" class="dialogBox" title="Downgrade Confirmation">
    <p>Are you sure you want to remove this users master status?</p>
</div>

<!-- content -->

<div class="raw100">

<?php if(isset($success)){ ?>
<div id="success" class="success-box">
<p><?php echo $success; ?></p>
</div>
<?php } ?>

<?php if(isset($error)){ ?>
<div id="error" class="error-box">
<p><?php echo $error; ?></p>
</div>
<?php } ?> 

<?php foreach($profile as $profile): endforeach; ?>
    <div class="quarx-device">

        <div class="raw100 raw-margin-bottom-15">
            <a href="#" data-role="button" onclick="showMenu()">Dealer Manager Menu</a>
        </div>

        <div class="raw100">
            <div class="raw50 mHide">    
                <div class="quarx-profile-image-box">
                    <?php if($profile->img){ echo '<img src="'.$profile->img.'" />'; } ?>
                </div>

                <?php if($profile->permission == 52){ ?>

                <div class="raw100">
                    <div class="padded15">
                        <div class="raw94">
                            <h2>My Dealer Listing</h2>
                        </div>

                        <?php foreach( get_my_dealers($profile->user_id) as $d): ?>

                            <div class="dealerList raw94">
                                <p><a class="padded20" href="<?php echo site_url('dealers/editor').'/'.encrypt($d->user_id); ?>"><?php echo $d->company; ?> - <?php echo $d->phone; ?></a></p>
                            </div>

                        <?php endforeach; ?>
                    </div>
                </div>

                <?php }else if($profile->permission == 51){ ?>
                <?php if($this->session->userdata('permission') == 1){ ?>

                <div class="raw100">
                    <div class="raw50">
                        <p>TM View Count:</p>
                    </div>
                    <div class="raw50">
                        <p><?php echo $profile->owner_view_count; ?></p>
                    </div>
                </div>
                <div class="raw100">
                    <div class="raw50">
                        <p>Last Viewed by TM on:</p>
                    </div>
                    <div class="raw50">
                        <p><?php echo $profile->owner_last_view; ?></p>
                    </div>
                </div>

                <?php } ?>
                <?php } ?>
            </div>

            <div class="raw50">
                
                <div id="formHolder" class="raw100 form">

                    <form method="post" enctype="multipart/form-data" action="<?php echo site_url('dealers/profile_editor'); ?>">
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
                        
                        <?php if($profile->permission == 51){ ?>
                            <?php if($this->session->userdata('permission') < 50){ ?>
                                <div class="raw100">
                                    <div class="raw33"><p>TM</p></div>

                                    <div class="raw66">
                                        <select id="tm_list" name="owner">
                                            <option value="<?php echo $profile->owner ?>">Currently: <?php echo getTmName($profile->owner); ?></option>
                                            <!-- list of tms goes here -->
                                        </select>
                                    </div>
                                </div>
                            <?php }else{ ?>
                                <input type="hidden" name="owner" value="<?php echo $profile->owner ?>" />
                            <?php } ?>
                        <?php } ?>

                        <div class="raw100">
                            <div class="raw33"><p>Email</p></div>
                            <div class="raw66"><input <?php if( $profile->a_status != 'authorized' ){ echo 'disabled="disabled"'; } ?> type="text" name="user_email" size="30" value="<?php echo $profile->user_email; ?>" /></div>
                        </div>
                        <div class="raw100">
                            <div class="raw33"><p>Full Name</p></div>
                            <div class="raw66"><input <?php if( $profile->a_status != 'authorized' ){ echo 'disabled="disabled"'; } ?> type="text" name="full_name" size="30" value="<?php echo $profile->full_name; ?>" /></div>
                        </div>        
                        <div class="raw100">
                           <div class="raw33"><p>Address</p></div>
                           <div class="raw66"><input <?php if( $profile->a_status != 'authorized' ){ echo 'disabled="disabled"'; } ?> type="text" name="address" size="30" value="<?php echo $profile->address; ?>" /></div>
                        </div>
                        <div class="raw100">
                           <div class="raw33"><p>City</p></div>
                           <div class="raw66"><input <?php if( $profile->a_status != 'authorized' ){ echo 'disabled="disabled"'; } ?> type="text" name="city" size="30" value="<?php echo $profile->city; ?>" /></div>
                        </div>
                        <div class="raw100">
                           <div class="raw33"><p>State/Province</p></div>
                           <div class="raw66"><input <?php if( $profile->a_status != 'authorized' ){ echo 'disabled="disabled"'; } ?> type="text" name="state_prov" size="30" value="<?php echo $profile->state; ?>" /></div>
                        </div>
                        <div class="raw100">
                           <div class="raw33"><p>Zip/Postal Code</p></div>
                           <div class="raw66"><input <?php if( $profile->a_status != 'authorized' ){ echo 'disabled="disabled"'; } ?> id="location" type="text" name="location" size="30" value="<?php echo $profile->location; ?>" onblur="locateMe('<?php echo $root; ?>', this.value, '<?php echo $profile->location; ?>')" /></div>
                        </div>
                        <div class="raw100">
                           <div class="raw33"><p>Country</p></div>
                           <div class="raw66"><input <?php if( $profile->a_status != 'authorized' ){ echo 'disabled="disabled"'; } ?> type="text" name="country" size="30" value="<?php echo $profile->country; ?>" /></div>
                        </div>
                        <div class="raw100">
                           <div class="raw33"><p>Phone</p></div>
                           <div class="raw66"><input <?php if( $profile->a_status != 'authorized' ){ echo 'disabled="disabled"'; } ?> type="text" name="phone" size="30" value="<?php echo $profile->phone; ?>" /></div>
                        </div>
                        <div class="raw100">
                           <div class="raw33"><p>Fax</p></div>
                           <div class="raw66"><input <?php if( $profile->a_status != 'authorized' ){ echo 'disabled="disabled"'; } ?> type="text" name="fax" size="30" value="<?php echo $profile->fax; ?>" /></div>
                        </div>
                        <div class="raw100">
                           <div class="raw33"><p>Website</p></div>
                           <div class="raw66"><input <?php if( $profile->a_status != 'authorized' ){ echo 'disabled="disabled"'; } ?> type="text" name="website" size="30" value="<?php echo $profile->website; ?>" /></div>
                        </div>
                        <div class="raw100">
                           <div class="raw33"><p>Company</p></div>
                           <div class="raw66"><input <?php if( $profile->a_status != 'authorized' ){ echo 'disabled="disabled"'; } ?> type="text" name="company" size="30" value="<?php echo $profile->company; ?>" /></div>
                        </div>                
                        <div class="raw100">
                            <div class="raw33"><p>Profile Image</p></div>
                            <div class="raw66"><input <?php if( $profile->a_status != 'authorized' ){ echo 'disabled="disabled"'; } ?> data-role="none" type="file" name="userfile" size="20" /></div>
                        </div>
                        <?php if( $profile->a_status == 'authorized' ){ ?>
                        <div class="raw100">
                            <div class="raw100"><input  data-theme="c" type="submit" value="Update Account" /></div>
                        </div>
                        <?php } ?>
                    </form>
                    <?php if( $profile->a_status == 'authorized' ){ ?>
                        <div class="raw100">
                        <?php if($profile->user_state == 'enabled'){ ?>
                            <button data-theme="b" onclick="disable(<?php echo $profile->user_id; ?>)">DISABLE</button>
                        <?php }else{ ?>
                            <button data-theme="c" onclick="enable(<?php echo $profile->user_id; ?>)">ENABLE</button>
                        <?php } ?>
                            <button data-theme="e" onclick="deleteConfirm(<?php echo $profile->user_id; ?>)">DELETE</button>
                        
                        <?php if($profile->permission < 52){ ?>
                            <button data-theme="d" style="margin-bottom: 30px;" onclick="master_upgrade(<?php echo $profile->user_id; ?>)">MANAGER</button>
                        <?php }else{ ?> 
                            <button onclick="master_downgrade(<?php echo $profile->user_id; ?>)">DEALER</button>
                        <?php } ?>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>

        <div class="raw100">
            <div class="device mHide">
                <div class="quarx-map-box">
                    <div id="quarx-map" class="quarx-map">
                         <h3 style="padding: 40px;">Please enter your location, then click <br /> <u>here</u> </h3>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=false"></script>
<script type="text/javaScript" src="<?php echo $root; ?>js/googlemaps.js"></script>

<script type="text/javascript">
    function getTmList() {        
        $.ajax({
            url: "<?php echo site_url('dealers/tm_option_list'); ?>",
            type: 'GET',
            cache: false,
            dataType: 'html',
            success: function(data) {
                $("#tm_list").append(data).selectmenu('refresh', true);
            }
        });
    }

    function deleteConfirm(id){
        $( "#dialog-delete" ).dialogbox({
            modal: true,
            buttons: {
                Ok: function() {
                    window.location="<?php echo site_url('dealers/delete_user').'/'; ?>"+id; 
                },
                Cancel: function() {
                    dialogDestroy("#dialog-delete");
                }
            }
        });
    }

    function enable(id){
        $( "#dialog-enable" ).dialogbox({
            modal: true,
            buttons: {
                Ok: function() {
                    window.location="<?php echo site_url('dealers/enable_user_editor').'/'; ?>"+id; 
                },
                Cancel: function() {
                    dialogDestroy("#dialog-enable");
                }
            }
        });
    }

    function disable(id){
        $( '#dialog-disable' ).dialogbox({
            modal: true,
            buttons: {
                Ok: function() {
                    window.location="<?php echo site_url('dealers/disable_user_editor').'/'; ?>"+id; 
                },
                Cancel: function() {
                    dialogDestroy("#dialog-disable");
                }
            }
        });
    }

    function master_upgrade(id){
        $( "#dialog-upgrade" ).dialogbox({
            modal: true,
            buttons: {
                Ok: function() {
                    window.location="<?php echo site_url('dealers/master_user_upgrade').'/'; ?>"+id; 
                },
                Cancel: function() {
                    dialogDestroy("#dialog-upgrade");
                }
            }
        });
    }

    function master_downgrade(id){
        $( "#dialog-downgrade" ).dialogbox({
            modal: true,
            buttons: {
                Ok: function() {
                    window.location="<?php echo site_url('dealers/master_user_downgrade').'/'; ?>"+id; 
                },
                Cancel: function() {
                    dialogDestroy("#dialog-downgrade");
                }
            }
        });
    }

    function trackAction() {        
        $.ajax({
            url: "<?php echo site_url('dealers/tm_tracker'); ?>",
            type: 'POST',
            cache: false,
            data: { id: <?php echo $profile->user_id ?>, <?php echo $this->security->get_csrf_token_name(); ?>: "<?php echo $this->security->get_csrf_hash(); ?>" }
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

        getTmList();
    });

    $(window).load(function(){ profileImageResize() });

    <?php if($this->session->userdata('permission') == 52 ){ ?>

        setTimeout(trackAction, 10000);

    <?php } ?>

</script>
    
<!-- End of File -->