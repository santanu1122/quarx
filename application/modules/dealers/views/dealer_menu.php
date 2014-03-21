<?php /*
    Filename:   dealer_menu.php
    Location:   /application/modules/blog/views/
*/ ?>

<div id="dealer_menu" class="dialogBox" title="Dealer Manager Menu">
    <a href="<?php echo site_url('dealers/add') ?>" data-role="button" data-corners="false">Add Account</a>
    <a href="<?php echo site_url('dealers/view/all') ?>" data-role="button" data-corners="false">View Accounts</a>
    <?php if(!isMobile()){ ?>
    <?php if($this->session->userdata('permission') == 1){ ?>
    <a href="<?php echo site_url('dealers/relations') ?>" data-role="button" data-corners="false">Account Relations</a>
    <?php } ?>
    <?php } ?>
</div>

<script type="text/javascript">
    function showMenu(){
        $('#dealer_menu').dialogbox({
            modal: true
        });
    }
</script>

<?php //End of file ?>