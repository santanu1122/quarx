<?php /*
    Filename:   email_tool.php
    Location:   /application/views/core/
    Author:     Matt Lantz
*/ ?>

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

<div class="wide_box" style="text-align: left; min-height: 500px;"><!-- content -->

    <h1 style="margin: 20px;">Email Tool</h1>

    <div style="width: 100%; margin: 0 auto;">
        <div class="third_box">
                
            <?php $allaccounts = ''; ?>
            <?php foreach($account as $user): ?>
                <?php $allaccounts .= $user->user_email.', '; ?>
            <?php endforeach; ?>

                <div class="textBox"><p onclick="dropIt('<?php echo $allaccounts; ?>')"><b>All Accounts</b></p></div>
            <?php foreach($account as $user): ?>
                <div class="textBox"><p onclick="dropIt('<?php echo $user->user_email; ?>')"><?php echo $user->user_name; ?> | <?php echo $user->user_email; ?></p></div>
            <?php endforeach; ?>

        </div>

        <div class="two_third_box">
            <form method="post" action="<?php echo site_url('admin/email'); ?>">
                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                <input name="to" id="toBox" style="width: 97%; padding: 5px; margin: 2px 0; border: 1px solid #ddd;" value="To:" />
                <input name="subject" id="subjectBox" style="width: 97%; padding: 5px; margin: 2px 0; border: 1px solid #ddd;" value="Subject:" />
                <textarea class="tinymce" onfocus="this.value=''" name="message" style="min-height: 300px;"></textarea>
                <br />
                <button class="button green">Send</button>
            </form>
        </div>
        
    </div>

</div><!--/content -->

<?php /* End of File */ ?>