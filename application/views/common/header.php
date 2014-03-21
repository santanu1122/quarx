<?php

/**
 * Quarx
 *
 * A modular CMS application
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
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, maximum-scale=1">

    <title>Quarx | <?= $pagetitle; ?></title>

    <?php //$this->carabiner->css('http://fonts.googleapis.com/css?family=Source+Sans+Pro:400,700,400italic,700italic'); ?>

    <!-- Quarx Custom Styles -->
    <link rel="shortcut icon" type="image" href="<?= $root; ?>images/favicon.ico" />
    <link rel="stylesheet" href="<?= $root; ?>css/raw.min.css" />

    <!-- jQuery -->
    <link rel="stylesheet" href="<?= $root; ?>js/themes/jquery.mobile.structure.min.css" />
    <script type="text/javascript" src="<?= $root; ?>js/jquery.min.js"></script>
    <script type="text/javascript" src="<?= $root; ?>js/jquery-migrate.min.js"></script>
    <script type="text/javascript" src="<?= $root; ?>js/jquery.mobile.min.js"></script>

    <!-- Redactor -->
    <link rel="stylesheet" href="<?= $root; ?>js/redactor/redactor.css" />
    <script type="text/javascript" src="<?= $root; ?>js/redactor/redactor.min.js"></script>

    <?php $this->carabiner->css('quarx-desktop-style.css'); ?>
    <?php $this->carabiner->css('quarx-tablet-style.css', 'screen and (min-width: 320px) and (max-width: 960px)'); ?>
    <?php $this->carabiner->css('quarx-mobile-style.css', 'screen and (min-width: 120px) and (max-width: 668px)'); ?>

    <!-- jQuery Plugins -->
    <?php $this->carabiner->js('jquery.deefault.js'); ?>
    <?php $this->carabiner->js('jquery.tooltip.js'); ?>

    <!-- jQuery Mobile Quarx Theme -->
    <?php $this->carabiner->css($root.'js/themes/'.$this->config->item('theme').'.css'); ?>
    <?php $this->carabiner->js('quarx-tools.js'); ?>
    <?php $this->carabiner->js('quarx-dialogs.js'); ?>
    <?php $this->carabiner->js('quarx-notify.js'); ?>
    <?php $this->carabiner->js('quarx.js'); ?>
    <?php $this->carabiner->js('quarx-footer.js'); ?>
    <?php $this->carabiner->js('vague.js'); ?>

    <?php $this->carabiner->display(); ?>

    <!--[if gte IE 7]>
    <link rel="stylesheet" type="text/css" href="<?= $root; ?>css/ie.css" />
    <![endif]-->

    <!-- Custom Scripts -->
    <script type="text/javascript">

    _quarxBlurBG = true;
    _quarxRootURL = "<?= site_url(); ?>";
    _quarxSecurityHash = "<?= $this->security->get_csrf_hash(); ?>";

    <?php $this->module_tools->get_module_js(); ?>
    </script>

    <style type="text/css">
    <?php $this->module_tools->get_module_css(); ?>
    </style>

</head>

<body>

    <div id="quarx-wrapper" data-role="page" data-url="<?= $pagetitle; ?>" data-theme="a" style="overflow-x: hidden;"><!-- beginning of all body contents -->

        <div class="quarx-notification">
            <div class="quarx-notify">
                <p class="quarx-notify-title"></p>
                <p class="quarx-notify-comment"></p>
            </div>
            <div class="quarx-notify-closer">
                <button data-role="button" data-icon="delete" class="quarx-notify-closer-icon" data-iconpos="notext"></button>
            </div>
        </div>

        <?php

            if ($GLOBALS["quarx"]["quarx-image-library-enabled"]) $this->load->view('core/images/frames/library');

        ?>

        <?php

            if ($this->session->userdata('logged_in'))
            {
                if ($this->quarx->is_installed()) $this->load->view('common/main_menu');
                if ($this->quarx->is_installed()) $this->load->view('common/profile_menu');
            }

        ?>

        <div id="quarx-header" data-role="header">
            <?php

                if ($this->session->userdata('logged_in') && $this->quarx->is_installed())
                {
                    echo '<a class="quarx-top-menu-icons" href="#quarx-main-menu" data-role="button" data-icon="quarx-bars" data-iconpos="notext" data-tooltip="Menu"></a>';
                }
                else if ($this->quarx->is_installed())
                {
                    echo '<a class="quarx-top-menu-icons" href="'.site_url('login').'" data-iconpos="notext" data-role="button" data-icon="quarx-login" data-tooltip="Login"></a>';
                }

            ?>

            <h1> <?= $pagetitle; ?> </h1>

            <?php

                if ($this->session->userdata('logged_in'))
                {
                    echo '<a class="quarx-top-menu-icons" href="#quarx-profile-menu" data-role="button" data-icon="gear" data-iconpos="notext" data-tooltip="Accounts"></a>';
                }

            ?>
        </div>

        <div id="quarx-body" data-role="content">

<?php /* End of File */ ?>