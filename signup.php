<?php
    $error='';
    $connection = mysqli_connect("localhost", "myuser", "mypass", "moviesdb");
    if (mysqli_connect_errno()) {
        $error = "ERROR: Failed to connect to MySQL: " . mysqli_connect_error();
        exit();
    }

    if(isset($_POST['submit-register']))
    {
      $username = $_POST['username'];
      $password =  $_POST['password'];
      $fullname = $_POST['fullname'];
      $email = $_POST['email'];
      if(!empty($username))
      {
        $query = "SELECT * FROM users WHERE Username = '$username'";
        $result = mysqli_query($connection,$query);
        $rowcount = mysqli_num_rows($result);
        if($rowcount == 0)
        {
          $sql = "INSERT INTO users (`Username`, `FullName`, `Email`, `Pass`) VALUES ('$username','$fullname','$email','$password')";
          $try = mysqli_query($connection, $sql);
          if ($try)
          {
            $message = "Your registration was successful!";
            echo "<script> alert('$message'); window.location.href='index.php'; </script>";
          } else {
              $error = "Error: " . $sql . "<br>" . $connection->error;
          }
        }
        else
        {
          $error = "The username " . $username . " is already taken!";
        }
      }
    }
?>
