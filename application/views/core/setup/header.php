<?php /*
    Filename:   header.php
    Location:   /application/views/core/setup/
*/ ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
<meta name="description" content="" />
<meta name="keywords" content="" />

<title>Quarx | <?php echo $pagetitle; ?></title>

<link type="text/css" href="<?php echo $root; ?>css/jquery-ui.css" lang="EN" dir="ltr" rel="stylesheet" />
<link type="text/css" href="<?php echo $root; ?>css/style.css" lang="EN" dir="ltr" rel="stylesheet" />

<script type="text/javascript" src="<?php echo $root; ?>js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo $root; ?>js/jquery-ui.min.js"></script>
<script type="text/javascript">
    
    $(document).ready(function() {
        $("input:button, input:submit, a.button, button" ).button();
    });
        
</script>

</head>

<body>

    <div id="big_box">
    
            <div id="header">
                <h2 style="padding: 10px 30px; float: left;">
                    <img src="<?php echo $root; ?>images/quarx.png" style="width: 15px;" /> Quarx Setup
                    <?php if($uname){ echo ': Welcome '.$uname; } ?>
                    <?php if($quarxInstalled == true){ ?>
                    | <a href="<?php echo site_url('setup'); ?>">Quarx Setup</a>
                    <?php } ?>
                </h2>
            </div>
            
            <div id="body">
            
<?php /* End of File */ ?>