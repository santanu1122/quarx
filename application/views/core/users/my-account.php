<?php

/**
 * Quarx
 *
 * A modular CMS application
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

<?php

    if ($this->quarx->get_option("account_type") == 'advanced accounts' )
    {
        echo '<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=false"></script>';
        echo '<script type="text/JavaScript" src="'.$root.'js/googlemaps.js"></script>';
    }

?>

<div class="quarx-device">

    <div class="raw100 raw-left">

        <div class="raw50 raw-left">
            <div class="raw95 quarx-align-center mHide">
                <?php

                    $profile_image = $root.'uploads/img/thumb/default.jpg';
                    if ($myprofile->img !== "" && ! is_null($myprofile->img)) $profile_image = $myprofile->img;
                    echo '<div class="quarx-profile-image" style="background-image: url('.$this->image_tools->change_img_size($profile_image, "medium").');"></div>';

                ?>
            </div>

            <?php

                if ($this->quarx->get_option("account_type") == 'advanced accounts' )
                {
                    echo '<div class="raw95 mHide">';
                    echo    '<div class="quarx-map-box mHide">';
                    echo        '<div class="quarx-map mHide" id="quarx-map">';
                    echo            '<h3 class="raw-padding-40">Please enter your postal/zip code and click <u>here</u>.</h3>';
                    echo        '</div>';
                    echo    '</div>';
                    echo '</div>';
                }

            ?>

        </div>

        <div class="quarx-form raw50 raw-left">

            <form method="post" enctype="multipart/form-data" action="<?= site_url('users/update'); ?>" >
                <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>" />

                <!-- // These are the hidden fields with the lat and lng values -->
                <input id="latBox" type="hidden" name="latitude" value="<?= $myprofile->lat; ?>" />
                <input id="lngBox" type="hidden" name="longitude" value="<?= $myprofile->lng; ?>" />

                <div class="raw100">
                    <div class="raw100 raw-left">
                        <div class="raw33 raw-left">
                            <p>Username</p>
                        </div>
                        <div class="raw66 raw-left">
                            <p><?= $this->session->userdata('username'); ?></p>
                        </div>
                    </div>
                    <div class="raw100 raw-left">
                        <div class="raw33 raw-left">
                            <p>Email</p>
                        </div>
                        <div class="raw66 raw-left">
                            <input type="text" name="email" value="<?= $myprofile->email; ?>" />
                        </div>
                    </div>
                    <div class="raw100 raw-left">
                        <div class="raw33 raw-left">
                            <p>Full Name</p>
                        </div>
                        <div class="raw66 raw-left">
                            <input type="text" name="full_name" value="<?= $myprofile->full_name; ?>" />
                        </div>
                    </div>

<?php if ($this->quarx->get_option("account_type") == 'advanced accounts' ){ ?>

                    <div class="raw100 raw-left">
                        <div class="raw33 raw-left">
                            <p>Address</p>
                        </div>
                        <div class="raw66 raw-left">
                            <input type="text" name="address" value="<?= $myprofile->address; ?>" />
                        </div>
                    </div>
                    <div class="raw100 raw-left">
                        <div class="raw33 raw-left">
                            <p>City</p>
                        </div>
                        <div class="raw66 raw-left">
                            <input type="text" name="city" value="<?= $myprofile->city; ?>" />
                        </div>
                    </div>
                    <div class="raw100 raw-left">
                        <div class="raw33 raw-left">
                            <p>State/Province</p>
                        </div>
                        <div class="raw66 raw-left">
                            <input type="text" name="state_prov" value="<?= $myprofile->state; ?>" />
                        </div>
                    </div>
                    <div class="raw100 raw-left">
                        <div class="raw33 raw-left">
                            <p>Zip/Postal Code</p>
                        </div>
                        <div class="raw66 raw-left">
                            <input id="location" type="text" name="location" value="<?= $myprofile->location; ?>" onblur="locateMe('<?= $root; ?>', this.value, '<?= $myprofile->location; ?>')" />
                        </div>
                    </div>
                    <div class="raw100 raw-left">
                        <div class="raw33 raw-left">
                            <p>Country</p>
                        </div>
                        <div class="raw66 raw-left">
                            <input type="text" name="country" value="<?= $myprofile->country; ?>" />
                        </div>
                    </div>
                    <div class="raw100 raw-left">
                        <div class="raw33 raw-left">
                            <p>Phone</p>
                        </div>
                        <div class="raw66 raw-left">
                            <input type="text" name="phone" value="<?= $myprofile->phone; ?>" />
                        </div>
                    </div>
                    <div class="raw100 raw-left">
                        <div class="raw33 raw-left">
                            <p>Fax</p>
                        </div>
                        <div class="raw66 raw-left">
                            <input type="text" name="fax" value="<?= $myprofile->fax; ?>" />
                        </div>
                    </div>
                    <div class="raw100 raw-left">
                        <div class="raw33 raw-left">
                            <p>Website</p>
                        </div>
                        <div class="raw66 raw-left">
                            <input type="text" name="website" value="<?= $myprofile->website; ?>" />
                        </div>
                    </div>
                    <div class="raw100 raw-left">
                        <div class="raw33 raw-left">
                            <p>Company</p>
                        </div>
                        <div class="raw66 raw-left">
                            <input type="text" name="company" value="<?= $myprofile->company; ?>" />
                        </div>
                    </div>

<?php }else{ ?>

                    <div class="raw100 raw-left">
                        <div class="raw33 raw-left">
                            <p>Location</p>
                        </div>
                        <div class="raw66 raw-left">
                            <input id="location" type="text" name="location" value="<?= $myprofile->location; ?>" onblur="locateMe('<?= $root; ?>', this.value, '<?= $myprofile->location; ?>')" />
                        </div>
                    </div>

<?php } ?>

                    <div class="raw100 raw-left">
                        <div class="raw33 raw-left">
                            <p>Profile Image</p>
                        </div>
                        <div class="raw66 raw-left">
                            <input type="file" name="userfile" />
                        </div>
                    </div>
                    <div class="raw100 raw-left">
                        <input id="saveBtn" type="submit" value="Save" />
                    </div>
                </form>
            </div>
        </div>

    </div>

</div>

<script type="text/javascript">
    $(function(e) {

<?php

    if ($this->quarx->get_option("account_type") == 'advanced accounts' )
    {
        echo 'if ($("#latBox").val() > 0) { _locateMeAlt(); }';
    }

?>

    });
</script>

<!-- End of File -->