<?php

/**
 * Quarx
 *
 * A modular application framework built on CodeIgniter
 *
 * @package     Quarx
 * @author      Matt Lantz
 * @copyright   Copyright (c) 2013 Matt Lantz
 * @license     http://ottacon.co/quarx/license.html
 * @link        http://ottacon.co/quarx
 * @since       Version 1.0
 * 
 */

?>

<div class="raw100"><!-- content -->

    <div class="quarx-device">

        <h1 style="margin: 20px;">Email Tool</h1>

        <div class="raw33">
                
            <?php $allaccounts = ''; ?>
            <?php foreach($account as $user): ?>
                <?php $allaccounts .= $user->user_email.', '; ?>
            <?php endforeach; ?>

                <div class="textBox quarx-pointer"><p onclick="dropIt('<?php echo $allaccounts; ?>')"><b>All Accounts</b></p></div>
            <?php foreach($account as $user): ?>
                <div class="textBox quarx-pointer"><p onclick="dropIt('<?php echo $user->user_email; ?>')"><?php echo $user->user_name; ?> | <?php echo $user->user_email; ?></p></div>
            <?php endforeach; ?>

        </div>

        <div class="raw66">
            <form method="post" action="<?php echo site_url('admin/cloudmail/email'); ?>">
                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                <input name="to" id="toBox" value="To:" />
                <input name="subject" id="subjectBox" value="Subject:" />
                <textarea class="rtf" onfocus="this.value=''" name="message" style="min-height: 300px;"></textarea>
                <br />
                <button class="button" data-theme="c">Send</button>
            </form>
        </div>
        
    </div>

</div><!--/content -->

<script type="text/javascript">

    function dropIt(text){
        if($('#toBox').val() === 'To:'){
            $('#toBox').val('');
        }
        $('#toBox').val($('#toBox').val()+text+', ');
    }
        
    $(document).ready(function(e) {
        $('.button').button();

        $("#toBox").one("click", function() {
            if($(this).val() === 'To:'){
                $(this).val('');
            }
        });

        $("#subjectBox").one("click", function() {
            $(this).val('');
        });
    });

</script>

<?php /* End of File */ ?>