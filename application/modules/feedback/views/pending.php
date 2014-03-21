<?php /*
    Filename:   pending.php
    Location:   /modules/feedback/view
*/ ?>

<div class="device">

    <div class="raw100">
        <a href="#" data-role="button" onclick="showMenu()">Feedback Menu</a>
    </div>

    <div class="raw100">
        <div class="raw25"><p><b>Client Name</b></p></div>
        <div class="raw25"><p><b>Client Email</b></p></div>
        <div class="raw25"><p><b>Date Issued</b></p></div>
    </div>

    <?php foreach ($rating as $entry): ?>
        
    <div class="raw100 rowBox">
        <div class="raw25"><p><?php echo $entry->fb_client_name; ?></p></div>
        <div class="raw25"><p><?php echo $entry->fb_client_email; ?></p></div>
        <div class="raw25"><p><?php echo $entry->fb_date; ?></p></div>
    </div>

    <?php endforeach; ?>

</div>
    
<!-- End of File -->