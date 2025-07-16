<?php
    include "service/database.php";
    session_start();
    
    $login_message = "";

    if(isset($_SESSION["is_login"])){
        header("location: dashboard.php");
    }

    if(isset($_POST['login'])){
       $username = $_POST['username'];
       $password = $_POST['password'];

       $sql ="SELECT * FROM tb_user WHERE 
       username= '$username' AND password='$password'
       ";
       $result = $db->query($sql);

       if($result->num_rows > 0){
        $data = $result->fetch_assoc();
        $_SESSION["username"] = $data ["username"];
        $_SESSION["is_login"] = true;

        header("location: dashboard.php");

       }else {
        $login_message = "Akun belum terdaftar";
       }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form login</title>
    <style>
        body {
            background-image: url("/img/JPL.jpg");
            background-size: cover;
            background-repeat: no-repeat;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        fieldset {
            border: none;
            background-color: rgba(255, 255, 255, 0.7);
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
            max-width: 400px;
            width: 100%;
        }
        h1 {
            font-size: 24px;
            color: #333;
            text-align: center;
            margin-bottom: 18px;
        }
        h1 {
            text-align: center;
            margin: 18px 0;
        }
        header {
            text-align: center; 
            margin-bottom: 20px;
        }
        header h3 {
            margin: 5px 0;
            color: #333;
        }
        header a {
            text-decoration: none;
            color: #333;
            margin: 0 10px;
        }
        header a:hover {
            text-decoration: underline;
        }
        label {
            display: block;
            margin-bottom: 10px;
            color: #333;
        }
        input[type="text"],
        input[type="password"] {
            width: 90%;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            outline: none;
        }
        input[type="text"]:focus,
        input[type="password"]:focus {
            border-color: #4CAF50;
        }
        button[type="submit"] {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: none;
            outline: none;
            background-color: #4CAF50;
            color: #fff;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        button[type="submit"]:hover {
            background-color: #45a049;
        }
        .login-message {
            color: red;
            margin-top: 10px;
            text-align: center;
        }
    </style>
</head>
<body>
    <fieldset>
        <h1>Halaman Login Monitoring</h1>

        <header>
            <h3>Silahkan Login</h3>
            <div>
                <a href="index.php">Home</a> 
            </div>
        </header>
        
        <i class="login-message"><?= $login_message ?></i>
        <form action="login.php" method="POST">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" placeholder="Enter your username">
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" placeholder="Enter your password">
            <label for="remember"><input type="checkbox" id="remember" name="remember" value="remember"> Remember me</label>
            <button type="submit" name="login">Login Now</button>
        </form>
        
    </footer>
    </fieldset>
    
   
</body>
</html>

