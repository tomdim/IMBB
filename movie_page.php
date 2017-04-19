<?php
    include('ratings.php');
    $title = $_GET['title'];

    if(isset($_COOKIE['loggedin']))
    {
      if($_COOKIE['loggedin'] == true)
      {
          $login_logout = '<p>User: '. $_COOKIE['login_user'] .' <a href="logout.php">Log out</a></p>';
          $ratings_title = $_COOKIE['login_user'] . '\'s ratings';
          $numOfRates_p = '';
          $loggedin = true;
      }else
      {
        $login_logout = '<a href="index.php">Log in</a>';
        $ratings_title = 'IMBB Users Ratings';
        $numOfRates_p = '<p id="numOfVotes">Number of users who have rated the film: '. $numOfRates .'</p>';
        $loggedin = false;
      }
    }else
    {
      $login_logout = '<a href="index.php">Log in</a>';
      $ratings_title = 'IMBB Users Ratings';
      $numOfRates_p = '<p id="numOfVotes">Number of users who have rated the film: '. $numOfRates .'</p>';
      $loggedin = false;
    }


?>

<!DOCTYPE html>
<html>
    <head>
    <title>IMBB - Movie Page</title>
    <link href="moviepage.css" rel="stylesheet" type="text/css">
    <link rel="icon" href="icon.ico">
    <script type="text/javascript" src="imbb.js"></script>
    <!--<script type="text/javascript" src="stars-rate.js"></script>-->
    </head>
    <body id="movie-page" onload="loadMoviePage('<?php echo $title; ?>', '<?php if(!isset($_COOKIE['loggedin'])){ echo $avg_rate; } ?>', '<?php if(isset($_COOKIE['loggedin'])){ echo $user_rate; } ?>');">

      <div id="banner-div" class="banner">
          <div id="title" class="banner"> <img src="icon.ico" /> <a id="title" href="homepage.php">IMBB</a> </div>
          <div id="login-logout" class="banner"> <?php echo $login_logout; ?> </div>
      </div>

      <div class="movie-block">
          <div id="movie">
              <div id="movie-image">
                  <img id="image" src="" alt="Movie Image"/>
              </div>

              <div id="movie-info">
                  <div id="info">
                      <h1 id="movie-title"><?php echo $title; ?></h1>
                      <script type="text/javascript">
                         var title = "&title=<?php echo $title; ?>";
                      </script>
                      <p id="year">####</p><p id="genre">######</p>
                      <p id="synopsis">#####</p>
                  </div>
              </div>
          </div>
      </div>

      <div class="user-ratings">
          <h2> <?php echo $ratings_title; ?> </h2>
          <div class="ratings">
            <p id="ratings">
              <?php
                  if(isset($_COOKIE['loggedin'])) {
                    if($no_rate != '') {
                      echo $no_rate;
                    }
                    else {
                        echo 'Previous ' . $_COOKIE['login_user'] . '\'s rate: ' . $user_rate . ' out of 5';
                    }
                  }
                  else {
                    echo 'Movie ratings: ' . $avg_rate . ' out of 5';
                  }
              ?>
          </p>
            <?php echo $numOfRates_p; ?>
          </div>
          <div id="stars">
            <p><?php
                if(isset($_COOKIE['loggedin'])) {
                  if($no_rate != '') {
                    echo 'Rate the movie!';
                  }
                  else {
                      echo 'Changed your mind? Rate the movie again!';
                  }
                }
                else {
                  echo 'IMBB Users\' Rates in stars';
                }
            ?></p>

              <form action="" method="POST" id="stars_for_users" class="rating-stars">
              				<input type="range" min="1" max="5" value="' .<?php echo $user_rate; ?> . '" name="rating">
                      <button type="submit" name="submit-rate" value="submit-rate">Rate</button>
              </form>

          </div>
      </div>

    </body>
</html>
