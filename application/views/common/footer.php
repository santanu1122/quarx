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

    <div id="quarx-modal">
        <div id="fountainG">
            <div id="fountainG_1" class="fountainG"></div>
            <div id="fountainG_2" class="fountainG"></div>
            <div id="fountainG_3" class="fountainG"></div>
            <div id="fountainG_4" class="fountainG"></div>
            <div id="fountainG_5" class="fountainG"></div>
            <div id="fountainG_6" class="fountainG"></div>
            <div id="fountainG_7" class="fountainG"></div>
            <div id="fountainG_8" class="fountainG"></div>
        </div>
    </div>

<?php

    if ($this->config->item('benchmarking'))
    {
        echo '<div id="quarx-benchmarking" class="raw100 raw-left quarx-align-center raw-margin-top-48 raw-margin-bottom-48">';
        echo '<p>Elapsed Time: '.$this->benchmark->elapsed_time().' seconds</p>';
        echo '<p>Memory Usage: '.$this->benchmark->memory_usage().'</p>';
        echo '</div>';
    }

?>

	</div><!-- end of content -->

<?php

        echo '<div id="quarx-footer" data-role="footer" data-theme="a" class="quarx-align-center">';
        if ($this->config->item('footer_visible')) echo '<p>&copy;'.date('Y').' '.$this->quarx->quarx_details('authors').'</p>';
        echo '</div>';

?>

</div><!-- end of all contents -->

<script type="text/javascript">
<?php

    if ($this->session->flashdata('message') && $this->user_tools->getUserNotificationSettings())
    {
        $flashdata = $this->session->flashdata('message');

        $title = ucfirst($flashdata[0]);
        $message = $flashdata[1];

        echo 'quarxNotify("'.$title.'", "'.$message.'")';
    }

?>
</script>

<?php

    $footer_js_array = array(
        array("jquery.gwtt.js"),
        array("quarx-footer.js")
    );

    $this->carabiner->group('quarx-footer', array('js' => $footer_js_array));
    $this->carabiner->display('quarx-footer');

?>

</body>
</html>

<?php /* End of File */ ?>