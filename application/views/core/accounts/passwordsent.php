<?php /* 
	Filename: 	passwordsent.php
	Location: 	/application/views/core
	Author: 	Matt Lantz
*/ ?>

<div class="wide_box"><!-- content -->
    <div style="width: 960px; margin: 50px auto; height: 400px;">

    	<div style="width: 960px; height: 50px; float: left;">
        	<h1 style="margin-top: 10px;">Check your Inbox</h1>
        </div>
        
        <div style="width: 960px; float: left;">
        	<div style="width: 60%; margin: 0 auto;">
        		<h2 style="padding: 30px; text-align: left;">Your new password should be somewhere in your inbox. It shouldn't be too hard to find, we know you're dying to come back.</h2>
            	<button style="margin: 20px auto;" onclick="window.location='<?php echo site_url('login'); ?>'">Log In</button>
        	</div>
        </div>
        
    </div>
</div><!--/content -->

<?php //End of File ?>