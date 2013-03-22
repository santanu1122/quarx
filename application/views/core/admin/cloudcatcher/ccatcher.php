<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>CloudCatcher</title>

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

    <?php

    if(isset($_GET['download'])){ 
        $date = date('m-d-y');   
                
        echo'<button style="magrin-left: 30px;" onclick="window.location=\''.site_url().'backup/'.$date.'.zip\'" style="padding: 10px;">Download</button>';
        echo'<button style="magrin-left: 30px;" onclick="window.location=\''.site_url().'admin/cloudcatcher/deletebackup?date='.$date.'\'" style="padding: 10px;">Delete Server Copy</button>';
            
    }else{
            
        echo'
        <div id="form" style="width: 100%; height: 80px; overflow: hidden; text-align: center;">
            <form method="post" action="'.site_url("admin/cloudcatcher/backup").'">
                <input type="hidden" name="backup" />
                <input type="submit" value="Backup" style="padding: 10px; margin-top: 20px;"/> 
            </form>
        </div>';    
        
    }
    
    ?>

</body>
</html>