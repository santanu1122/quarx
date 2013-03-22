<?php /*
    Filename:   header.php
    Location:   /application/views/common/
*/ ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<!-- manifest="<?php echo site_url(); ?>/manifest/cache-manifest.appcache" -->

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes"> -->
    <meta name="description" content="" />
    <meta name="keywords" content="" />

    <title>Quarx | <?php echo $pagetitle; ?></title>

    <link type="text/css" href="<?php echo $root; ?>css/jquery-ui.css" lang="EN" dir="ltr" rel="stylesheet" />
    <link type="text/css" href="<?php echo $root; ?>css/style.css" lang="EN" dir="ltr" rel="stylesheet" />
    <link rel="shortcut icon" type="image" href="<?php echo $root; ?>images/favicon.ico" />

    <script type="text/javascript" src="<?php echo $root; ?>js/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo $root; ?>js/jquery.toolbox.js"></script>
    <script type="text/javascript" src="<?php echo $root; ?>js/jquery-ui.min.js"></script>
    <script type="text/javascript" src="<?php echo $root; ?>js/quarxfunc.js"></script>
    <script type="text/javascript">
        
        $(document).ready(function() {
            $('.datepicker').datepicker({ dateFormat: "yy-mm-dd" });
            $("input:button, input:submit, a.button, button" ).button();
            $('.tinymce').css('width', '100%');
        });
            
    </script>
    <!-- Load TinyMCE build -->
    <script type="text/javascript" src="<?php echo $root; ?>js/tinymce/jscripts/tiny_mce/jquery.tinymce.js"></script>
    <script type="text/javascript">
        $(function() {
            $('textarea.tinymce').tinymce({
                // Location of TinyMCE script
                script_url : '<?php echo $root; ?>js/tinymce/jscripts/tiny_mce/tiny_mce.js',
                theme_advanced_font_sizes: "14px,15px,16px,17px,18px,19px,22px",
                font_size_style_values : "12px,13px,14px,15px,16px,18px,20px",
                relative_urls : false,
                remove_script_host : false,

                // General options
                theme : "advanced",
                skin : "default",
                
                plugins : "pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,spellchecker",
                
                // Theme options
                theme_advanced_buttons1 : ",bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,|,bullist,numlist,|,undo,redo,|,link,unlink,code,|,image",
                theme_advanced_buttons2 : "removeformat,|,tablecontrols,|,spellchecker,|,formatselect",
                theme_advanced_buttons3 : "",
                theme_advanced_toolbar_location : "top",
                theme_advanced_toolbar_align : "left",

                content_css : "<?php echo $root; ?>css/tinyMCEstyle.css",

                // Replace values for the template plugin
                template_replace_values : {
                        username : "Some User",
                        staffid : "991234"
                }
            });
        });
            
        //we run this in case we want to use the simple version of tinymce with less options
        $(function() {
            $('textarea.tinymce_s').tinymce({
                // Location of TinyMCE script
                script_url : '<?php echo $root; ?>js/tinymce/jscripts/tiny_mce/tiny_mce.js',
                content_css : "<?php echo $root; ?>css/tinymce_style.css",
                theme_advanced_font_sizes: "14px,15px,16px,17px,18px,19px,22px",
                font_size_style_values : "12px,13px,14px,15px,16px,18px,20px",
                
                // General options
                theme : "simple",
                skin : "default",
                
                // Drop lists for link/image/media/template dialogs
                template_external_list_url : "lists/template_list.js",
                external_link_list_url : "lists/link_list.js",
                external_image_list_url : "lists/image_list.js",
                media_external_list_url : "lists/media_list.js"
            });
        });
            
    </script>
</head>

<body>
    <div id="big_box">
        <div id="header">
            <h2 style="padding: 10px float: left; width: 380px; height: 35px; line-height: 35px;">
                <img src="<?php echo $root; ?>images/quarx.png" style="width: 15px; margin-left: 20px;" /> Quarx <?php if($this->session->userdata('logged_in')){ echo ' | Hello '.$this->session->userdata('username'); } ?>
            </h2>
        </div>
            
<?php /* End of File */ ?>