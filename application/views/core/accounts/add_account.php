<?php /*
    Filename:   add_account.php
    Location:   /application/views/core
    Author:     Matt Lantz
*/ ?>

<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=false"></script>
<script type="text/JavaScript" src="<?php echo $root; ?>js/googlemaps.js"></script>

<script>
    function hideSuccessErrors(){
        $('#error').delay(3000).fadeOut('slow');    
    }
    
    $(document).ready(function(e) {
        hideSuccessErrors();
        $('#addAccount').ivalidate({klass: "vital"});
    });

    //This is actually checking to ensure that the username written is workable, and not previously used.
    function validationCheck(name){
        $('#uname_res').html('<span class="ui-icon ui-icon-closethick"></span>');
        $.ajax({
            type: 'GET',
            url: "<?php echo site_url('accounts/unc'); ?>/"+name,
            dataType: "html",
            success: function(data){
                if(data == 1){
                    $('#uname_res').html('<span class="ui-icon ui-icon-closethick"></span>');
                }else{
                    $('#uname_res').html('<span class="ui-icon ui-icon-check"></span>');
                }
            }
        });
    }
</script>

<div class="wide_box">
    
    <div class="desktop">
   
    <div class="googleMap"> 
        <div id="map" class="googleMapInner">
            <h3 style="padding: 40px;">Please enter your location, then click <br /> <u>here</u> </h3>
        </div>
    </div>

    <div style="width: 400px; float: left;">    
        <div style="margin: 20px; text-align: left; width: 340px;">
            
            <div class="msgHolder">
            <?php if(isset($error)){ ?>
                <div id="error" class="errorMsg">
                    <p><?php echo $error; ?></p>
                </div>
            <?php } ?>
            </div>

            <br />
            <br />
            
            <h2>Add an Account</h2>
            <br />
            <div id="formHolder" style="float: left; width: 100%;">
            <form id="addAccount" method="post" enctype="multipart/form-data" action="<?php echo site_url('accounts/add_profile'); ?>">
                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                <!-- // These are the hidden fields with the lat and lng values -->
                <input id="latBox" type="hidden" name="latitude" size="30" value="" />
                <input id="lngBox" type="hidden" name="longitude" size="30" value="" />

                <!-- // Get to  the actual form! -->
                <table class="spacedslightly" width="400px" style="float: left; margin: 15px;">
                    <tr>
                        <td style="width: 250px;"><p>Username</p></td>
                        <td>
                            <input type="text" style="float: left;" name="user_name" size="30" value="" onkeyup="validationCheck(this.value)" />
                            <div id="uname_res" class="ivalStatus"></div>
                        </td>
                    </tr>
                    <tr>
                       <td><p>Email</p></td>
                       <td><input data-type="Email" class="vital" type="text" name="user_email" size="30" value="" /></td>
                    </tr>
                    <tr>
                       <td><p>Full Name</p></td>
                       <td><input class="vital" type="text" name="full_name" size="30" value="" /></td>
                    </tr>
                    
                    <?php if($opts[0]->option_title === 'advanced accounts' ){ ?>
                
                    <tr>
                       <td><p>Address</p></td>
                       <td><input type="text" name="address" size="30" value="" /></td>
                    </tr>
                    <tr>
                       <td><p>City</p></td>
                       <td><input type="text" name="city" size="30" value="" /></td>
                    </tr>
                    <tr>
                       <td><p>State/Province</p></td>
                       <td><input type="text" name="state_prov" size="30" value="" /></td>
                    </tr>
                    <tr>
                       <td><p>Zip/Postal Code</p></td>
                       <td><input id="location" type="text" name="location" size="30" value="<?php echo $myprofile->location; ?>" onblur="locateMe('<?php echo $root; ?>', this.value, '')" /></td>
                    </tr>
                    <tr>
                       <td><p>Country</p></td>
                       <td><input type="text" name="country" size="30" value="" /></td>
                    </tr>
                    <tr>
                       <td><p>Phone</p></td>
                       <td><input type="text" name="phone" size="30" value="" /></td>
                    </tr>
                    <tr>
                       <td><p>Fax</p></td>
                       <td><input type="text" name="fax" size="30" value="" /></td>
                    </tr>
                    <tr>
                       <td><p>Website</p></td>
                       <td><input type="text" name="website" size="30" value="" /></td>
                    </tr>
                    <tr>
                       <td><p>Company</p></td>
                       <td><input type="text" name="company" size="30" value="" /></td>
                    </tr>
                    
                    <?php }else{ ?>

                    <tr>
                        <td><p>Location</p></td>
                        <td><input id="location" type="text" name="location" size="30" value="<?php echo $myprofile->location; ?>" onblur="locateMe('<?php echo $root; ?>', this.value, '')" /></td>
                    </tr>

                    <?php } ?>
                    
                    <tr>
                       <td><p>Profile Image</p></td>
                       <td><input type="file" name="userfile" size="20" /></td>
                    </tr>
                    <tr>
                       <td colspan="2"><input class="fatButton" type="submit" value="Add Account" /></td>
                    </tr>
                </table>
            </form>
            </div>
        </div>
    </div>
</div>
</div>
    
<?php //End of File ?>