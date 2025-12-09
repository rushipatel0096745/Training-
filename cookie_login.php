<?php 

    $nameErr = $emailErr = $mobErr = $passwordErr = "";

    $name = $_POST["name"];
    $email = $_POST["email"];
    $mob = $_POST["mob"];
    $password = $_POST["password"];

    function set_cookies($k, $v){
        setcookie($k, $v);
    }

    function get_cookies($k){
        return $_COOKIE[$k];
    }


    // name
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (empty($_POST["name"])) {
            $nameErr = "Name is required";
        } else {
            $name = $_POST["name"];
            set_cookies("name", $_POST["name"]);
        }
        
        // email
        if (empty($_POST["email"])) {
            $emailErr = "Email is required";
        } 
        elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Email is invalid";
        }
        else {
            $email = $_POST["email"];
            set_cookies("email", $_POST["email"]);
        }

        //password
        if(empty($_POST["password"])) {
            $passwordErr = "password is required";
        }
        else {
            $password = $_POST['password'];
            set_cookies("password", $_POST["password"]);
        }

        // mobile
        if(empty($_POST["mob"])){
            $mobErr = "Phone no is required";
        }
        else {
            $password = $_POST['password'];
        }
    }
?>