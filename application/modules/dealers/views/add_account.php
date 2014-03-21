<?php /*
Filename:   add_account.php
Location:   /application/views/core
*/ ?>

<div class="raw100">
    <div class="quarx-device">

        <div class="raw100 raw-margin-bottom-15">
            <a href="#" data-role="button" onclick="showMenu()">Dealer Manager Menu</a>
        </div>

        <div class="raw50 mHide">
            <div class="quarx-google-map"> 
                <div id="quarx-map" class="quarx-google-map-inner">
                    <h3 style="padding: 40px;">Please enter your location, then <br />click <u>here</u> </h3>
                </div>
            </div>
        </div>

        <div class="raw50">

            <div id="formHolder" class="raw100 form">
                <form id="addAccount" method="post" enctype="multipart/form-data" action="<?php echo site_url('dealers/add_profile'); ?>">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                    <!-- // These are the hidden fields with the lat and lng values -->
                    <input id="latBox" type="hidden" name="latitude" size="30" value="" />
                    <input id="lngBox" type="hidden" name="longitude" size="30" value="" />

                    <!-- // Get to  the actual form! -->
                    <div class="raw100">
                        <div class="raw33"><p>Username</p></div>
                        <div class="raw66"><input id="u_name" type="text" name="user_name" size="30" value="" onkeyup="validationCheck(this.value)" /></div>
                    </div>
                    <?php if($this->session->userdata('permission') >= 52){ ?>
                    <input type="hidden" name="a_type" value="51" />
                    <?php }else{ ?>
                    <div class="raw100">
                        <div class="raw33"><p>Account Type</p></div>
                        <div class="raw66">
                            <select name="a_type">
                                <option>Account Type</option>
                                <option value="51">Dealer</option>
                                <option value='52'>Territory Manager</option>
                            </select>
                        </div>
                    </div>
                    <?php } ?>
                    <div class="raw100">
                        <div class="raw33"><p>Email</p></div>
                        <div class="raw66"><input data-type="Email" class="vital" type="text" name="user_email" size="30" value="" /></div>
                    </div>
                    <div class="raw100">
                        <div class="raw33"><p>Full Name</p></div>
                        <div class="raw66"><input class="vital" type="text" name="full_name" size="30" value="" /></div>
                    </div>
                    <div class="raw100">
                        <div class="raw33"><p>Address</p></div>
                        <div class="raw66"><input type="text" name="address" size="30" value="" /></div>
                    </div>
                    <div class="raw100">
                        <div class="raw33"><p>City</p></div>
                        <div class="raw66"><input type="text" name="city" size="30" value="" /></div>
                    </div>
                    <div class="raw100">
                        <div class="raw33"><p>State/Province</p></div>
                        <div class="raw66"><input type="text" name="state_prov" size="30" value="" /></div>
                    </div>
                    <div class="raw100">
                        <div class="raw33"><p>Zip/Postal Code</p></div>
                        <div class="raw66"><input id="location" type="text" name="location" size="30" value="" onblur="locateMe('<?php echo $root; ?>', this.value, '')" /></div>
                    </div>
                    <div class="raw100">
                        <div class="raw33"><p>Country</p></div>
                        <div class="raw66"><input type="text" name="country" size="30" value="" /></div>
                    </div>
                    <div class="raw100">
                        <div class="raw33"><p>Phone</p></div>
                        <div class="raw66"><input type="text" name="phone" size="30" value="" /></div>
                    </div>
                    <div class="raw100">
                        <div class="raw33"><p>Fax</p></div>
                        <div class="raw66"><input type="text" name="fax" size="30" value="" /></div>
                    </div>
                    <div class="raw100">
                        <div class="raw33"><p>Website</p></div>
                        <div class="raw66"><input type="text" name="website" size="30" value="" /></div>
                    </div>
                    <div class="raw100">
                        <div class="raw33"><p>Company</p></div>
                        <div class="raw66"><input type="text" name="company" size="30" value="" /></div>
                    </div>
                    <div class="raw100">
                        <div class="raw33"><p>Profile Image</p></div>
                        <div class="raw66"><input type="file" name="userfile" size="20" data-role="none" /></div>
                    </div>
                    <div class="raw100">
                        <div class="raw100"><input id="addBtn" class="fatButton" type="submit" value="Add Account" /></div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=false"></script>
<script type="text/JavaScript" src="<?php echo $root; ?>js/googlemaps.js"></script>

<script type="text/javascript">
    function hideSuccessErrors(){
        $('#error').delay(3000).fadeOut('slow');    
    }

    $(document).ready(function(e) {
        hideSuccessErrors();

        $('#formHolder').keypress(function(event){
            if (event.keyCode == 10 || event.keyCode == 13) 
                event.preventDefault();
        });

        $('#u_name').on("keyup", function() {
            $(this).val($(this).val().replace(/\s/g, "").toLowerCase());
        });
    });

    function validationCheck(name){
        $.ajax({
            type: 'GET',
            url: "<?php echo site_url('accounts/unc'); ?>/"+name,
            dataType: "html",
            success: function(data){
                if(data == 1){
                    $('#u_name').parent().css({
                        border: '1px solid #f00'
                    });
                    $('#addBtn').attr('disabled', 'disabled');
                }else{
                    $('#u_name').parent().css({
                        border: '1px solid #61B329'
                    });
                    $('#addBtn').removeAttr('disabled');
                }

                if($('#u_name').val().length < 4){
                    $('#u_name').parent().css({
                        border: '1px solid #f00'
                    });
                    $('#addBtn').attr('disabled', 'disabled');
                }
            }
        });
    }
</script>

<?php //End of File ?>