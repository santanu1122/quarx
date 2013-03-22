<?php /*
    Filename:   about.php
    Location:   /application/views/core/
    Author:     Matt Lantz
*/ ?>

<?php

$url  = './quarx.json';
$quarx = file_get_contents($url);
$quarx = json_decode($quarx);
$version = $quarx->version;

?>

<div class="wide_box" style="text-align: left; min-height: 500px;"><!-- content -->
    
    <div style="width: 85%; margin: 30px auto;">

        <div class="half_box">
            <div class="padded">
                <div style="width: 100%; text-align: center; margin: 0 auto;">
                    <img src="<?php echo $root; ?>images/quarx.png" style="width: 100px;" />
                </div>
                <br />
                <br />
                <p><?php echo t('about title'); ?></p>
                <p>Quarx is a CMS built on the foundation of <b><a href="http://codeigniter.com" target="_blank">CodeIgniter</a></b> an <b><a href="http://ellislab.com" target="_blank">EllisLabs</a></b> project.</p>
                <br />
                <div class="gridrow">
                    <div class="grid50">Author</div>
                    <div class="grid50">Matt Lantz</div>
                </div>    
                <div class="gridrow">
                    <div class="grid50">Verison</div>
                    <div class="grid50"><?php echo $version ?></div>
                </div> 
                <div class="gridrow">
                    <br />
                    <h2>Built With:</h2>
                    <br />
                </div> 
                <div class="gridrow">
                    <div class="grid50"><a href="http://codeigniter.com" target="_blank">CodeIgniter</a></div>
                    <div class="grid50"><a href="http://jquery.com" target="_blank">jQuery</a></div>
                    <div class="grid50"><a href="http://jqueryui.com" target="_blank">jQueryUI</a></div>
                    <div class="grid50"><a href="http://github.com/mlantz/toolbox" target="_blank">Toolbox</a></div>
                </div> 
                <div class="gridrow">
                    <br />
                    <h2>Requires:</h2>
                    <br />
                </div>    
                <div class="gridrow">
                    <div class="grid50">PHP Version</div>
                    <div class="grid50">5.3+</div>
                </div> 
                <div class="gridrow">
                    <div class="grid50">MySQL Version</div>
                    <div class="grid50">5+</div>
                </div> 
                <div class="gridrow">
                    <div class="grid50">cURL ( for plugins )</div>
                    <div class="grid50">7+</div>
                </div> 
            </div>
        </div>
        
        <?php if($this->session->userdata('permission') == 1){ ?>
        <div class="half_box">
            <div class="padded">
                <p>Quarx is a CMS created primarily for developers. Unlike different CMS software like Wordpress and Drupal etc, the focus in not on the designer. So rather than develop convoluted systems that rely on some etherial loop, the fundamental build of Quarx is a modular system with a core setup that managers user accounts. It allows for a two-teir account system out-of-the-box, but with the use of different plugins you can enhance quarx to manage products, blogs, galleries, organizations and more. The core database of Quarx is meant to be simple and allow for easy expansion.</p>
                <br />
                <p>Plugins themselves are built with a controller, model, and a folder of views. This structure allows for maximum growth of the system. Install and explore a plugin like the blog to understand the basic structure, or download the plugin template to make your own plugins.</p>
                <br />
                <p>Quarx by default has no front-end. It allows the developer to make full use of its system and develop a custom front-end with the full back-end management already completed. However, there is also a prebuilt front-end skeleton framework (Atomic) that can be easily customized into a dynamic front-end. To add it to an Quarx installation simply go to Quarx/setup and install Atomic. Atomic will adapt and display the plugins that you have setup in Quarx. If you custom write your own plugins you will need to add them to the Atomic front end, and please consult the manual on how to do so.</p>
            </div>
        </div>
        <?php } ?>
        
    </div>
</div><!--/content -->

<?php /* End of File */ ?>