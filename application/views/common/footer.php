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
    <div id="footer" data-role="footer" data-position="fixed" data-theme="a" class="align-center">
        <p>&copy; 2013 <?php echo $this->quarxsetup->quarx_details('authors') ?></p>
    </div>
    <?php endif; ?>

    <?php if($this->config->item('benchmarking')): ?>
        <div class="raw100 raw-left align-center">
            <p>Elapsed Time: <?php echo $this->benchmark->elapsed_time(); ?> seconds</p>
            <p>Memory Usage: <?php echo $this->benchmark->memory_usage(); ?></p>
        </div>
    <?php endif; ?>

</div><!-- end of all body contents -->

<script type="text/javascript" src="<?php echo $root; ?>js/jquery.gwtt.js"></script>
<script type="text/javascript">
    
    $(document).ready(function(){
        $('#imageLibraryBox').height($(document).height()-10);
        $('#fullScreenImageLibrary').height($(document).height()-10);
        $('#Menu').height($(window).height()-10);
        
        $(window).scroll(function(){
            $('.updateBox, .errorBox').css({
                top: $(window).scrollTop()
            });    
        });
    });

</script>
    
</body>
</html>

<?php /* End of File */ ?>