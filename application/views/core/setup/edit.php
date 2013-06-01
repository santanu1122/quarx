<?php

/**
 * Quarx
 *
 * A modular CMS built on CodeIgniter
 *
 * @package     Quarx
 * @author      Matt Lantz
 * @copyright   Copyright (c) 2013 Matt Lantz
 * @license     http://ottacon.co/quarx/license
 * @link        http://quarx.ottacon.co
 * @since       Version 1.0
 * 
 */

?>

<div class="raw100">
    <div class="smallDevice">

        <div id="masterAccount">
            <p class="align-left">There are a variety of options in your current Quarx version.</p>
            <br />
            <form method="post" enctype="multipart/form-data" action="<?php echo site_url('setup/edit/edit_setup'); ?>">
            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />

            <input data-theme="a" id="accountStatus" type="checkbox" <?php echo $accountStatus; ?> value="1" name="advancedAccounts" />
            <label for="accountStatus">Advanced Accounts</label>

            <input data-theme="a" id="masterAccess" type="checkbox" <?php echo $masterAccess; ?> value="1" name="masterAccess" />
            <label for="masterAccess">Master Access</label>

            <input data-role="button" data-theme="a" type="submit" value="Save Quarx Setup" />
        </div>
    
    </div>
</div>
    
<?php /* End of File */ ?>