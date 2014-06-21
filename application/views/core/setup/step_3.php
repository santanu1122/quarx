<?php

/**
 * Quarx
 *
 * A modular CMS application
 *
 * @package     Quarx
 * @author      Matt Lantz
 * @copyright   Copyright (c) 2013 - 2014 Matt Lantz
 * @license     https://ottacon.co/docs/quarx/license.html
 * @link        https://github.com/mlantz/quarx
 * @since       Version 1.0
 *
 */

?>

<div class="raw100">

    <div class="quarx-small-device">
        <br />
        <h1>Success! Your installation is complete.</h1>
        <br />
        <p class="align-left">Congrats <?php echo $uname; ?> please feel free to login to your new system and get some serious work done. Don't forget to perform a system cleaning in the admin now that you've installed Quarx.</p>
        <br />
        <a data-role="button" href="<?php echo site_url('login'); ?>">Login</a>
    </div>

</div>

<?php /* End of File */ ?>