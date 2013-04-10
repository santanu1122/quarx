<?php /* 
    Filename:   general.php
    Location:   /application/views/core/errors
*/ ?>

<div id="container">
    <div style="padding: 20px;">
        <h1>We've encountered an error.</h1>
        <?php echo $error; ?>
        <br />
        <br />
        <br />
        <button style="padding: 15px;" onclick="window.history.back()">Back</button>
    </div>
</div>

<?php //End of File ?>