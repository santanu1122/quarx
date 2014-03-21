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

<div id="quarx-device" class="quarx-device">
    <div id="quarx-manual-menu" class="quarx-manual-menu mHide tHide">
        <div id="quarx-manual-menu-content">
            <h3 style="cursor: pointer;" onclick="pageScroll('#device')">Menu</h3>
            <hr />
            <ul>
                <li onclick="pageScroll('#intro')">Introduction</li>
                <?php

                    if (isset($diaplayAdminManual))
                    {
                        echo '<h2>Admin</h2>';
                        echo '<li onclick="pageScroll(\'#admin-cloudCatcher\')">CloudCatcher</li>';
                    }

                    if (isset($diaplayMasterManual))
                    {
                        echo '<li onclick="pageScroll(\'#admin-setup\')">Setup</li>';
                        echo '<li onclick="pageScroll(\'#admin-atomic\')">Atomic</li>';
                        echo '<li onclick="pageScroll(\'#admin-modules\')">Modules</li>';
                        echo '<li onclick="pageScroll(\'#admin-imagetools\')">Image Tools</li>';
                        echo '<li onclick="pageScroll(\'#admin-tests\')">Tests</li>';
                    }

                    $this->module_tools->get_module_manual_menu();

                ?>

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
            <p><b>/tests</b>: Add any tests you want.</p>
            <p><b>Users</b>: Line 266 you may want to choose where the email comes from.</p>
            <p><b>Login</b>: Line 177 same as above.</p>
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

                <pre class="prettyprint">&lt;?php $this->image_tools->imageLibraryButton("button text"); ?&gt;</pre>

                In your page. This will enable the user to interact with the prebuilt image library panel. In order to enable the panel to be displayed you need to add the following function to your controller: <br />

                <pre class="prettyprint">&lt;?php $this->image_tools->enableImageLibrary(); ?&gt;</pre>

                The other function available in the Image tools is the image collection selector. You may wish to allow users to connect a whole image collection to your module entry. To add the image collection selector simply add:

                <pre class="prettyprint">&lt;?php $this->image_tools->imageLibrarySelect(); ?&gt; // Note that the POST name is quarx_img_library</pre>

                </p>
        </div>

        <div class="raw100" id="admin-tests">
            <h1>Tests</h1>
                <p>Tests are the primary portion of what is known as Test Driven Development (TDD). Quarx provides you with a simple tool to do some simple Testing as well as some more powerful testing.
                <br /><br />
                Please review the library/Unit.php to see some details as well the controller/tests/test_login.php to see examples in action.
                <br /><br />
                You can manually turn on benchmarking in the config of the application, even though it automatically turns on when you're in development mode.
                <br /><br />
                You should write all tests as separate classes and therefore they will run as separate instances. To see the result of your tests go to the command line and run the following line:
                </p>

                <pre class="prettyprint">php index.php admin tests</pre>

                <p>Running tests, requires use of the CLI, attempting to access via the URL results in the error page.</p>
        </div>
        <?php } ?>

        <?php

            if($displayAdminManual)
            {
                echo '<div class="raw100" id="admin-cloudCatcher">';
                echo '<h1>CloudCatcher: Your Website/Application Backup Tool</h1>';
                echo '<p>CloudCatcher, gives you the power to run full backups of your website/application. Not only does CloudCatcher zip all your files into a neat and tidy download, it also grabs your entire database and conviniently places it inside the zipped backup of your Quarx system. </p>';
                echo '<br />';
                echo '<p>Please be aware in order to utilize the power of CloudCatcher you need to have at least twice the hard drive space available as your website takes. Ex. If your website is 20mb in size, you need at least 40mb of server space to perform the backup opperation. Add to the total size your estimated database size. Ex. If your database is 10mb, you then need at least 50mb of hard drive space to perform the backup.</p>';
                echo '</div>';
            }

            $this->module_tools->get_module_manual();

        ?>

    </div>
</div>

<script src="https://google-code-prettify.googlecode.com/svn/loader/run_prettify.js?autoload=true&skin=sunburst&lang=css" defer="defer"></script>

<?php $this->carabiner->display("quarx-manual-js"); ?>

<script type="text/javascript">

    $(function(){

        setMenu();

        $(window).resize(function(){
            setMenu();
        });

    });
</script>

<?php /* End of File */ ?>