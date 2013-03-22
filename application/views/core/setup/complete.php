<?php /*
    Filename:   complete.php
    Location:   /application/views/setup
    Author:     Matt Lantz
*/ ?>

<script type="text/javascript">
    $(function() {
        $( "#progressBar" ).progressbar({
            value: 100
        });
    });
</script>

<div class="wide_box">

    <div id="progressBar"></div>

    <div class="wide300 centered">
        <br />
        <h1>Success! Your installation is complete.</h1>
        <br />
        <p class="align-left">Congrats <?php echo $uname; ?> please feel free to login to your new system and get some serious work done.</p>
        <br />
        <a class="button reallyTall fat" href="<?php echo site_url('login'); ?>">Login</a>
        
    </div>

</div>
    
<?php /* End of File */ ?>