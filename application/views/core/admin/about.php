<?php

/**
 * Quarx
 *
 * A modular application framework built on CodeIgniter
 *
 * @package     Quarx
 * @author      Matt Lantz
 * @copyright   Copyright (c) 2013 Matt Lantz
 * @license     http://ottacon.co/quarx/license
 * @link        http://ottacon.co/quarx
 * @since       Version 1.0
 * 
 */ 

?>

<?php

$version = $this->quarxsetup->quarx_details('version');
$buildDate = $this->quarxsetup->quarx_details('buildDate');
$authors = $this->quarxsetup->quarx_details('authors');

?>

<div class="raw100"><!-- content -->
    
    <div class="quarx-small-device">

        <div class="raw100 mobile-compatible-proportions">
            <div style="raw100">
                <img src="<?php echo $root; ?>images/quarx.png" style="width: 100px; margin-left: 100px;" />
            </div>
            <p>Quarx is a powerful platform/framework built to power both web sites, apps, mobile apps and even run as an app itself. It's overall construct is designed to be adaptive and responsive, both programmatically and visually.</p>
            <br />
            <div class="raw100">
                <div class="raw50">Author</div>
                <div class="raw50"><?php echo $authors; ?></div>
            </div>    
            <div class="raw100">
                <div class="raw50">Verison</div>
                <div class="raw50"><?php echo $version; ?></div>
            </div> 
            <div class="raw100">
                <div class="raw50">Build Date</div>
                <div class="raw50"><?php echo $buildDate; ?></div>
            </div> 
            <div class="raw100">
                <h2>Built With:</h2>
            </div> 
            <div class="raw100">
                
                <?php foreach ($this->quarxsetup->quarx_details('components') as $c) { ?>
                
                <div class="raw50"><a href="<?php echo $c->link; ?>" target="_blank"><?php echo $c->title; ?></a></div>

                <?php } ?>

            </div> 
            <div class="raw100">
                <h2>Requires:</h2>
            </div>    
            <div class="raw100">
                <div class="raw50">PHP Version</div>
                <div class="raw50">5.1.6+</div>
            </div> 
            <div class="raw100">
                <div class="raw50">MySQL Version</div>
                <div class="raw50">5+</div>
            </div> 
        </div>
        
    </div>
</div><!--/content -->

<?php /* End of File */ ?>