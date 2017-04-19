<?php

    $dbc = mysqli_connect('localhost', 'myuser', 'mypass', 'moviesdb');
    if (mysqli_connect_errno()) {
        echo "ERROR: Failed to connect to server: " . mysqli_connect_error();
        exit();
    }

    if(isset($_POST['genre']))
    {
        $genre = $_POST['genre'];
        if($genre == 'all') {
          $query = "SELECT Title, ReleaseYear, Genre, Image, Synopsis FROM movies;";
        } else {
          $query = "SELECT Title, ReleaseYear, Genre, Image, Synopsis FROM movies WHERE Genre LIKE '%$genre%';";
        }
    }

    $result = mysqli_query($dbc,$query);
    $rowcount = mysqli_num_rows($result);
    if ($rowcount == 0) {
        echo "ERROR: Invalid conditions!";
    } else {
        $i = 0;
        while ($row = mysqli_fetch_array($result,MYSQLI_NUM)) {
            if($i == 0)
            {
              echo $row[0] . " | " . $row[1] . " | " . $row[2] . " | " . $row[3] . " | " . $row[4];
            }
            else
            {
              echo " | " . $row[0] . " | " . $row[1] . " | " . $row[2] . " | " . $row[3] . " | " . $row[4];
            }
            $i=$i+1;
        }
    }
    mysqli_free_result($result);

    mysqli_close($dbc);
?>
