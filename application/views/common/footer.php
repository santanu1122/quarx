<?php /* 
	Filename: 	footer.php
	Location: 	/application/views/common/
*/ ?>

    <div id="quarx-modal"></div>

	</div>

<!--     <div id="footer" data-role="footer" data-position="fixed" data-theme="a" class="align-center">
        <p>&copy; 2013 Matt Lantz</p>
    </div> -->

</div>

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