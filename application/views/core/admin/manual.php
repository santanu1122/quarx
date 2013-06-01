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

<div id="device" class="device">
    <div id="manualMenu" class="manualMenu mHide tHide">
        <div id="manualMenuContent">
            <h3 style="cursor: pointer;" onclick="pageScroll('#device')">Menu</h3>
            <hr />
            <ul>
                <li onclick="pageScroll('#intro')">Introduction</li>
                <?php if($this->session->userdata('permission') == 1){ ?>
                <h2>Admin</h2>
                <?php if($this->session->userdata('user_id') == 1){ ?>
                <li onclick="pageScroll('#admin-setup')">Setup</li>
                <li onclick="pageScroll('#admin-atomic')">Atomic</li>
                <li onclick="pageScroll('#admin-modules')">Modules</li>
                <?php } ?>
                <li onclick="pageScroll('#admin-cloudCatcher')">CloudCatcher</li>
                <li onclick="pageScroll('#admin-cloudInfo')">CloudInfo</li>
                <li onclick="pageScroll('#admin-cloudMail')">CloudMail</li>
                <?php } ?>

                <?php get_module_manual_menu(); ?>

            </ul>
        </div>
    </div>

    <div class="raw75 align-left manualContent">
        <div class="raw100">
            <h1>Quarx Manual</h1>
        </div>
        
        <div class="raw100" id="intro">    
            <h1>Introduction</h1>
                <br />
                <p>Quarx is built using the core framework of codeigniter. Quarx is all about enabling developers to cut a considerable amount of time out of their development process, or having many things in one. Clean, smooth, and simple, we've done our best to contruct this system to work accordingly. We give you the powet to perform a fast installation and auto build a bare bones front-end, that cleanly integrates with the backend system. We also give you the power to develop your own plugins and tweak anything existing as you see fit. What makes Quarx different is its lack of templates. Rather than allowing a site to become a dull plug-n-play who cares boring to browse website/application, we give you pre-built bricks you can arrange as you please. </p>
        </div>

        <?php if($this->session->userdata('permission') == 1){ ?>
        <div class="raw100" id="admin-setup">   
            <h1>Setup</h1>
                <br />
                <p>Quarx has a very simplistic setup process, basically, download the zip, unzip files, deploy to server and proceed with the given instructions. However, there are extra parts of the Quarx setup which require some further explanation.</p>
                <br />
                <h3>Master Access</h3>
                <p>Master access allows or dis-allows non-master level users to use the plugins. For example. If you have a list of members but do not wish for them to contribute to the group blog, you can deny them that privilage, or if you wish, you can give it to a few members by giving them master status. One of the most handy features of master access, is, if its enabled, then those who are given master status can give other users master status, but those who give others master status are then labelled as their guarantor, that they will not abuse thier new privilages. This is useful, as it can help with tracking down anyone who may be damaging the site/application if such a situation arrises.</p>
                <br />
                <h3>Advanced Accounts</h3>
                <p>Advanced account is exactly what it sounds like. It allows the Quarx system to collect more information for the system accounts. Don't worry if you didn't initially select it as it can be activated at any time. It can also be turned off, without any information being lost. This simple approach can enable you to grow and pull in new information if necessary.</p>
        </div>

        <div class="raw100" id="admin-atomic">   
            <h1>The Atomic Framework</h1>
                <br />
                <p>The Atomic Framework is in many ways a counterpart to Quarx. It is a barebones framework for the front-end of your website/application. It is developed as an extention of Quarx, as it is prebuilt to read all it needs from the database, but is otherwise completely separate. </p>
                <br />
                <p>If you're looking to deploy the Atomic Framework as part of your Quarx installation. Please follow these steps:</p>
                <br />
                <ol>
                    <li>Go to Admin->Setup</li>
                    <li>On the Admin Setup page you will see a button "Add the Atomic Framework" Click this button ** Please be sure that your Quarx is installed in a folder titled "Quarx", "Admin" or something else, this setup deploys the Atomic framework to the parent folder of the folder containing Quarx, if you do not have access to that or it is outside your public_html then it will not be visible or fully functional." Example: Your root directory is the most ideal location -> http://example.com/</li>
                    <li>This will return you to the master Setup screen. Once here you can click the button "Connect to the Atomic Framework". This will set the database of the Atomic framework to the same as Quarx. Please understand that you must do this action prior to setting up any plugins. This is because the plugins have files that are deployed into the Atomic framework and if it is not available then the plugins will fail to install properly.</li>
                    <li>After returning again to the master Setup screen you should now see the button to view Quarx Plugins. If you wish to install any please select this. Otherwise, checkout your website in order to see the barebones Atomic Framework.</li>
                </ol>
        </div>

        <div class="raw100" id="admin-modules">   
            <h1>Modules</h1>
                <br />
                <p>Modules are installed very simply by downloading the appropriate ZIP file and deploying the module folders into the directory: 
                <br /><br />
                quarx/application/modules/ 
                <br /><br />
                and for Atomic
                <br /><br />
                website.com/application/modules
                <br /><br />
                From that point you will find an SQL file in the module folder meant for Quarx which will be titled Quarx. Please insert the SQL into your database in order for the module to be fully opperational.
                </p>
        </div>
        <?php } ?>

        <?php if($this->session->userdata('permission') == 1){ ?>

        <div class="raw100" id="admin-cloudCatcher">   
            <h1>CloudCatcher: Your Website/Application Backup Tool</h1>
                <br />
                <p>CloudCatcher, gives you the power to run full backups of your website/application. Not only does CloudCatcher zip all your files into a neat and tidy download, it also grabs your entire database and conviniently places it inside the zipped backup of your Quarx system. </p>
                <br />
                <p>Please be aware in order to utilize the power of CloudCatcher you need to have at least twice the hard drive space available as your website takes. Ex. If your website is 20mb in size, you need at least 40mb of server space to perform the backup opperation. Add to the total size your estimated database size. Ex. If your database is 10mb, you then need at least 50mb of hard drive space to perform the backup.</p>
        </div>

        <div class="raw100" id="admin-cloudInfo">   
            <h1>CloudInfo: Your Server Information</h1>
                <br />
                <p>CloudInfo provides a bundle of information regarding your server. It lets you know how much hard drive space your site is currently consuming as well as the various details of your PHP configuration.</p>
        </div>

        <div class="raw100" id="admin-cloudMail">   
            <h1>CloudMail: Your Website Email Tool</h1>
                <br />
                <p>CloudMail, is a very simple tool that enables you to connect directly (via email) with all the accounts in your Quarx system. In case you have a group of memebers within your website/application we provide you with a simple tool to email them whatever you wish to. Simply select who you want to connect with and write out your message.</p>
        </div>

        <?php } ?>

        <?php get_module_manual(); ?>
        
    </div>
</div>

<script type="text/javascript">
    
    function pageScroll (box) {
        var destination = $(box).offset().top;
        $("html:not(:animated),body:not(:animated)").animate({ scrollTop: destination-20}, 500 );
        return false;
    }

    $(window).scroll(function(){
        $('#manualMenu').css({
            top: 40 + $(window).scrollTop()
        });
    });

</script>

<?php /* End of File */ ?>