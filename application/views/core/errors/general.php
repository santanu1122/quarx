<?php /* 
    Filename:   general.php
    Location:   /application/views/core/errors
*/ ?>

<!DOCTYPE html>
<html lang="en">
<head>
<title>Error</title>
<style type="text/css">

::selection{ background-color: #E13300; color: white; }
::moz-selection{ background-color: #E13300; color: white; }
::webkit-selection{ background-color: #E13300; color: white; }

body {
    background-color: #fff;
    margin: 40px;
    font: 13px/20px normal Helvetica, Arial, sans-serif;
    color: #4F5155;
    text-align: center;
}

a {
    color: #003399;
    background-color: transparent;
    font-weight: normal;
}

h1 {
    color: #444;
    background-color: transparent;
    font-size: 19px;
    font-weight: normal;
    margin: 0 0 14px 0;
    padding: 14px 15px 10px 15px;
}

code {
    font-family: Consolas, Monaco, Courier New, Courier, monospace;
    font-size: 12px;
    background-color: #f9f9f9;
    border: 1px solid #D0D0D0;
    color: #002166;
    display: block;
    margin: 14px 0 14px 0;
    padding: 12px 10px 12px 10px;
}

#container {
    width: 400px;
    min-height: 350px;
    margin: 10px auto;
    border: 1px solid #D0D0D0;
    -webkit-box-shadow: 0 0 8px #D0D0D0;
}

p {
    margin: 12px 15px 12px 15px;
}

button{
    border-radius: 4px;
    border: none;
}

</style>
</head>
<body>
    <div id="container">
        <div style="padding: 20px;">
            <h1>We've encountered an error.</h1>
            <?php echo $error; ?>
            <br />
            <br />
            <br />
            <button style="padding: 15px;" onclick="window.history.back()">Back</button>
        </div>
    </div>
</body>
</html>

<?php //End of File ?>