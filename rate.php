<?php
    $connection = mysqli_connect("localhost", "myuser", "mypass", "moviesdb");
    if (mysqli_connect_errno()) {
        $message = "Oops!";
        echo "<script> alert('$message'); window.location.href='location: movie_page.php?title='. $title . '; </script>";
    }

    if(isset($_POST['title']))
    {
        $title = $_POST['title'];
        if(isset($_COOKIE['loggedin']))
        {
          if(isset($_POST['rating'])) {
            $rate =  $_POST['rating'];
          }
          $user = $_COOKIE['login_user'];

            $query = "SELECT * FROM `ratings` WHERE username = '$user' AND movieTitle = '$title'";
            $result = mysqli_query($connection,$query);
            $rowcount = mysqli_num_rows($result);
            if($rowcount == 0)
            {
              $sql = "INSERT INTO `ratings` (`movieTitle`, `username`, `rate`) VALUES ('$title','$user','$rate')";
            }
            else
            {
              $sql = "UPDATE ratings SET rate='$rate' WHERE username='$user' AND movieTitle='$title'";
            }
            $try = mysqli_query($connection, $sql);
            if ($try)
            {
              $user_rate = $rate;
              header('location: movie_page.php?title='. $title);
            } else {
              $message = "Oops!";
              echo "<script> alert('$message'); window.location.href='location: movie_page.php?title='. $title . '; </script>";
            }

        }
    }
?>
