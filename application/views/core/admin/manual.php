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

<div id="quarx-device" class="quarx-device">
    <div id="quarx-manual-menu" class="quarx-manual-menu mHide tHide">
        <div id="quarx-manual-menu-content">
            <h3 style="cursor: pointer;" onclick="pageScroll('#device')">Menu</h3>
            <hr />
            <ul>
                <li onclick="pageScroll('#intro')">Introduction</li>
                <?php if($this->session->userdata('permission') == 1){ ?>
                <h2>Admin</h2>
                <?php if($this->session->userdata('user_id') == 1){ ?>
                <li onclick="pageScroll('#admin-setup')">Setup</li>
                <li onclick="pageScroll('#admin-jsonp')">JSONP</li>
                <li onclick="pageScroll('#admin-atomic')">Atomic</li>
                <li onclick="pageScroll('#admin-modules')">Modules</li>
                <li onclick="pageScroll('#admin-imagetools')">Image Tools</li>
                <li onclick="pageScroll('#admin-unittests')">Unit Tests</li>
                <?php } ?>
                <li onclick="pageScroll('#admin-cloudCatcher')">CloudCatcher</li>
                <li onclick="pageScroll('#admin-cloudInfo')">CloudInfo</li>
                <li onclick="pageScroll('#admin-cloudMail')">CloudMail</li>
                <?php } ?>

                <?php get_module_manual_menu(); ?>

            </ul>
        </div>
    </div>

    <div id="quarx-manual-menu-title" onclick="showMenu()">
        <h1>Menu</h1>
    </div>

    <div class="raw75 align-left quarx-manual-content">
        <div class="raw100">
            <h1>Quarx Manual</h1>
        </div>
        
        <div class="raw100" id="intro">    
            <h1>Introduction</h1>
                <p>Quarx is built using the core framework of CodeIgniter. Quarx is all about enabling developers to cut a considerable amount of time out of their development process. Clean, smooth, and simple, we've done our best to construct this system to work accordingly. We give you the power to perform a fast installation and auto build a bare bones front-end, that cleanly integrates with the backend system. We also give you the power to develop your own modules and tweak anything existing as you see fit. What makes Quarx different is its lack of templates, and its ability to pair with Atomic. Rather than allowing a site to become a dull plug-n-play-who-cares-boring-to-browse website/application, we give you the building blocks you need to build powerful systems. However, that doesn't mean that you cannot use it to power a template system or restructure many parts of it to utilize template structures.</p>
        </div>

        <?php if($this->session->userdata('permission') == 1){ ?>
        <div class="raw100" id="admin-setup">   
            <h1>Setup</h1>
                <p>Quarx has a very simplistic setup process, basically, download the zip, unzip files, deploy to server and proceed with the given instructions. However, there are extra parts of the Quarx setup which require some further explanation.</p>
                <h3>Master Access</h3>
                <p>Master access allows or dis-allows non-master level users to use the plugins. For example. If you have a list of members but do not wish for them to contribute to the group blog, you can deny them that privilage, or if you wish, you can give it to a few members by giving them master status. One of the most handy features of master access, is, if its enabled, then those who are given master status can give other users master status, but those who give others master status are then labelled as their guarantor, that they will not abuse thier new privilages. This is useful, as it can help with tracking down anyone who may be damaging the site/application if such a situation arrises.</p>
                <h3>Advanced Accounts</h3>
                <p>Advanced account is exactly what it sounds like. It allows the Quarx system to collect more information for the system accounts. Don't worry if you didn't initially select it as it can be activated at any time. It can also be turned off, without any information being lost. This simple approach can enable you to grow and pull in new information if necessary.</p>
                <h3>Environment (Development)</h3>
                <p>As with all CodeIgniter applications you can easily define the environment variable in the index.php file. With Quarx we've added some features to the development environment. Now when you declaire a development environment we display the elapsed process time as well as the memory usage of the application in that instance.</p>
                <h3>Details to Customize</h3>
                <p>There are numberous parts of Quarx that you can customize to build a powerful application and 99% of the details are covered on <a href="http://codeigniter.com" target="_blank">CodeIgniter's website</a>. However, there some things that are unique to Quarx such as:</p>
                <p class="quarx-align-center"><b>Controllers</b></p>
                <p><b>Error</b>: Lines 28 and 50 require an email address to recieve error messages.</p>
                <p><b>Tests</b>: Add any tests you want.</p>
                <p><b>Accounts</b>: Line 221 you may want to choose where the email comes from.</p>
                <p><b>Login</b>: Line 282 same as above.</p>
                <br />
                <p class="quarx-align-center"><b>Controllers (that can be deleted post installation)</b></p>
                <p><b>DB_connet.php</b>: It no longer serves a purpose.</p>
                <p><b>Deploy_atomic.php</b>: After you've added atomic its useless.</p>
                <p><b>Connect_to_atomic.php</b>: After you've connected to atomic its useless.</p>
                <p><b>Install.php</b>: After installtion its useless.</p>
                <p><b>User.php</b>: After you've added the main user it doesn't serve a purpose.</p>
                <p><b>Complete.php</b>: After you've completed the installation it no longer does anything.</p>
                <br />
        </div>

        <div class="raw100" id="admin-jsonp">   
            <h1>JSONP</h1>
                <p>Quarx comes with a small set of jsonp functions that can be found in /application/controllers/jsonp/. The one supplied with Quarx by default is a basic one that can enable a user to log in via jsonp method. This can be useful if/when you're trying to build a mobile app that still has access to the core to Quarx. Be cautious when using this method and any security holes you may open.
        </div>

        <div class="raw100" id="admin-atomic">   
            <h1>The Atomic Framework</h1>
                <p>The Atomic Framework is in many ways a counterpart to Quarx. It is a barebones framework for the front-end of your website/application. It is developed as an extention of Quarx, as it is prebuilt to read all it needs from the database, but is otherwise completely separate. </p>
                <p>If you're looking to deploy the Atomic Framework as part of your Quarx installation. Please follow these steps:</p>
                <ol>
                    <li>Go to Admin -> Setup</li>
                    <li>On the Admin Setup page you will see a button "Add the Atomic Framework" Click this button <br />** Please be sure that your Quarx is installed in a folder titled "Quarx", "Admin" or something else, this setup deploys the Atomic framework to the parent folder of the folder containing Quarx, if you do not have access to that or it is outside your public_html then it will not be visible or fully functional." Example: Your root directory is the most ideal location -> http://example.com/</li>
                    <li>This will return you to the master Setup screen. Once here you can click the button "Connect to the Atomic Framework". This will set the database of the Atomic framework to the same as Quarx. Please understand that you must do this action prior to setting up any plugins. This is because the plugins have files that are deployed into the Atomic framework and if it is not available then the plugins will fail to install properly.</li>
                    <li>After returning again to the master Setup screen you should now see the button to view Quarx Plugins. If you wish to install any please select this. Otherwise, checkout your website in order to see the barebones Atomic Framework.</li>
                </ol>
        </div>

        <div class="raw100" id="admin-modules">   
            <h1>Modules</h1>
                <p>Modules are added very easily by taking the sample module and using it as a backbone to your own modules. The sample module is found: 
                <br /><br />
                quarx/application/modules/
                <br /><br />
                and for Atomic
                <br /><br />
                website.com/application/modules
                <br /><br />
                You will need to add the appropriate SQL to your database, if your module requires it.
                </p>
        </div>

        <div class="raw100" id="admin-imagetools">   
            <h1>Image Tools</h1>
                <p>**Note that the application/libraries/image_tools.php file holds the following functions**</p>
                <p>The image tools have a few built in functions to enable the image library panel in your module. To add the button that will call the image panel, simply place this function where you want the button with a string or without: <br />

                <pre class="prettyprint">
&lt;?php imageGalleryButton("button text"); ?&gt;
                </pre>

                In your page. This will enable the user to interact with the prebuilt image library panel. In order to enable the panel to be displayed you need to add the following function to your controller: <br />

                <pre class="prettyprint">
&lt;?php addImageGallery(); ?&gt;
                </pre>

                The other function available in the Image tools is the image collection selector. You may wish to allow users to connect a whole image collection to your module entry. To add the image collection selector simply add:

                <pre class="prettyprint">
&lt;?php imgLibrarySelect(); ?&gt; // Note that the POST name is quarx_img_library
                </pre>
                
                </p>
        </div>

        <div class="raw100" id="admin-unittests">   
            <h1>Unit Tests</h1>
                <p>Unit Tests are the primary portion of what is known as Test Driven Development (TDD). Quarx provides you with a simple tool to do some simple Unit Testing as well as some more powerful testing. 
                <br /><br />
                Please review the library/unit.php to see some details as well the controller/admin/tests.php to examples in action. 
                <br /><br />
                Quarx has various tests that will run, and can be seen when the application is in development mode, or by setting their config to true in the config/config.php file.
                <br /><br />
                The unit.php test allows you to perform simple tests, while the c_test allows you to perform entire controller actions in your tests to ensure functionality.
                </p>
        </div>
        <?php } ?>

        <?php if($this->session->userdata('permission') == 1){ ?>

        <div class="raw100" id="admin-cloudCatcher">   
            <h1>CloudCatcher: Your Website/Application Backup Tool</h1>
                <p>CloudCatcher, gives you the power to run full backups of your website/application. Not only does CloudCatcher zip all your files into a neat and tidy download, it also grabs your entire database and conviniently places it inside the zipped backup of your Quarx system. </p>
                <br />
                <p>Please be aware in order to utilize the power of CloudCatcher you need to have at least twice the hard drive space available as your website takes. Ex. If your website is 20mb in size, you need at least 40mb of server space to perform the backup opperation. Add to the total size your estimated database size. Ex. If your database is 10mb, you then need at least 50mb of hard drive space to perform the backup.</p>
        </div>

        <div class="raw100" id="admin-cloudInfo">   
            <h1>CloudInfo: Your Server Information</h1>
                <p>CloudInfo provides a bundle of information regarding your server. It lets you know how much hard drive space your site is currently consuming as well as the various details of your PHP configuration.</p>
        </div>

        <div class="raw100" id="admin-cloudMail">   
            <h1>CloudMail: Your Website Email Tool</h1>
                <p>CloudMail, is a very simple tool that enables you to connect directly (via email) with all the accounts in your Quarx system. In case you have a group of memebers within your website/application we provide you with a simple tool to email them whatever you wish to. Simply select who you want to connect with and write out your message.</p>
        </div>

        <?php } ?>

        <?php get_module_manual(); ?>
        
    </div>
</div>

<script src="https://google-code-prettify.googlecode.com/svn/loader/run_prettify.js?autoload=true&skin=sunburst&lang=css" defer="defer"></script>
<script type="text/javascript">
    
    function pageScroll (box) {
        var destination = $(box).offset().top;
        $("html:not(:animated),body:not(:animated)").animate({ scrollTop: destination-20}, 500 );
        return false;
    }

    function showMenu(){
        $('#quarx-manual-menu').show();
    }

    function setMenu(){
        if($(window).width() > 960){
            
            $(window).scroll(function(){
                $('#quarx-manual-menu').hide();
                
                $('#quarx-manual-menu').css({
                    top: 44 + $(window).scrollTop()
                });
                
                $('#quarx-manual-menu').fadeIn("fast");
            });

            $('.quarx-manual-content').attr("style", "");
            $('#quarx-manual-menu-title').fadeOut("fast");
        }else{
            $('.quarx-manual-content').css("margin-left", "0");
            $('#quarx-manual-menu-title').hide();
        }
    }

    $(function(){
        setMenu();
    });
    
    $(window).resize(function(){
        setMenu();
    });

</script>

<?php /* End of File */ ?>