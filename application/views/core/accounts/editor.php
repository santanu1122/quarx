<?php /*
    Filename:   editor.php
    Location:   /application/views/core
    Author:     Matt Lantz
*/ ?>

<?php //The following JavaScript/jQuery was based on a page by Ken Peleshok @ peleken.com, written by Matt Lantz ?>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=false"></script>
<script type="text/javaScript" src="<?php echo $root; ?>js/googlemaps.js"></script>

<script>
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

    function enable(id){
        $( "#dialog:ui-dialog" ).dialog( "destroy" );
    
        $( "#dialog-enable" ).dialog({
            modal: true,
            buttons: {
                Ok: function() {
                    window.location="<?php echo site_url('accounts/enable_user_editor').'/'; ?>"+id; 
                },
                Cancel: function() {
                    $( this ).dialog( "close" );
                }
            }
        });
    }

    function master_upgrade(id){
        $( "#dialog:ui-dialog" ).dialog( "destroy" );
    
        $( "#dialog-upgrade" ).dialog({
            modal: true,
            buttons: {
                Ok: function() {
                    window.location="<?php echo site_url('accounts/master_user_upgrade').'/'; ?>"+id; 
                },
                Cancel: function() {
                    $( this ).dialog( "close" );
                }
            }
        });
    }

    function master_downgrade(id){
        $( "#dialog:ui-dialog" ).dialog( "destroy" );
    
        $( "#dialog-downgrade" ).dialog({
            modal: true,
            buttons: {
                Ok: function() {
                    window.location="<?php echo site_url('accounts/master_user_downgrade').'/'; ?>"+id; 
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
                    window.location="<?php echo site_url('accounts/disable_user_editor').'/'; ?>"+id; 
                },
                Cancel: function() {
                    $( this ).dialog( "close" );
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
</script>

<div id="dialog-confirm" title="Delete Confirmation" style="display: none;">
    <p>Are you sure you want to delete this account?</p>
</div>

<div id="dialog-enable" title="Enable Confirmation" style="display: none;">
    <p>Are you sure you want to enable this account?</p>
</div>

<div id="dialog-upgrade" title="Upgrade Confirmation" style="display: none;">
    <p>Are you sure you want to give this user full master access?</p>
</div>

<div id="dialog-downgrade" title="Downgrade Confirmation" style="display: none;">
    <p>Are you sure you want to remove this users master status?</p>
</div>

<div id="dialog-disable" title="Disable Confirmation" style="display: none;">
    <p>Are you sure you want to disable this account? This will not delete the account or its information.</p>
</div>

<div class="wide_box">

<?php foreach($profile as $profile): endforeach; ?>
    <div class="desktop">
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

        <div class="half_box">    

            <div class="profileImageBox">
                <?php if($profile->img){ echo '<img src="'.$profile->img.'" />'; } ?>
            </div>
        </div>

        <div class="half_box" style="text-align: left;">
            <h1>Edit this Account</h1>
            <br />
            <form method="post" enctype="multipart/form-data" action="<?php echo site_url('accounts/profile_editor'); ?>">
                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                <!-- // These are the hidden fields with the lat and lng values -->
                <input id="latBox" type="hidden" name="latitude" size="30" value="<?php echo $profile->lat; ?>" />
                <input id="lngBox" type="hidden" name="longitude" size="30" value="<?php echo $profile->lng; ?>" />

                <!-- // Get to  the actual form! -->
                <input type="hidden" name="user_id" value="<?php echo $profile->user_id; ?>" />
                
                <table class="spacedslightly">
                    <tr>
                        <td style="width: 250px;"><p>Username</p></td>
                        <td><?php echo $profile->user_name; ?></td>
                    </tr>
                    
                    <?php if($profile->owner > 0){ ?>
                    <tr>
                        <td style="width: 250px;"><p>Guarantor</p></td>
                        <td><?php echo getUserName($profile->owner); ?></td>
                    </tr>
                    <?php } ?>

                    <tr>
                        <td><p>Email</p></td>
                        <td><input type="text" name="user_email" size="30" value="<?php echo $profile->user_email; ?>" /></td>
                    </tr>
                    <tr>
                        <td><p>Full Name</p></td>
                        <td><input type="text" name="full_name" size="30" value="<?php echo $profile->full_name; ?>" /></td>
                    </tr>

                    <?php if($opts[0]->option_title === 'advanced accounts' ){ ?>
            
                    <tr>
                       <td><p>Address</p></td>
                       <td><input type="text" name="address" size="30" value="<?php echo $profile->address; ?>" /></td>
                    </tr>
                    <tr>
                       <td><p>City</p></td>
                       <td><input type="text" name="city" size="30" value="<?php echo $profile->city; ?>" /></td>
                    </tr>
                    <tr>
                       <td><p>State/Province</p></td>
                       <td><input type="text" name="state_prov" size="30" value="<?php echo $profile->state; ?>" /></td>
                    </tr>
                    <tr>
                       <td><p>Zip/Postal Code</p></td>
                       <td><input id="location" type="text" name="location" size="30" value="<?php echo $profile->location; ?>" onblur="locateMe('<?php echo $root; ?>', this.value, '<?php echo $profile->location; ?>')" /></td>
                    </tr>
                    <tr>
                       <td><p>Country</p></td>
                       <td><input type="text" name="country" size="30" value="<?php echo $profile->country; ?>" /></td>
                    </tr>
                    <tr>
                       <td><p>Phone</p></td>
                       <td><input type="text" name="phone" size="30" value="<?php echo $profile->phone; ?>" /></td>
                    </tr>
                    <tr>
                       <td><p>Fax</p></td>
                       <td><input type="text" name="fax" size="30" value="<?php echo $profile->fax; ?>" /></td>
                    </tr>
                    <tr>
                       <td><p>Website</p></td>
                       <td><input type="text" name="website" size="30" value="<?php echo $profile->website; ?>" /></td>
                    </tr>
                    <tr>
                       <td><p>Company</p></td>
                       <td><input type="text" name="company" size="30" value="<?php echo $profile->company; ?>" /></td>
                    </tr>
                    
                    <?php }else{ ?>

                    <tr>
                        <td><p>Location</p></td>
                        <td><input id="location" type="text" name="location" size="30" value="<?php echo $profile->location; ?>" onblur="locateMe('<?php echo $root; ?>', this.value, '<?php echo $profile->location; ?>')" /></td>
                    </tr>

                    <?php } ?>
            
                    <tr>
                         <td><p>Profile Image</p></td>
                         <td><input type="file" name="userfile" size="20" /></td>
                    </tr>
                    <tr>
                         <td colspan="2"><input class="button green" style="margin-top: 15px; padding: 10px 0px;" type="submit" value="Update Account" /></td>
                    </tr>
                </table>
            </form>

            <?php if($profile->user_state == 'enabled'){ ?>
            <button class="yellow" onclick="disable(<?php echo $profile->user_id; ?>)">DISABLE</button>
            <?php }else{ ?>
            <button class="green" onclick="enable(<?php echo $profile->user_id; ?>)">ENABLE</button>
            <?php } ?>
            <button class="button red" onclick="deleteConfirm(<?php echo $profile->user_id; ?>)">DELETE ACCOUNT</button>
            <?php if($profile->permission > 1){ ?>
            <button style="margin-bottom: 30px;" class="blue" onclick="master_upgrade(<?php echo $profile->user_id; ?>)">MASTER</button>
            <?php }else{ ?> 
            <button style="margin-bottom: 30px;" class="red" onclick="master_downgrade(<?php echo $profile->user_id; ?>)">STANDARD</button>
            <?php } ?>
        </div>

        <div class="wide_box">
            <div class="mapBox">
                <div id="map" class="map">
                     <h3 style="padding: 40px;">Please enter your location, then click <br /> <u>here</u> </h3>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    setTimeout(profileImageResize, 50);
</script>
    
<!-- End of File -->