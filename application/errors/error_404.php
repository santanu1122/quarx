<?php /*
    Filename:   header.php
    Location:   /application/views/common/
*/ ?>

<?php $root = $_SERVER['HTTP_HOST']; $error = 'Error 404'; echo $root; ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <meta name="description" content="A simple to use, responsive design CMS system." />
    <meta name="keywords" content="CMS System, Zen, Responsive Design" />
    <meta name="viewport" content="initial-scale=1, maximum-scale=1">

    <title>Quarx | <?php echo $error; ?></title>

    <!-- Quarx Custom Styles -->
    <link rel="shortcut icon" type="image" href="<?php echo $root; ?>images/favicon.ico" />
    <link rel="stylesheet" href="<?php echo $root; ?>css/raw.min.css" />
    <link rel="stylesheet" href="<?php echo $root; ?>css/desktop-style.css" lang="EN" dir="ltr" type="text/css" />
    <link rel='stylesheet' media='screen and (min-width: 320px) and (max-width: 980px)' href='<?php echo $root; ?>css/tablet-style.css' />
    <link rel='stylesheet' media='screen and (min-width: 120px) and (max-width: 768px)' href='<?php echo $root; ?>css/mobile-styles.css' />

    <!-- jQuery -->
    <script type="text/javascript" src="<?php echo $root; ?>js/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo $root; ?>js/jquery-migrate.min.js"></script>

    <!-- jQuery Mobile Quarx Theme -->
    <link rel="stylesheet" href="<?php echo $root; ?>js/themes/quarx.css" />
    <link rel="stylesheet" href="<?php echo $root; ?>js/themes/jquery.mobile.structure.min.css" />
    <script type="text/javascript" src="<?php echo $root; ?>js/quarxfunc.js"></script>
    <script type="text/javascript" src="<?php echo $root; ?>js/jquery.mobile.min.js"></script>

    
    <!--[if gte IE 7]>
    <link rel="stylesheet" type="text/css" href="<?php echo $root; ?>css/ie.css" />
    <![endif]-->
</head>

<body>

    <div data-role="page" data-url="<?php echo $pagetitle; ?>" data-theme="a">

        <div data-role="header">
            <h1><?php echo $error; ?></h1>
        </div>

        <div id="body" data-role="content">

            <div class="smallDevice">
                <h1 class="epic">404</h1>
                <h1>Ops! You caught us offguard.</h1>
                <p>It seems that we've made a terrible error. We'll be doing our best to make sure this is fixed as soon as possible.</p>
                <button onclick="javascript:history.back()">Back</button>
            </div>
        </div>
    </div>
</body>
</html>

<?php 

    //fire an email to someone so we know what an error happened!

    $refURL = $_SERVER['REQUEST_URI'];
    $browser = $_SERVER['HTTP_USER_AGENT'];

    $to = 'mattlantz@gmail.com';
    $from = "Website Error";
    $message = "The following website: ".$root." recieved a 404 error: ".$refURL." while using the following browser: ".$browser;

    mail($to, $from, $message);

?>       
<?php /* End of File */ ?>