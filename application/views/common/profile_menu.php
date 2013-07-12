<?php

/**
 * Quarx
 *
 * A modular CMS built on CodeIgniter
 *
 * @package     Quarx
 * @author      Matt Lantz
 * @copyright   Copyright (c) 2013 Matt Lantz
 * @license     http://ottacon.co/quarx/license
 * @link        http://ottacon.co/quarx
 * @since       Version 1.0
 * 
 */
    
?>

<div data-role="panel" data-display="overlay" data-position="right" id="profileMenu" class="accountMenuPanel panelBox">
    <div class="account-menu-box">
        <h2>My Account</h2>
    </div>
    
    <ul id="account_menu" data-role="listview">
        
        <?php if($this->session->userdata('logged_in')){ ?>
            
            <li><a href="<?php echo site_url('accounts'); ?>">My Account</a></li>
            <li><a href="<?php echo site_url('accounts/password'); ?>">Update Password</a></li>
            <?php if($this->session->userdata('permission') == 1){ ?>
            <li><a href="<?php echo site_url('accounts/add'); ?>">Add an Account</a></li>
            <li><a href="<?php echo site_url('accounts/view'); ?>">View Accounts</a></li>                  
            <?php } ?>

            <li><a href="<?php echo site_url('settings'); ?>">Settings</a></li>

        <?php } ?>

        <?php if($this->session->userdata('logged_in')){ ?>
            <li><a href="<?php echo site_url('logout'); ?>">Sign Out</a></li>
        <?php }else{ ?>
            <li><a href="<?php echo site_url('login'); ?>">Sign In</a></li>
        <?php } ?>

    </ul>   

</div>

<?php /* End of File */ ?>