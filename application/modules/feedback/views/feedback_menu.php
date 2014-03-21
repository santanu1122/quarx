<?php /*
    Filename:   feedback_menu.php
    Location:   /views/
*/ ?>

<div id="feedback_menu" class="dialogBox" title="Feedback Menu">
    <a href="<?php echo site_url('feedback') ?>" data-role="button" data-corners="false">Generate Feedback</a>
    <a href="<?php echo site_url('feedback/view') ?>" data-role="button" data-corners="false">Review Feedback</a>
    <a href="<?php echo site_url('feedback/pending') ?>" data-role="button" data-corners="false">Pending Feedback</a>
</div>

<script type="text/javascript">

    function showMenu(){
        $('#feedback_menu').dialogbox({
            modal: true
        });
    }

</script>

<?php //End of file ?>