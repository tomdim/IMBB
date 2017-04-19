<?php
  include('login.php'); // Includes Login Script

  if(isset($_COOKIE['loggedin']))
  {
    if($_COOKIE['loggedin'] == true){
        header("Location: homepage.php");
    }
  }  
?>
<!DOCTYPE html>
<html>
    <head>
    <title>IMBB - Login</title>
    <link href="loginpage.css" rel="stylesheet" type="text/css">
    <link rel="icon" href="icon.ico">
    </head>
    <body id="login-page">
        <div id="first-page">
            <h1>IMBB Login Page</h1>
            <div id="login">
                <h2>Login Form</h2>
                <form action="" method="post">
                    <label>Username:</label>
                    <input id="name" name="username" placeholder="username" type="text">
                    <label>Password:</label>
                    <input id="password" name="password" placeholder="**********" type="password">
                    <input name="submit" type="submit" value=" Login ">
                    <span><?php echo $error; ?></span>
                </form>
            </div>
            <div id="alt">
                <p id="alt-p">Don't have an account yet? Register <a href="register.php">here</a>!</p>
                <a href="homepage.php">Continue without logging in...</a>
            </div>
        </div>
    </body>
</html>
