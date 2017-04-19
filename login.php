<?php
    $error='';
    if (isset($_POST['submit'])) {
        if (empty($_POST['username']) || empty($_POST['password'])) {
            $error = "Username or Password is invalid";
        }
        else
        {
            $username=$_POST['username'];
            $password=$_POST['password'];

            $connection = mysqli_connect("localhost", "myuser", "mypass", "moviesdb");
            if (mysqli_connect_errno()) {
                echo "ERROR: Failed to connect to MySQL: " . mysqli_connect_error();
                exit();
            }
            $query = "SELECT Username, FullName, Email, Pass FROM users WHERE Username='$username' AND Pass = '$password';";
            $result = mysqli_query($connection,$query);
            $rowcount = mysqli_num_rows($result);
            if ($rowcount == 1) {
                $row = mysqli_fetch_array($result, MYSQLI_NUM);
                $fullname = $row[1];
                setcookie("loggedin", true, time() + (60 * 60), '/');
                setcookie("login_user", $username, time() + (60 * 60), '/');
                setcookie("user_fullname", $fullname, time() + (60 * 60), '/');
                header("location: homepage.php");

            } else {
                $error = "Username or Password is invalid";
            }
            mysqli_close($connection);
        }
    }
?>
