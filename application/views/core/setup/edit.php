<?php /*
    Filename:   edit.php
    Location:   /application/views/core/setup
    Author:     Matt Lantz
*/ ?>

<script type="text/javascript">

function infoBox(type){
    var info = '', title = '';
    if(type === 'advancedAccounts'){
        title = 'Advanced Accounts';
        info = 'Advanced accounts allows the system to manage more account information for each user including the master user. This option can be turned on an off. Though if it is turned off, be aware the exsiting accounts will not lose any of the information they may have in their accounts.';
    }

    if(type === 'masterAccess'){
        title = 'Master Access';
        info = 'Master access controls whether or not the secondary accounts have the ability to edit the content of the website. For example with master access disabled, any user can add to the blog, with it enabled only the master user can work with the blog.';
    }

    $('#dialog-infoBox').attr('title', title);
    $('#infoP').html( info );

    $( "#dialog:ui-dialog" ).dialog( "destroy" );

    $( "#dialog-infoBox" ).dialog({
        modal: true,
        buttons: {
            Ok: function() {
                $( this ).dialog( "close" );
                $( this ).dialog( "destroy" );
            }
        }
    });
}

</script>

<div id="dialog-infoBox" style="display: none;">
    <p id="infoP"></p>
</div>

<div class="wide_box">
        
        <div class="wide_box" style="text-align: center; min-height: 500px;">

            <div id="masterAccount" class="wide300 centered">
                <br />
                <h1>Admin Setup</h1>
                <br />
                <p class="align-left">Looking to make some changes?</p>
                <br />
                <form method="post" enctype="multipart/form-data" action="<?php echo site_url('setup/edit_setup'); ?>">
                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                <div class="wide300 centered padded10">
                    <div class="leftBox wide200"><p class="align-left">Advanced Accounts</p></div>
                    <div class="leftBox"><input class="leftBox" type="checkbox" <?php echo $accountStatus; ?> value="1" name="advancedAccounts" /><span onclick="infoBox('advancedAccounts')" class="pointer leftBox ui-icon ui-icon-help"></span></div>
                </div>
                <div class="wide300 centered padded10">
                    <div class="leftBox wide200"><p class="align-left">Master Access</p></div>
                    <div class="leftBox"><input class="leftBox" type="checkbox" <?php echo $masterAccess; ?> value="1" name="masterAccess" /><span onclick="infoBox('masterAccess')" class="pointer leftBox ui-icon ui-icon-help"></span></div>
                </div>

                <br />
                <br />
                <input class="wide200 padded10" type="submit" value="Update Quarx" />
            </div>
        </div>
    
<?php /* End of File */ ?>