<?php
  session_start();
  if(!isset($_SESSION['activeUser']) && !isset($_COOKIE['activeUser']))
    die('Access Denied');
 ?>
