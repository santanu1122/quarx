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
 * @link        http://quarx.ottacon.co
 * @since       Version 1.0
 * 
 */

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <link rel="stylesheet" href="<?php echo $root; ?>js/themes/jquery.mobile.structure.min.css" />
    <link rel="stylesheet" href="<?php echo $root; ?>js/themes/quarx.css" />
    <link rel="stylesheet" href="<?php echo $root; ?>css/desktop-style.css" lang="EN" dir="ltr" type="text/css" />

    <script type="text/javascript" src="<?php echo $root; ?>js/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo $root; ?>js/jquery-migrate.min.js"></script>
    <script type="text/javascript" src="<?php echo $root; ?>js/quarxfunc.js"></script>
    <script type="text/javascript" src="<?php echo $root; ?>js/jquery.mobile.min.js"></script>

    <script type="text/javascript">
        $.mobile.ajaxEnabled = false;     
        $.mobile.selectmenu.prototype.options.nativeMenu = false;  
        $(document).ready(function(){
            if(window.frameElement.getAttribute('data-location') == 'fullScreen'){
                $('#fullScreenImageLibraryHeader').remove();
                $('#newCollection').css('top', '122px');
            }
        });
    </script>

    <!--[if gte IE 7]>
    <link rel="stylesheet" type="text/css" href="<?php echo $root; ?>css/ie.css" />
    <![endif]-->
</head>
<body>

    <div data-theme="a">

        <div id="fullScreenImageLibraryHeader" data-role="header">
            <h1><a href="<?php echo site_url('image') ?>">Image Library</a></h1>
            <?php if(!isset($libraryHome)){ ?>
            <a data-rel="back" data-role="button">Back</a>
            <?php }else{ ?>
            <a href="<?php echo site_url('image'); ?>" data-role="button" data-icon="refresh" data-iconpos="notext"></a>
            <?php }?>
        </div>

        <div id="body" data-role="content">
            
<?php /* End of File */ ?>