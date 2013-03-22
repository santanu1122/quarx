<?php /*
    Filename:   accounts.php
    Location:   /application/views/core
*/ ?>

<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=false"></script>
<script type="text/JavaScript" src="<?php echo $root; ?>js/googlemaps.js"></script>

<script>
    function hideSuccessErrors(){
        $('#success').fadeIn('fast').delay(3000).fadeOut('slow');
        $('#error').fadeIn('fast').delay(3000).fadeOut('slow');    
    }
    
    $(document).ready(function(e) {
        hideSuccessErrors();
        if($('#latBox').val() > 0){
            locateMeAlt();
        }

        <?php if($latest_quarx_version > $current_quarx_version){ ?>
        $('#updates').fadeIn('fast');
        <?php } ?>

        <?php if($plugin_updates_available){ ?>
        $('#pluginUpdates').fadeIn('fast');
        <?php } ?>
    });
</script>

<div class="wide_box" style="margin-top: 30px;">

    <?php if($latest_quarx_version > $current_quarx_version){ ?>
        <div id="updates" class="updateBox">
            <p>Updates for Quarx are Available : <a href="<?php echo site_url('setup/update'); ?>">Update Quarx</a> | <a style="cursor: pointer;" onclick="$('#updates').fadeOut('slow');">Not right now</a></p>
        </div>
    <?php } ?>

    <?php if($plugin_updates_available){ ?>
        <div id="pluginUpdates" class="updateBox">
            <p>Updates for Quarx plugins are Available : <a href="<?php echo site_url('setup/plugins'); ?>">Plugin Updates</a> | <a style="cursor: pointer;" onclick="$('#pluginUpdates').fadeOut('slow');">Not right now</a></p>
        </div>
    <?php } ?>

    <?php foreach($myprofile as $myprofile): endforeach; ?>

    <div class="msgHolder">
        <?php if(isset($profilesuccess)){ ?>
        <div id="success" class="updateBox">
            <p><?php echo $profilesuccess; ?></p>
        </div>
        <?php } ?>
    </div>

    <div class="wide_box">
        <div class="half_box">
            <div class="profileImageBox">  
            <?php if($myprofile->img){
                echo '<img src="'.$myprofile->img.'" />';
            } ?>
            </div>
        </div>
        <div class="half_box" style="text-align: left;">
            <h1>My Account</h1>
            <br />

            <form method="post" enctype="multipart/form-data" action="<?php echo site_url('accounts/profile_updater'); ?>">
                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                <!-- // These are the hidden fields with the lat and lng values -->
                <input id="latBox" type="hidden" name="latitude" size="30" value="<?php echo $myprofile->lat; ?>" />
                <input id="lngBox" type="hidden" name="longitude" size="30" value="<?php echo $myprofile->lng; ?>" />

                <table class="spacedslightly" width="350px" style="float: left;">
                    <tr>
                        <td style="width: 150px;"><p>Username</p></td>
                        <td><?php echo $this->session->userdata('username'); ?></td>
                    </tr>
                    <tr>
                        <td><p>Email</p></td>
                        <td><input type="text" name="email" size="30" value="<?php echo $myprofile->user_email; ?>" /></td>
                    </tr>
                    <tr>
                        <td><p>Full Name</p></td>
                        <td><input type="text" name="full_name" size="30" value="<?php echo $myprofile->full_name; ?>" /></td>
                    </tr>

                    <?php if($opts[0]->option_title === 'advanced accounts' ){ ?>
                    
                    <tr>
                       <td><p>Address</p></td>
                       <td><input type="text" name="address" size="30" value="<?php echo $myprofile->address; ?>" /></td>
                    </tr>
                    <tr>
                       <td><p>City</p></td>
                       <td><input type="text" name="city" size="30" value="<?php echo $myprofile->city; ?>" /></td>
                    </tr>
                    <tr>
                       <td><p>State/Province</p></td>
                       <td><input type="text" name="state_prov" size="30" value="<?php echo $myprofile->state; ?>" /></td>
                    </tr>
                    <tr>
                       <td><p>Zip/Postal Code</p></td>
                       <td><input id="location" type="text" name="location" size="30" value="<?php echo $myprofile->location; ?>" onblur="locateMe('<?php echo $root; ?>', this.value, '<?php echo $myprofile->location; ?>')" /></td>
                    </tr>
                    <tr>
                       <td><p>Country</p></td>
                       <td><input type="text" name="country" size="30" value="<?php echo $myprofile->country; ?>" /></td>
                    </tr>
                    <tr>
                       <td><p>Phone</p></td>
                       <td><input type="text" name="phone" size="30" value="<?php echo $myprofile->phone; ?>" /></td>
                    </tr>
                    <tr>
                       <td><p>Fax</p></td>
                       <td><input type="text" name="fax" size="30" value="<?php echo $myprofile->fax; ?>" /></td>
                    </tr>
                    <tr>
                       <td><p>Website</p></td>
                       <td><input type="text" name="website" size="30" value="<?php echo $myprofile->website; ?>" /></td>
                    </tr>
                    <tr>
                       <td><p>Company</p></td>
                       <td><input type="text" name="company" size="30" value="<?php echo $myprofile->company; ?>" /></td>
                    </tr>
                    
                    <?php }else{ ?>

                    <tr>
                        <td><p>Location</p></td>
                        <td><input id="location" type="text" name="location" size="30" value="<?php echo $myprofile->location; ?>" onblur="locateMe('<?php echo $root; ?>', this.value, '<?php echo $myprofile->location; ?>')" /></td>
                    </tr>

                    <?php } ?>

                    <tr>
                        <td><p>Profile Image</p></td>
                        <td><input type="file" name="userfile" size="20" /></td>
                    </tr>
                    <tr>
                        <td colspan="2"><input class="green" style="padding: 10px 0px;" type="submit" value="Update" /></td>
                    </tr>
                </table>

            </form>
        </div>
    </div>

    <div class="wide_box">
        <div class="mapBox"> 
                <div class="map" id="map">
                     <h3 style="padding: 40px;">Please enter your postal/zip code and click <u>here</u>.</h3>
                </div>
           </div>

    </div>
    
</div>

<script type="text/javascript">
    setTimeout(profileImageResize, 50);
</script>
    
<!-- End of File -->