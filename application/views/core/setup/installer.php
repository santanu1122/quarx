<?php /*
    Filename:   installer.php
    Location:   /application/views/setup
    Author:     Matt Lantz
*/ ?>

<div class="wide_box">

    <div class="wide600 centered">

        <h1>Welcome <?php echo $uname; ?></h1>
        <br />
        <p class="align-left wide600">Are you excited to start working on your website/ application? We just need a little more information.</p>
        <br />

        <form method="post" action="<?php echo site_url('setup/complete'); ?>">
            <div class="wide300 centered padded10">
                <div class="leftBox wide200"><p>Advanced Accounts</p></div>
                <div class="leftBox"><input type="checkbox" value="1" name="advancedAccounts" /></div>
            </div>
            <br />
            <br />
            <button class="big" type="submit">Complete Installation</button>
        </form>

    </div>

</div>
    
<?php /* End of File */ ?>