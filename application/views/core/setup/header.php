<?php /*
    Filename:   header.php
    Location:   /application/views/core/setup/
*/ ?>

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
    <link rel="stylesheet" href="<?php echo $root; ?>css/desktop-style.css" lang="EN" dir="ltr" type="text/css" />
    <link rel='stylesheet' media='screen and (min-width: 768px) and (max-width: 960px)' href='<?php echo $root; ?>css/tablet-style.css' />
    <link rel='stylesheet' media='screen and (min-width: 320px) and (max-width: 768px)' href='<?php echo $root; ?>css/mobile-styles.css' />

    <script type="text/javascript" src="<?php echo $root; ?>js/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo $root; ?>js/quarxfunc.js"></script>
    <script type="text/javascript" src="<?php echo $root; ?>js/jquery.mobile.min.js"></script>

    <script type="text/javascript">

        $.mobile.ajaxEnabled = false;
            
    </script>

</head>

<body>

    <div id="big_box" data-role="page" data-theme="a">

        <?php $this->load->view('common/mainmenu'); ?>
    
        <div id="header" data-role="header">
            <?php if(isset($masterPage) == true){ ?>
                <a href="#Menu" data-role="button" data-icon="bars">Menu</a>
            <?php }else{ ?>
                <a data-rel="back" data-icon="back" data-iconpos="notext"></a>
            <?php } ?>
            <h2><img src="<?php echo $root; ?>images/quarx.png" style="width: 15px;" /> Quarx Setup</h2>
        </div>
        
        <div id="body" data-role="content">
            <div class="smallDevice">
            
<?php /* End of File */ ?>