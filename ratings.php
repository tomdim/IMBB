<?php
    $connection = mysqli_connect("localhost", "myuser", "mypass", "moviesdb");
    if (mysqli_connect_errno()) {
        echo "ERROR: Failed to connect to MySQL: " . mysqli_connect_error();
        exit();
    }

    if(isset($_GET['title']))
    {
      $no_rate = '';
      $title = $_GET['title'];
      if(isset($_COOKIE['login_user']))
      {
        $user = $_COOKIE['login_user'];
        $query = "SELECT rate FROM ratings WHERE movieTitle='$title' AND username='$user';";
        $result = mysqli_query($connection,$query);
        $rowcount = mysqli_num_rows($result);
        if ($rowcount == 1) {
          $row = mysqli_fetch_array($result, MYSQLI_NUM);
          $user_rate = $row[0];
        }
        else
        {
          $no_rate = 'You haven\'t rated this film yet! Rate by clicking one of the stars';
          $user_rate = 0;
        }
      }
      else
      {
        $query = "SELECT AVG(rate), COUNT(username) FROM ratings WHERE movieTitle='$title';";
        $result = mysqli_query($connection,$query);
        $rowcount = mysqli_num_rows($result);
        if ($rowcount == 1) {
            $row = mysqli_fetch_array($result, MYSQLI_NUM);
            $avg_rate = number_format((float)$row[0], 2, '.', '');
            $numOfRates = $row[1];
        } else {
            $avg_rate = 0;
            $numOfRates = 0;
        }
      }

    }
    elseif(isset($_POST['title']))
    {
        $title = $_POST['title'];
        $query = "SELECT AVG(rate) FROM ratings WHERE movieTitle='$title';";
        $result = mysqli_query($connection,$query);
        $rowcount = mysqli_num_rows($result);
        if ($rowcount == 1) {
            $row = mysqli_fetch_array($result, MYSQLI_NUM);
            $avg_rating = number_format((float)$row[0], 2, '.', '');
        } else {
            $avg_rating = 0;
        }
        echo $avg_rating;
    }
    mysqli_close($connection);

?>
