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

<div data-role="panel" data-display="reveal" id="quarx-main-menu" class="quarx-menu-panel quarx-panel-box">
    
    <h2 class="quarx-menu-title"><img src="<?php echo $root; ?>images/quarx.png" width="15px" /> Quarx </h2>

    <ul id="quarx-menu" data-role="listview">
        
        <?php if($this->session->userdata('logged_in')){ ?>

            <?php get_module_menus(); ?>

             <?php get_special_module_menus(); ?>
            
            <?php if($this->session->userdata('permission') > 1){ ?>
            <?php if(check_master_access() == false){ ?>
            
            <li><a href="<?php echo site_url('image/library'); ?>">Image Library</a></li>
            <?php } ?>
            <?php }else{ ?>
            <li><a href="<?php echo site_url('image/library'); ?>">Image Library</a></li>
            <?php } ?>

                <?php if($this->session->userdata('permission') == 1){ ?>
                    <li><a href="<?php echo site_url('admin/cloudinfo'); ?>">Admin - CloudInfo</a></li>
                    <li><a href="<?php echo site_url('admin/cloudmail'); ?>">Admin - CloudMail</a></li>
                    <li><a href="<?php echo site_url('admin/cloudcatcher'); ?>">Admin - CloudCatcher</a></li>

                    <li><a href="<?php echo site_url('admin/manual'); ?>">Manual</a></li>
                    
                <?php if($this->session->userdata('user_id') == 1){ ?>

                <li><a href="<?php echo site_url('setup'); ?>">Setup</a></li>
                <li><a href="<?php echo site_url('admin/about'); ?>">About</a></li>
                
                <?php if(ENVIRONMENT === "development"): ?>
                <li><a href="<?php echo site_url('admin/tests'); ?>">Unit Tests</a></li>
                <?php endif; ?>

                <?php } ?>
            <?php } ?>

        <?php } ?>

    </ul>

</div>

<?php /* End of File */ ?>