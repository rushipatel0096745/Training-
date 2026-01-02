<?php
    ini_set("display_errors", "On");
    error_reporting(E_ALL);
    session_start();

    require_once __DIR__ . "../../../constants.php";
    require __DIR__ . '../../../database/db_connect.php';

    $user_id = $_SESSION["login_user_id"] ?? 0;

    $payu_url = "https://test.payu.in/_payment";
    $key = "gMBh5o";
    $salt = "dBUXALRJ0BEhgQM1xIYEwcqVzgrwBbnv"; 

    $firstname = $_POST["firstname"];
    $lastname = $_POST["lastname"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $address1 = $_POST["address1"];
    $country = $_POST["country"];
    $state = $_POST["state"];
    $city = $_POST["city"];
    $zipcode = $_POST["zipcode"]; 
    $amount = $_POST["amount"]; 
    $productinfo = $_POST["productinfo"];
    $paymentMethod = $_POST["paymentMethod"];
    // echo $productinfo . " " . $amount;


    $txnid = 'txn_' . uniqid();

    $surl = 'http://localhost/rushikesh/php_ecomm/user/checkout/payment_success.php';
    $furl = 'http://localhost/rushikesh/php_ecomm/user/checkout/payment_failure.php';

    // create order 
    $order_sql = "INSERT INTO orders (user_id, order_total, payment_mode, payment_txn_id, payment_status) VALUES (?,?,?,?,?)";
    $order_stmt = $conn->prepare($order_sql);
    $order_stmt->execute([$user_id, floatval($amount), $paymentMethod, $txnid, "PENDING"]);
    $order_id = $conn->lastInsertId();
    $_SESSION["current_order_id"] = $order_id;

    // insert into the order items
    foreach($_SESSION["cart"] as $product_id => $quantity){
        // fetch price of product with product id
        $price_sql = "SELECT price from product WHERE p_id = $product_id";
        $price_stmt = $conn->prepare($price_sql);
        $price_stmt->execute();
        $price = $price_stmt->fetchColumn();

        $insert_order_item_sql = "INSERT INTO order_items (order_id, p_id, quantity, unit_price) VALUES (?,?,?,?)";
        $insert_order_item_stmt = $conn->prepare($insert_order_item_sql);
        $insert_order_item_stmt->execute([$order_id, $product_id, $quantity, $price]);
            
    }


    if($paymentMethod == "cod") {
        $update_sql = 'UPDATE orders SET payment_status = "SUCCESS" WHERE order_id = $order_id';
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->execute();
    } elseif ($paymentMethod == "online"){
        // echo $paymentMethod;
        $payu_params = array(
            'key' =>  $key,
            'txnid' =>  $txnid,
            'amount'  =>  $amount,
            'firstname' =>  $firstname,
            'lastname' => $lastname,
            'email' =>  $email,
            'phone' =>  $phone,
            'productinfo' =>  $productinfo,
            'address1' => $address1,
            'country' => $country,
            'state' => $state,
            'city' => $city,
            'zipcode' => $zipcode,
            'surl'  =>  $surl,
            'furl'  =>  $furl,
            'service_provider' => 'payu_paisa'
        );


        $hash = '';
        // Hash Sequence
        $hashSequence = "key|txnid|amount|productinfo|firstname|email|udf1|udf2|udf3|udf4|udf5|udf6|udf7|udf8|udf9|udf10";
        $hashVarsSeq = explode('|', $hashSequence);
        $hash_string = '';	
        foreach($hashVarsSeq as $hash_var) {
        $hash_string .= isset($payu_params[$hash_var]) ? $payu_params[$hash_var] : '';
        $hash_string .= '|';
        }
        $hash_string .= $salt;
        $hash = strtolower(hash('sha512', $hash_string));
        $payu_params['hash'] = $hash;

    }

?>


<html>
    <body>  
        <form action="<?php echo $payu_url ?>" id="payuForm" method="post">
            <?php foreach($payu_params as $k => $v){?>
                <input type="hidden" name="<?php echo $k ?>" value="<?php echo $v ?>">
            <?php } ?>    
        </form>
        <script>
            document.getElementById("payuForm").submit();
        </script>
    </body>
</html>