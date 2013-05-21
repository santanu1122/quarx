<?php /*
    Filename:   mainmenu.php
    Location:   /application/views/common/
*/ ?>

<div data-role="panel" data-display="reveal" id="Menu" class="menuPanel panelBox">
    
    <h2 style="margin: -15px 0 15px 0; padding: 0px; line-height: 2.6em;"><img src="<?php echo $root; ?>images/quarx.png" width="15px" /> Quarx </h2>

    <ul id="menu" data-role="listview">

        <?php if($this->session->userdata('logged_in')){ ?>
            <li><a href="<?php echo site_url('logout'); ?>">Sign Out</a></li>
        <?php }else{ ?>
            <li><a href="<?php echo site_url('login'); ?>">Sign In</a></li>
        <?php } ?>
        
        <?php if($this->session->userdata('logged_in')){ ?>
            
            <li><a href="<?php echo site_url('accounts'); ?>">My Account</a></li>
            <li><a href="<?php echo site_url('accounts/password'); ?>">Update Password</a></li>
            <?php if($this->session->userdata('permission') == 1){ ?>
            <li><a href="<?php echo site_url('accounts/add'); ?>">Add an Account</a></li>
            <li><a href="<?php echo site_url('accounts/view'); ?>">View Accounts</a></li>                  
            <?php } ?>

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
                    <li onclick="window.location='<?php echo site_url('admin/cloudmail'); ?>'"><a>Admin - CloudMail</a></li>
                    <li onclick="window.location='<?php echo site_url('admin/cloudcatcher'); ?>'"><a>Admin - CloudCatcher</a></li>

                    <li><a href="<?php echo site_url('admin/manual'); ?>">Manual</a></li>
                    
                <?php if($this->session->userdata('user_id') == 1){ ?>

                <li><a href="<?php echo site_url('setup'); ?>">Setup</a></li>
                <li><a href="<?php echo site_url('admin/about'); ?>">About</a></li>

                <?php } ?>
            <?php } ?>

        <?php } ?>

        <?php } ?>

    </ul>   

    <a href="#" data-rel="close" data-icon="delete" data-role="button" style="margin-top: 25px;">Close</a>

</div>

<?php /* End of File */ ?>