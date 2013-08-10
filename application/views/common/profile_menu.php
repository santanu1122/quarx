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

<div data-role="panel" data-display="overlay" data-position="right" id="quarx-profile-menu" class="quarx-account-menu-panel quarx-panel-box">
    <div class="account-menu-box">
        <h2 class="quarx-menu-title">My Account</h2>
    </div>
    
    <ul id="quarx-account-menu" data-role="listview">
        
        <?php if($this->session->userdata('logged_in')){ ?>
            
            <li data-icon="home"><a href="<?php echo site_url('accounts'); ?>">My Account</a></li>
            <li data-icon="quarx-login"><a href="<?php echo site_url('accounts/password'); ?>">Update Password</a></li>
            <?php if($this->session->userdata('permission') == 1){ ?>
            <li data-icon="quarx-add-user"><a href="<?php echo site_url('accounts/add'); ?>">Add an Account</a></li>
            <li data-icon="quarx-all-users"><a href="<?php echo site_url('accounts/view'); ?>">View Accounts</a></li>                  
            <?php } ?>

            <li data-icon="gear"><a href="<?php echo site_url('settings'); ?>">Settings</a></li>

        <?php } ?>

        <?php if($this->session->userdata('logged_in')){ ?>
            <li data-icon="quarx-power"><a href="<?php echo site_url('logout'); ?>">Sign Out</a></li>
        <?php }else{ ?>
            <li><a href="<?php echo site_url('login'); ?>">Sign In</a></li>
        <?php } ?>

    </ul>   

</div>

<?php /* End of File */ ?>