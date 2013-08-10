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
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="description" content="A simple to use, responsive design CMS system." />
    <meta name="keywords" content="CMS System, Zen, Responsive Design" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <title>Quarx | <?php echo $pagetitle; ?></title>

    <link rel="shortcut icon" type="image" href="<?php echo $root; ?>images/favicon.ico" />
    <link rel="stylesheet" href="<?php echo $root; ?>js/themes/jquery.mobile.structure.min.css" />
    <link rel="stylesheet" href="<?php echo $root; ?>js/themes/quarx.css" />
    <link rel="stylesheet" href="<?php echo $root; ?>css/raw.min.css" />
    <link rel="stylesheet" href="<?php echo $root; ?>css/quarx-desktop-style.css" lang="EN" dir="ltr" type="text/css" />
    <link rel='stylesheet' media='screen and (min-width: 768px) and (max-width: 960px)' href='<?php echo $root; ?>css/quarx-tablet-style.css' />
    <link rel='stylesheet' media='screen and (min-width: 320px) and (max-width: 668px)' href='<?php echo $root; ?>css/quarx-mobile-styles.css' />

    <script type="text/javascript" src="<?php echo $root; ?>js/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo $root; ?>js/quarxfunc.js"></script>
    <script type="text/javascript" src="<?php echo $root; ?>js/jquery.mobile.min.js"></script>

    <!-- jquery plugins -->
    <script type="text/javascript" src="<?php echo $root; ?>js/jquery.deefault.js"></script>
    <script type="text/javascript" src="<?php echo $root; ?>js/jquery.tooltip.js"></script>

    <script type="text/javascript">

        $.mobile.ajaxEnabled = false;

        $(document).ready(function() {
            $(".top_menu_icons").tooltip();
        });
            
    </script>

</head>

<body>

    <div id="quarx" data-role="page" data-theme="a">

            <?php $this->load->view('common/main_menu'); ?>

        <?php if($this->session->userdata('logged_in')){ ?>
            <?php $this->load->view('common/profile_menu'); ?>
        <?php } ?>

        <div id="header" data-role="header">
            <?php if(isset($masterPage)){ ?>
                <a class="quarx-top-menu-icons" href="#quarx-main-menu" data-role="button" data-icon="bars" data-iconpos="notext" data-tooltip="Menu"></a>
            <?php }else{ ?>
                <a class="quarx-top-menu-icons" data-rel="back" data-icon="back" data-iconpos="notext"></a>
            <?php } ?>
            <h2><img src="<?php echo $root; ?>images/quarx.png" style="width: 15px;" /> Quarx Setup</h2>

            <?php if($this->session->userdata('logged_in')){ ?>
            <a class="quarx-top-menu-icons" href="#quarx-profile-menu" data-role="button" data-icon="gear" data-iconpos="notext" data-tooltip="My Account"></a>
            <?php } ?>
        </div>
        
        <div id="body" data-role="content">
            <div class="quarx-small-device">
            
<?php /* End of File */ ?>