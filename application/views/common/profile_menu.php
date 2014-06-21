<?php

/**
 * Quarx
 *
 * A modular CMS application
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

<div data-role="panel" data-display="overlay" data-position="right" id="quarx-profile-menu" class="quarx-account-menu-panel quarx-panel-box">
    <div class="account-menu-box">
        <h2 class="quarx-menu-title">Accounts</h2>
    </div>

    <ul id="quarx-account-menu" data-role="listview">

        <?php

            if ($this->session->userdata('logged_in'))
            {
                echo '<li data-icon="home"><a href="'.site_url('users/profile').'">My Account</a></li>';
                echo '<li data-icon="quarx-login"><a href="'.site_url('users/password').'">Update Password</a></li>';

                if ($this->session->userdata('permission') == 1 && $this->config->item("quarx-mode") !== "application")
                {
                    echo '<li data-icon="quarx-add-user"><a href="'.site_url('users/add').'">Add a User</a></li>';
                    echo '<li data-icon="quarx-all-users"><a href="'.site_url('users/view').'">View Users</a></li>';
                }

                echo '<li data-icon="gear"><a href="'.site_url('users/settings').'">Settings</a></li>';
            }

        ?>

        <?php

            if($this->session->userdata('logged_in'))
            {
                echo '<li data-icon="quarx-power"><a href="'.site_url('logout').'">Log Out</a></li>';
            }
            else
            {
                echo '<li><a href="'.site_url('login').'">Log In</a></li>';
            }

        ?>

    </ul>

</div>

<?php /* End of File */ ?>