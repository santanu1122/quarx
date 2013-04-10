<?php /*
    Filename:   update.php
    Location:   /application/views/core/setup
*/ ?>

<style type="text/css">
a.green:hover, a.red:hover{
    color: #fff;
}
</style>

<div class="wide_box">

    <div class="wide300 centered" style="width: 310px;"> 

        <h1>Update Setup</h1>
        <br />
        <p class="align-left">Please confirm if you would like to update Quarx.</p>
        <br />
        <a class="button big green" href="<?php echo site_url('setup/update_quarx'); ?>">Confirm Update</a>
        <br />
        <a class="button big red" href="<?php echo site_url('setup'); ?>">No Thank You.</a>
    </div>

</div>
    
<?php /* End of File */ ?>