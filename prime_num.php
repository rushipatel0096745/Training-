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
        function isPrime($n){
            for ($i=2; $i < $n ; $i++) { 
                if($n % $i == 0){
                    return false;
                }
            }
            return true;
        }
    
        $a = isPrime($num);
        // echo "$a";
        if($a == true){
            echo "$num is a prime";
        }
        else {
            echo "$num is not a prime";
        }
    }
   
   
       
    ?> 
</body>
</html>