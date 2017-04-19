<?php
    include('ratings.php');
    //session_start();
    if(isset($_COOKIE['loggedin']))
    {
      if($_COOKIE['loggedin'] == true)
      {
          $login_logout = '<p>User: '. $_COOKIE['login_user'] .' <a href="logout.php">Log out</a></p>';
      }else
      {
        $login_logout = '<a href="index.php">Log in</a>';
      }
    }else
    {
      $login_logout = '<a href="index.php">Log in</a>';
    }
?>
<!DOCTYPE html>
<html>
    <head>
    <title>IMBB - Home page</title>
    <link href="homepage.css" rel="stylesheet" type="text/css">
    <link rel="icon" href="icon.ico">
    <script type="text/javascript" src="imbb.js"></script>
    </head>
    <body id="home-page">

      <div id="banner-div" class="banner">
          <div id="title" class="banner"> <img src="icon.ico" /> <h1>IMBB</h1> </div>
          <div id="login-logout" class="banner"> <?php echo $login_logout; ?> </div>
      </div>

      <div class="item-block">
        <div class="search-block select">
          <label for="search">
            Search by Genre :
          </label>
          <select id="search" class="search" onchange="searchMovies(this.value);">
            <option value="none" selected="selected" disabled="disabled">--------------</option>
            <option value="all">All Genres</option>
            <option value="Action">Action</option>
            <option value="Adventure">Adventure</option>
            <option value="Comedy">Comedy</option>
            <option value="Drama">Drama</option>
            <option value="Fantasy">Fantasy</option>
            <option value="History">History</option>
            <option value="Mystery">Mystery</option>
            <option value="Romance">Romance</option>
            <option value="Science fiction">Science fiction</option>
            <option value="Thriller">Thriller</option>
          </select>
        </div>

        <div class="sort-block select">
            <label for="sort">
              Sort by :
            </label>
            <select id="sort" class="sort" onchange="sort(this.value);">
              <option value="title" selected="selected">Title</option>
              <option value="rate-asc">rate-asc</option>
              <option value="rate-desc">rate-desc</option>
            </select>
        </div>

        <div id="movie-list" class="movie-list">

        </div>
      </div>
    </body>
</html>
