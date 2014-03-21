<?php /*
    Filename:   view.php
    Location:   /application/views/core
*/ ?>

    <?php foreach($tm as $accounts): ?>

    <option value="<?php echo $accounts->user_id; ?>"><?php echo $accounts->company; ?></option>
    
    <?php endforeach; ?>
                
<?php //End of file ?>