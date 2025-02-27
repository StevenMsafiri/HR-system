<?php

require "../db_config.php";

if($_SERVER['REQUEST_METHOD']=="POST"){

    $username = $_POST['username'];
    $password = $_POST['password'];

    if(!empty($username) && !empty($password)){

        try{
            $query = "SELECT * FROM logins WHERE username = ? AND password =?";
            $stmt = $conn->prepare($query);
            $stmt->execute([$username,$password]);
            $details = $stmt->fetch(PDO::FETCH_ASSOC);

            if($details){

                header("Location: ../index.php");
                exit();


            }else{
                echo "No details found";
                exit();
            }

            $conn = null;
            $stmt = null;

        }catch(PDOException $e){
            echo "Failed to access employee: ". $e->getMessage();
        }
    }else{
        
    }
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/login.css">
    <title>Login Page</title>
</head>
<body>
<div class="logon">
<div class="container-reg">
    <div class="title-container">
        <div class="title">
        <h2 id="title">PLEASE LOG ON</h2>
        </div>
    </div>

    <form  class="login-form" method="POST">
        <div class="input-box">
            <label for="username">Username</label>
            <input type="text" name="username" class="input" >
        </div>
        <div class="input-box">
            <label for="password">Password</label>
            <input type="password" name="password" class="input">
        </div>

        <div class="right">
        <button type="submit" name="submit" id="login-btn">Log on</button>
        </div>

    </form>
</div>
</div>    
</body>
</html>