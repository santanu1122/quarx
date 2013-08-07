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

    <div id="quarx-modal"></div>

	</div>

    <?php if($this->config->item('footer_visible')): ?>
    <div id="quarx-footer" data-role="footer" data-position="fixed" data-theme="a" class="quarx-align-center">
        <p>&copy; 2013 <?php echo $this->quarxsetup->quarx_details('authors') ?></p>
    </div>
    <?php endif; ?>

    <?php if($this->config->item('benchmarking')): ?>
        <div class="raw100 raw-left quarx-align-center">
            <p>Elapsed Time: <?php echo $this->benchmark->elapsed_time(); ?> seconds</p>
            <p>Memory Usage: <?php echo $this->benchmark->memory_usage(); ?></p>
        </div>
    <?php endif; ?>

</div><!-- end of all body contents -->

<script type="text/javascript" src="<?php echo $root; ?>js/jquery.gwtt.js"></script>
<script type="text/javascript">
    
    $(document).ready(function(){
        $('#quarx-image-library-box').height($(document).height()-10);
        $('#quarx-full-screen-image-library').height($(document).height()-10);
        $('#quarx-main-menu').height($(window).height()-10);
        
        $(window).scroll(function(){
            $('.quarx-success-box, .quarx-error-box').css({
                top: $(window).scrollTop()
            });    
        });
    });

</script>
    
</body>
</html>

<?php /* End of File */ ?>