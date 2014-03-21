<?php

    /**
     * Quarx
     *
     * A modular CMS application
     *
     * @package     Quarx
     * @author      Matt Lantz
     * @copyright   Copyright (c) 2013 Matt Lantz
     * @license     http://ottacon.co/quarx/license.html
     * @link        http://ottacon.co/quarx
     * @since       Version 1.0
     *
     */

    $js = array('views/setup/quarx.setup.js');
    $this->carabiner->group("quarx-setup-js", array('js'=>$js));

?>

<!-- main content -->

<div class="quarx-small-device quarx-tall">
    <div id="pwStrength"></div>
</div>

<div class="raw100">

    <div id="masterAccount" class="quarx-small-device">
        <h1>Admin Setup</h1>
        <p class="quarx-align-left">Stay calm we just need a little more information.</p>
        <div class="raw100">
            <h2>Master Account Information</h2>
            <form method="post" enctype="multipart/form-data" action="<?php echo site_url('setup/complete'); ?>">
                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />

                <input class="" value="User Name" type="text" name="username" onfocus="this.value=''" />
                <input id="password" value="Password" type="text" name="password" onfocus="this.value=''; this.type='password'" />
                <input id="confirm" value="Password Again" type="text" name="confirm" onfocus="this.value=''; this.type='password'" />
                <h2>Options</h2>
                <br />
                <input data-theme="a" id="accountStatus" type="checkbox" value="1" name="advancedAccounts" />
                <label for="accountStatus">Advanced Accounts</label>

                <input data-theme="a" id="masterAccess" type="checkbox" value="1" name="masterAccess" />
                <label for="masterAccess">Master Access</label>
                <br />
                <br />
                <input type="submit" value="Install Quarx" />
            </form>
        </div>
    </div>

</div>
<!-- javascript -->

<?php $this->carabiner->display("quarx-setup-js");

<?php /* End of File */ ?>