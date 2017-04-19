<?php
  include("signup.php");
?>

<!DOCTYPE html>
<html>
    <head>
    <title>IMBB - Register</title>
    <link href="loginpage.css" rel="stylesheet" type="text/css">
    <link rel="icon" href="icon.ico">
    </head>
    <body id="login-page">
        <div id="first-page">
            <h1>Join IMBB family!</h1>
            <div id="login">
                <h2>Register Form</h2>
                <form action="" method="post">
                    <label>Username:</label>
                    <input id="name" name="username" placeholder="username" type="text">
                    <label>Password:</label>
                    <input id="password" name="password" placeholder="**********" type="password">
                    <label>Full Name:</label>
                    <input id="password" name="fullname" placeholder="Full Name" type="text" maxlength="50">
                    <label>Email:</label>
                    <input id="email" name="email" placeholder="email" type="email">
                    <input name="submit-register" type="submit" value="Register">
                    <span><?php echo $error; ?></span>
                </form>
            </div>
        </div>
    </body>
</html>
