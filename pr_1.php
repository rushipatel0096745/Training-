<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form method="post" action="<?php echo $_SERVER["PHP_SELF"];?>">
        <input type="number" name="num">
        <input type="submit" value="submit">
    </form>
    <?php 
    $num = $_REQUEST["num"];
    for ($i=1; $i <= $num ; $i++) { 
        echo "$i". " ";
    }
    ?> 
</body>
</html>