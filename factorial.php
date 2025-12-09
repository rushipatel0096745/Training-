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
    if($num){
       function fact($n){
            if($n == 0 or $n == 1){
                return 1;
            }
            $res =  $n * fact($n-1);
            return $res;
       }

       $a = fact($num);
       echo "$a";
    }
    

    ?> 
</body>
</html>