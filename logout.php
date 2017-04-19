<?php
    if (isset($_COOKIE['loggedin'])) {
      unset($_COOKIE['loggedin']);
      unset($_COOKIE['login_user']);
      setcookie('loggedin', false, time() - 3600, '/');
      setcookie('login_user', '', time() - 3600, '/');
    }
    header("Location: index.php");

?>
