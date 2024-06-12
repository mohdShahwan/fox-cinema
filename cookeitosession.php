<?php session_start();
  if(isset($_COOKIE['role']) && !isset($_SESSION['activeRole'])){
    $_SESSION['activeUser'] = $_COOKIE['user'];
    $_SESSION['activeRole'] = $_COOKIE['role'];
  }
 ?>
