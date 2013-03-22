<?php /*
    Filename:   mainmenu.php
    Location:   /application/views/common/
    Author:     Matt Lantz
*/ ?>

<div id="header_menu" class="wide_box" style="overflow: visible;">

    <ul id="menu">

        <?php if($this->session->userdata('logged_in')){ ?>
            <li><a class="leftborder" href="<?php echo site_url('admin'); ?>">Admin</a>
                <ul>
                    <li onclick="document.location='<?php echo site_url('admin/manual'); ?>'"><a>Manual</a></li>
                    <?php if($this->session->userdata('permission') == 1){ ?>
                    <li onclick="window.location='<?php echo site_url('admin/cloudinfo'); ?>'"><a>CloudInfo</a></li>
                    <li onclick="window.location='<?php echo site_url('admin/cloudmail'); ?>'"><a>CloudMail</a></li>
                    <li onclick="window.location='<?php echo site_url('admin/cloudcatcher'); ?>'"><a>CloudCatcher</a></li>
                    <li onclick="document.location='<?php echo site_url('admin/about'); ?>'"><a>About</a></li>
                        <?php if($this->session->userdata('user_id') == 1){ ?>
                        <li onclick="window.location='<?php echo site_url('setup'); ?>'"><a>Setup</a></li>
                        <?php } ?>
                    <?php } ?>
                </ul>
            </li>
        <?php } ?>

        <?php if($this->session->userdata('logged_in')){ ?>
            <?php $class = ''; ?>
            <li><a <?php echo $class; ?> href="<?php echo site_url('logout'); ?>">Sign Out</a></li>
        <?php }else{ ?>
            <?php $class = 'class="leftborder"'; ?>
            <li><a <?php echo $class; ?> href="<?php echo site_url('login'); ?>">Sign In</a></li>
        <?php } ?>
        
        <?php if($this->session->userdata('logged_in')){ ?>

            <?php foreach ($GLOBALS['menu_build'] as $menu): ?>

            <li><a href="<?php echo site_url($menu['name']); ?>"><?php echo $menu['title']; ?></a>
                <ul>

                    <?php $sub_menu_array = json_decode($menu['pages']); ?>
                   
                    <?php foreach ($sub_menu_array as $sub_menu): ?> 

                        <li onclick="document.location='<?php echo site_url($sub_menu->url_title); ?>'"><a><?php echo $sub_menu->title; ?></a></li>
                   
                    <?php endforeach; ?>
                </ul>
            </li>

            <?php endforeach; ?>
            
            <li><a href="<?php echo site_url('accounts'); ?>">Accounts</a>
                <ul>
                    <li onclick="document.location='<?php echo site_url('accounts'); ?>'"><a>My Account</a></li>
                    <li onclick="window.location='<?php echo site_url('accounts/password'); ?>'"><a>Update Password</a></li>
                    <?php if($this->session->userdata('permission') == 1){ ?>
                    <li onclick="document.location='<?php echo site_url('accounts/add'); ?>'"><a>Add an Account</a></li>
                    <li onclick="window.location='<?php echo site_url('accounts/view'); ?>'"><a>View Accounts</a></li>                  
                    <?php } ?>
                </ul>
            </li>
        
        <?php } ?>

    </ul>

</div>

<div id="body">

<?php /* End of File */ ?>