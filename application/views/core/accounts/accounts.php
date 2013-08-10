<?php

/**
 * Quarx
 *
 * A modular application framework built on CodeIgniter
 *
 * @package     Quarx
 * @author      Matt Lantz
 * @copyright   Copyright (c) 2013 Matt Lantz
 * @license     http://ottacon.co/quarx/license.html
 * @link        http://ottacon.co/quarx
 * @since       Version 1.0
 * 
 */

?>

<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=false"></script>
<script type="text/JavaScript" src="<?php echo $root; ?>js/googlemaps.js"></script>

<div class="raw100">
    <div id="quarx-msg-box" class="<?php echo $state; ?>">
        <p><?php echo $message; ?></p>
    </div>
</div> 

<div class="quarx-device">

    <?php foreach($myprofile as $myprofile): endforeach; ?>

    <div class="raw100">

        <div class="raw50">
            <div class="quarx-profile-image-box mHide">  
                <?php if($myprofile->img){ ?>
                    <?php echo '<img src="'.$myprofile->img.'" />'; ?>
                <?php } ?>
            </div>
        </div>

        <div class="quarx-form raw50">
        
            <form method="post" enctype="multipart/form-data" action="<?php echo site_url('accounts/profile_updater'); ?>" >
                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                
                <!-- // These are the hidden fields with the lat and lng values -->
                <input id="latBox" type="hidden" name="latitude" value="<?php echo $myprofile->lat; ?>" />
                <input id="lngBox" type="hidden" name="longitude" value="<?php echo $myprofile->lng; ?>" />

                <div class="raw100">
                    <div class="raw100">
                        <div class="raw33"><p>Username</p></div>
                        <div class="raw66"><p><?php echo $this->session->userdata('username'); ?></p></div>
                    </div>
                    <div class="raw100">
                        <div class="raw33"><p>Email</p></div>
                        <div class="raw66"><input type="text" name="email" value="<?php echo $myprofile->user_email; ?>" /></div>
                    </div>
                    <div class="raw100">
                        <div class="raw33"><p>Full Name</p></div>
                        <div class="raw66"><input type="text" name="full_name" value="<?php echo $myprofile->full_name; ?>" /></div>
                    </div>

                    <?php if( $this->quarxsetup->get_option("account_type") == 'advanced accounts' ){ ?>
                    
                    <div class="raw100">
                       <div class="raw33"><p>Address</p></div>
                       <div class="raw66"><input type="text" name="address" value="<?php echo $myprofile->address; ?>" /></div>
                    </div>
                    <div class="raw100">
                       <div class="raw33"><p>City</p></div>
                       <div class="raw66"><input type="text" name="city" value="<?php echo $myprofile->city; ?>" /></div>
                    </div>
                    <div class="raw100">
                       <div class="raw33"><p>State/Province</p></div>
                       <div class="raw66"><input type="text" name="state_prov" value="<?php echo $myprofile->state; ?>" /></div>
                    </div>
                    <div class="raw100">
                       <div class="raw33"><p>Zip/Postal Code</p></div>
                       <div class="raw66"><input id="location" type="text" name="location" value="<?php echo $myprofile->location; ?>" onblur="locateMe('<?php echo $root; ?>', this.value, '<?php echo $myprofile->location; ?>')" /></div>
                    </div>
                    <div class="raw100">
                       <div class="raw33"><p>Country</p></div>
                       <div class="raw66"><input type="text" name="country" value="<?php echo $myprofile->country; ?>" /></div>
                    </div>
                    <div class="raw100">
                       <div class="raw33"><p>Phone</p></div>
                       <div class="raw66"><input type="text" name="phone" value="<?php echo $myprofile->phone; ?>" /></div>
                    </div>
                    <div class="raw100">
                       <div class="raw33"><p>Fax</p></div>
                       <div class="raw66"><input type="text" name="fax" value="<?php echo $myprofile->fax; ?>" /></div>
                    </div>
                    <div class="raw100">
                       <div class="raw33"><p>Website</p></div>
                       <div class="raw66"><input type="text" name="website" value="<?php echo $myprofile->website; ?>" /></div>
                    </div>
                    <div class="raw100">
                       <div class="raw33"><p>Company</p></div>
                       <div class="raw66"><input type="text" name="company" value="<?php echo $myprofile->company; ?>" /></div>
                    </div>
                    
                    <?php }else{ ?>
                    <div class="raw100">
                        <div class="raw33"><p>Location</p></div>
                        <div class="raw66"><input id="location" type="text" name="location" value="<?php echo $myprofile->location; ?>" onblur="locateMe('<?php echo $root; ?>', this.value, '<?php echo $myprofile->location; ?>')" /></div>
                    </div>
                    <?php } ?>

                    <div class="raw100">
                        <div class="raw33"><p>Profile Image</p></div>
                        <div class="raw66"><input type="file" name="userfile" data-role="none" /></div>
                    </div>
                    <div class="raw100">
                        <input data-theme="c" type="submit" value="Update" />
                    </div>
                </form>
            </div>
    </div>

        <div class="raw100 mHide">
            <div class="quarx-map-box mHide">
                <div class="quarx-map mHide" id="quarx-map">
                     <h3 style="padding: 40px;">Please enter your <?php if($this->quarxsetup->get_option("account_type") == "advanced accounts" ){ echo "postal/zip code"; }else{ echo "location"; }?> and click <u>here</u>.</h3>
                </div>
           </div>
        </div>
        
    </div>

</div>

<script type="text/javascript">
    $(window).load(function(){ setTimeout(function() { profileImageResize(); }, 300) });
    
    $(document).ready(function(e) {
        $('#quarx-msg-box').show().delay(3000).fadeOut('slow'); 
        
        if($('#latBox').val() > 0){
            locateMeAlt();
        }
        
    });
</script>
    
<!-- End of File -->