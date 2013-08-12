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

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <meta name="description" content="A simple to use, responsive design CMS system." />
    <meta name="keywords" content="CMS System, Zen, Responsive Design" />
    <meta name="viewport" content="initial-scale=1, maximum-scale=1">

    <title>Quarx | <?php echo $pagetitle; ?></title>

    <!-- Quarx Custom Styles -->
    <link rel="shortcut icon" type="image" href="<?php echo $root; ?>images/favicon.ico" />
    <link rel="stylesheet" href="<?php echo $root; ?>css/raw.min.css" />
    <link rel="stylesheet" href="<?php echo $root; ?>css/quarx-desktop-style.css" lang="EN" dir="ltr" type="text/css" />
    <link rel='stylesheet' media='screen and (min-width: 320px) and (max-width: 960px)' href='<?php echo $root; ?>css/quarx-tablet-style.css' />
    <link rel='stylesheet' media='screen and (min-width: 120px) and (max-width: 668px)' href='<?php echo $root; ?>css/quarx-mobile-styles.css' />

    <!-- jQuery -->
    <script type="text/javascript" src="<?php echo $root; ?>js/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo $root; ?>js/jquery-migrate.min.js"></script>

    <!-- jQuery Mobile Quarx Theme -->
    <link rel="stylesheet" href="<?php echo $root; ?>js/themes/quarx.css" />
    <link rel="stylesheet" href="<?php echo $root; ?>js/themes/jquery.mobile.structure.min.css" />
    <script type="text/javascript" src="<?php echo $root; ?>js/quarxfunc.js"></script>
    <script type="text/javascript" src="<?php echo $root; ?>js/jquery.mobile.min.js"></script>

    <!-- jquery plugins -->
    <script type="text/javascript" src="<?php echo $root; ?>js/jquery.deefault.js"></script>
    <script type="text/javascript" src="<?php echo $root; ?>js/jquery.tooltip.js"></script>

    <!-- Redactor -->
    <link rel="stylesheet" href="<?php echo $root; ?>js/redactor/redactor.css" />
    <script src="<?php echo $root; ?>js/redactor/redactor.min.js"></script>
    
    <!-- Custom Scripts -->
    <script type="text/javascript">
    <?php get_module_js(); ?>
    </script>

    <style type="text/css">
    <?php get_module_css(); ?>
    </style>

    <script type="text/javascript">
        $.ajaxSetup({
            cache: false
        });

        $.mobile.ajaxEnabled = false;
        $.mobile.selectmenu.prototype.options.nativeMenu = false;
        
        $(document).bind('mobileinit',function(){
            $.mobile.selectmenu.prototype.options.hidePlaceholderMenuItems = false;
            
        });
        
        $(document).ready(function() {
            $(".deefault").deefault();

            $('textarea.rtf').redactor({ 
                minHeight: 275
            });

            $(".quarx-top-menu-icons").tooltip();
        });

    </script>

    <!--[if gte IE 7]>
    <link rel="stylesheet" type="text/css" href="<?php echo $root; ?>css/ie.css" />
    <![endif]-->

</head>

<body>

    <div data-role="page" data-url="<?php echo $pagetitle; ?>" data-theme="a"><!-- beginning of all body contents -->

        <?php if($this->session->userdata('logged_in')){ ?>
            <?php $this->load->view('common/main_menu'); ?>
            <?php $this->load->view('common/profile_menu'); ?>
        <?php } ?>

        <?php if($GLOBALS["quarx-image-gallery-enabled"] === TRUE){ ?>
        <?php $this->load->view('core/image/frames/library_small'); ?>
        <?php } ?>

        <div data-role="header">
            <?php if($this->session->userdata('logged_in')){ ?>
            <a class="quarx-top-menu-icons" href="#quarx-main-menu" data-role="button" data-icon="bars" data-iconpos="notext" data-tooltip="Menu"></a>
            <?php }else{ ?>
            <a class="quarx-top-menu-icons" href="<?php echo site_url('login'); ?>" data-iconpos="notext" data-role="button" data-icon="quarx-login" data-tooltip="Login"></a>
            <?php } ?>

            <h1> <?php echo $pagetitle; ?> </h1>
            
            <?php if($this->session->userdata('logged_in')){ ?>
            <a class="quarx-top-menu-icons" href="#quarx-profile-menu" data-role="button" data-icon="gear" data-iconpos="notext" data-tooltip="My Account"></a>
            <?php } ?>
        </div>

        <div id="quarx-body" data-role="content">
            
<?php /* End of File */ ?>