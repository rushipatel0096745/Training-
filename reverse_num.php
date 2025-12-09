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
    echo "number $num" . "<br>";
    function rev_num($n){
        $rev = 0;
        while ($n !== 0) {
            $rem = $n  % 10;
            $rev = $rev*10 + $rem;
            $n = (int) $n / 10;
        }
        return $rev/10;
    }

    $res = rev_num($num);
    if($res){
        echo "$res";
    }





    ?> 
</body>
</html>