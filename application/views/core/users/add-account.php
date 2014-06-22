<?php

/**
 * Quarx
 *
 * A modular application structure built on CodeIgniter
 *
 * @package     Quarx
 * @author      Matt Lantz
 * @copyright   Copyright (c) 2013 - 2014 Matt Lantz
 * @license     https://ottacon.co/docs/quarx/license.html
 * @link        https://github.com/mlantz/quarx
 * @since       Version 1.0
 *
 */

?>

<div class="raw100">
    <div class="quarx-device">

        <?php

            $map = '<div class="raw50 raw-left mHide">';
            $map .= '<div class="quarx-google-map">';
                $map .= '<div id="quarx-map" class="quarx-google-map-inner">';
                    $map .= '<h3 class="raw-padding-40">Please enter your postal/zip code, then click <u>here</u> </h3>';
                $map .= '</div>';
            $map .= '</div>';
            $map .= '</div>';

            echo ($this->quarx->get_option("account_type") == 'advanced accounts' ? $map : '<div class="raw25 raw-left raw-block-100"></div>');

        ?>

        <div class="raw50 raw-left">

            <div id="quarx-form-holder" class="raw100 quarx-form">
                <form id="quarx-add-account" method="post" enctype="multipart/form-data" action="<?= site_url('users/add_profile'); ?>">

                    <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>" />

                    <!-- // These are the hidden fields with the lat and lng values -->
                    <input id="latBox" type="hidden" name="latitude" />
                    <input id="lngBox" type="hidden" name="longitude" />

                    <!-- // Get to  the actual form! -->
                    <div class="raw100 raw-left">
                        <div class="raw33 raw-left">
                            <p>Username</p>
                        </div>
                        <div class="raw66 raw-left">
                            <input id="u_name" type="text" name="username" onkeyup="validationCheck(this.value, '<?= site_url('ajax/unc'); ?>')" />
                        </div>
                    </div>
                    <div class="raw100 raw-left">
                        <div class="raw33 raw-left">
                            <p>Email</p>
                        </div>
                        <div class="raw66 raw-left">
                            <input data-type="Email" class="vital" type="text" name="email" />
                        </div>
                    </div>
                    <div class="raw100 raw-left">
                        <div class="raw33 raw-left">
                            <p>Full Name</p>
                        </div>
                        <div class="raw66 raw-left">
                            <input class="vital" type="text" name="full_name" />
                        </div>
                    </div>

<?php if ($this->quarx->get_option("account_type") == 'advanced accounts'){ ?>

                    <div class="raw100 raw-left">
                        <div class="raw33 raw-left">
                            <p>Address</p>
                        </div>
                        <div class="raw66 raw-left">
                            <input type="text" name="address" />
                        </div>
                    </div>
                    <div class="raw100 raw-left">
                        <div class="raw33 raw-left">
                            <p>City</p>
                        </div>
                        <div class="raw66 raw-left">
                            <input type="text" name="city" />
                        </div>
                    </div>
                    <div class="raw100 raw-left">
                        <div class="raw33 raw-left">
                            <p>State/Province</p>
                        </div>
                        <div class="raw66 raw-left">
                            <input type="text" name="state_prov" />
                        </div>
                    </div>
                    <div class="raw100 raw-left">
                        <div class="raw33 raw-left">
                            <p>Zip/Postal Code</p>
                        </div>
                        <div class="raw66 raw-left">
                            <input id="location" type="text" name="location" onblur="locateMe('<?= $root; ?>', this.value, '')" />
                        </div>
                    </div>
                    <div class="raw100 raw-left">
                        <div class="raw33 raw-left">
                            <p>Country</p>
                        </div>
                        <div class="raw66 raw-left">
                            <input type="text" name="country" />
                        </div>
                    </div>
                    <div class="raw100 raw-left">
                        <div class="raw33 raw-left">
                            <p>Phone</p>
                        </div>
                        <div class="raw66 raw-left">
                            <input type="text" name="phone" />
                        </div>
                    </div>
                    <div class="raw100 raw-left">
                        <div class="raw33 raw-left">
                            <p>Fax</p>
                        </div>
                        <div class="raw66 raw-left">
                            <input type="text" name="fax" />
                        </div>
                    </div>
                    <div class="raw100 raw-left">
                        <div class="raw33 raw-left">
                            <p>Website</p>
                        </div>
                        <div class="raw66 raw-left">
                            <input type="text" name="website" />
                        </div>
                    </div>
                    <div class="raw100 raw-left">
                        <div class="raw33 raw-left">
                            <p>Company</p>
                        </div>
                        <div class="raw66 raw-left">
                            <input type="text" name="company" />
                        </div>
                    </div>

<?php }else{ ?>

                    <div class="raw100 raw-left">
                        <div class="raw33 raw-left">
                            <p>Location</p>
                        </div>
                        <div class="raw66 raw-left">
                            <input id="location" type="text" name="location" onblur="locateMe('<?= $root; ?>', this.value, '')" />
                        </div>
                    </div>

<?php } ?>

                    <div class="raw100 raw-left">
                        <div class="raw33 raw-left">
                            <p>Profile Image</p>
                        </div>
                        <div class="raw66 raw-left">
                            <input type="file" name="userfile" size="20" />
                        </div>
                    </div>
                    <div class="raw100 raw-left">
                        <div class="raw30 raw-right">
                            <input id="addBtn" data-theme="d" type="submit" value="Add User" />
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php

    if ($this->quarx->get_option("account_type") == 'advanced accounts')
    {
        echo '<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=false"></script>';
        echo '<script type="text/JavaScript" src="'.$root.'js/googlemaps.js"></script>';
    }

    $this->carabiner->display("quarx-add-users");

?>

<?php //End of File ?>