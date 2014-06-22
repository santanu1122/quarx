<?php

/**
 * Quarx
 *
 * A modular application structure built on CodeIgniter
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

<div data-role="panel" data-display="overlay" id="quarx-main-menu" class="quarx-menu-panel quarx-panel-box">

    <h2 class="quarx-menu-title"><img src="<?php echo $root; ?>img/quarx.png" width="15px" /> Quarx </h2>

    <ul id="quarx-menu" data-role="listview">

        <?php

            if ($this->session->userdata('logged_in'))
            {
                $this->module_tools->get_module_menus();
                $this->module_tools->get_special_module_menus();

                echo '<li><a href="'.site_url('images/library'),'">Image Library</a></li>';

                if ($this->session->userdata('user_id') == 1)
                {
                    echo '<li><a href="'.site_url('admin').'">Admin Settings</a></li>';

                    if ($this->config->item("quarx-mode") != "application")
                    {
                        if ( ! $this->agent->mobile()) echo '<li><a href="'.site_url('admin/cloudcatcher').'">CloudCatcher</a></li>';
                        echo '<li><a href="'.site_url('admin/about').'">About</a></li>';
                    }
                }

                if ($this->config->item("quarx-mode") != "application")
                {
                    echo '<li><a href="'.site_url('manual').'">Manual</a></li>';
                }

            }

        ?>

    </ul>

</div>

<?php /* End of File */ ?>