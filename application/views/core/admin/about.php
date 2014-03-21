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

<div class="raw100"><!-- content -->

    <div class="quarx-small-device">

        <div class="raw100">
            <div style="raw100">
                <img src="<?= $root; ?>img/quarx.png" class="quarx-about-icon" />
            </div>
            <p>Quarx is a powerful platform/framework built to power both web sites, apps, mobile apps and even run as an app itself. It's overall construct is designed to be adaptive and responsive, both programmatically and visually.</p>
            <br />
            <div class="raw100 raw-left">
                <div class="raw50 raw-left">
                    <p>Author</p>
                </div>
                <div class="raw50 raw-left">
                    <p><?= $authors; ?></p>
                </div>
            </div>
            <div class="raw100 raw-left">
                <div class="raw50 raw-left">
                    <p>Verison</p>
                </div>
                <div class="raw50 raw-left">
                    <p><?= $version; ?></p>
                </div>
            </div>
            <div class="raw100 raw-left">
                <div class="raw50 raw-left">
                    <p>More Information</p>
                </div>
                <div class="raw50 raw-left">
                    <p><a target="_blank" href="<?= $info; ?>"><?= $info; ?></a></p>
                </div>
            </div>
            <div class="raw100 raw-left">
                <h2>Built With:</h2>
            </div>
            <div class="raw100 raw-left">

                <?php

                    foreach ($this->quarx->quarx_details('components') as $c)
                    {
                        echo '<div class="raw50 raw-left">';
                        echo '<a href="'.$c->link.'" target="_blank">'.$c->title.'</a>';
                        echo '</div>';
                    }

                ?>

            </div>
            <div class="raw100 raw-left">
                <h2>Requires:</h2>
            </div>
            <div class="raw100 raw-left">
                <div class="raw70 raw-left">
                    <p>PHP Version</p>
                </div>
                <div class="raw30 raw-left">
                    <p>5.3+</p>
                </div>
            </div>
            <div class="raw100 raw-left">
                <div class="raw70 raw-left">
                    <p>MySQL (Optional) Version</p>
                </div>
                <div class="raw30 raw-left">
                    <p>5.3+</p>
                </div>
            </div>
        </div>

    </div>
</div><!--/content -->

<?php $this->carabiner->display("quarx-admin-js"); ?>

<?php /* End of File */ ?>