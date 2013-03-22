<?php /*
	Filename: 	logout.php
	Location: 	/application/views/core
	Author: 	Matt Lantz
*/ ?>

<div class="wide_box">   
	
		<div class="wide_box" style="text-align: center; margin: 100px 0;">
			<h2>Logged Out</h2>
			<br />
			<br />
			<br />
			<p>You are not logged in.</p>
			<br />
			<br />
			<br />
			<button style="width: 160px;" onclick="document.location='<?php echo site_url('login'); ?>'">Sign In</button>
			<br />
			<br />
		</div>
	
<?php //End of File ?>