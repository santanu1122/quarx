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

<style type="text/css">
    #phpinfo table{ width: 100%; }
    #phpinfo td, th, h1, h2 {font-family: sans-serif; padding: 5px;}
    #phpinfo pre {margin: 0px; font-family: monospace;}
    #phpinfo a:link {color: #000099; text-decoration: none; background-color: #ffffff;}
    #phpinfo a:hover {text-decoration: underline;}
    #phpinfo table {border-collapse: collapse; width:100%}
    #phpinfo .center {text-align: center;}
    #phpinfo .center table { margin-left: auto; margin-right: auto; text-align: left;}
    #phpinfo .center th { text-align: center !important; }
    #phpinfo td, th { border: 1px solid #000000; font-size: 100%; vertical-align: baseline;}
    #phpinfo h1 {font-size: 150%;}
    #phpinfo h2 {font-size: 125%;}
    #phpinfo .p {text-align: left;}
    #phpinfo .e {background-color: #CCC; font-weight: bold; color: #111; font-size: 12px;}
    #phpinfo .h {background-color: #9999cc; font-weight: bold; color: #000000; display: none;}
    #phpinfo .v {background-color: #eee; color: #000000; font-size: 12px; max-width: 500px; font-size: 0.8em; overflow: hidden;}
    #phpinfo .vr {background-color: #cccccc; text-align: right; color: #000000;}
    #phpinfo img {float: right; border: 0px;}
    #phpinfo hr {width: 100%; background-color: #cccccc; border: 0px; height: 1px; color: #000000;}
</style>

<div class="raw100" style="text-align: left;"><!-- content -->
    <h1 style="margin: 20px 20px 20px 0px;">CloudInfo: Your Server Information</h1>
    <div class="device form">
        
        <div class="raw100">
            <div class="raw50"><p>Currently Hosted On:</p></div>
            <div class="raw50"><p><?php echo $_SERVER['HTTP_HOST']; ?></p></div>
        </div>
        <div class="raw100">
            <div class="raw50"><p>Current IP Address:</p></div>
            <div class="raw50"><p><?php echo $_SERVER['SERVER_ADDR']; ?></p></div>
        </div>
        <div class="raw100">
            <div class="raw50"><p>Current Server Protocol:</p></div>
            <div class="raw50"><p><?php echo $_SERVER['SERVER_PROTOCOL']; ?></p></div>
        </div>
        <div class="raw100">
            <div class="raw50"><p>Total Space Used:</p></div>
            <div class="raw50"><p><?php echo format_size(foldersize('./')); ?></p></div>
        </div>
    
        <div id="phpinfo" class="mHide">
        <?php
            ob_start();
            phpinfo();
            $pinfo = ob_get_contents();
            ob_end_clean();
            // the name attribute "module_Zend Optimizer" of an anker-tag is not xhtml valide, so replace it with "module_Zend_Optimizer"
            echo ( str_replace ( "module_Zend Optimizer", "module_Zend_Optimizer", preg_replace ( '%^.*<body>(.*)</body>.*$%ms', '$1', $pinfo ) ) ) ;
        ?>
        </div>
    </div>
        
</div>
<?php /* End of File */ ?>