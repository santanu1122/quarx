<?php /*
	Filename: 	login_error.php
	Location: 	/application/views/core/
	Author: 	Matt Lantz
*/ ?>

<div class="wide_box">
		
<div class="wide_box" style="margin: 80px auto;">

	<p>We regret to inform you but your not actually logged in....</p>
	<br />
	<br />
	<br />
	<button class="supaFatButton" onclick="document.location='<?php echo site_url('login'); ?>'">Login</button>
</div>
	
<?php /* End of File */ ?>