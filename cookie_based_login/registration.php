<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Registration</title>
        </head>
        <style>
            .validation-error {
                color: red;
            }
        </style>
        <body>
        <?php 
            $nameErr = $emailErr = $mobErr = $passwordErr = "";
            $name = "";
            $email = "";
            $mob = "";
            $password = "";
            $errMsg = "";

            // function set_cookies($k, $v){
            //     setrawcookie($k, $v);
            // }

            // setcookie("users", "", time()-3600);


            // name
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                // name
                if (empty($_POST["name"])) {
                    $nameErr = "Name is required";
                } else {
                    $name = $_POST["name"];
                    // set_cookies("name", $_POST["name"]);
                    // $users += ["name" => $_POST["name"]];
                }
                
                // email
                if (empty($_POST["email"])) {
                    $emailErr = "Email is required";
                } 
                else {
                    $email = $_POST["email"];
                    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        $emailErr = "Invalid email format";
                    }
                    // else {
                    //     // set_cookies("email", $email);
                    //     // $users += ["email" => $_POST["email"]];
                    // }
                } 
                
                //password
                if(empty($_POST["password"])) {
                    $passwordErr = "password is required";
                }
                else {
                    $password = $_POST['password'];
                    // set_cookies("password", $_POST["password"]);
                }
                // mobile
                if(empty($_POST["mob"])){
                    $mobErr = "Phone no is required";
                }
                else {
                    $mob = $_POST['mob'];
                }

                $user[] = [
                    "email"=> $email,
                    "password"=> $password,
                    "name"=> $name
                ];
    
                $user_data = json_encode($user); // converted to json
                $checkCookie = isset($_COOKIE["users"]);
    
                if(!isset($_COOKIE["users"])){
                    setcookie("users", $user_data);
                }
                else {
                    $users_arr = json_decode($_COOKIE["users"], true); //gives users arr in php
                    if($users_arr[$email] == $user[$email]){
                        $errMsg = "User already exist";
                    } else {
                        $users_arr += $user; //updating user_arr in php
                        setcookie("users", json_encode($users_arr), "/"); //set cookies after updated array which converted to json 
                    }
                }
                
            }
            


            ?>
        <?php echo "$checkCookie"; ?>
        <form  method="post" action="<?php echo $_SERVER["PHP_SELF"];?>" onsubmit="return submitHandler(event)" >
            <label for="name">Name: </label>
            <input type="text" name="name" class="required"> <?php echo "$nameErr" ?> 
            <div class="validation-error"></div> <br>

            <label for="email">Email: </label> 
            <input type="email" name="email" id="" class="required"><?php echo "$emailErr" ?> 
            <div class="validation-error"></div> <br>


            <label for="mobile">Phone no. </label>
            <input type="tel" name="mob" id="" class="required"><?php echo "$mobErr" ?>
            <div class="validation-error"></div> <br>


            <label for="password">Password: </label>
            <input type="password" name="password" id="" class="required"><?php echo "$passwordErr" ?>
            <div class="validation-error"></div> <br>

            <?php echo "$errMsg"; ?>


            <input type="submit" value="submit">

        </form>
        <script src="validation.js"></script>

    
</body>
</html>



