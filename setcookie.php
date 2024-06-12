<?php
  setcookie('user',$_GET['id'],time()+7*24*60*60);
  setcookie('role',$_GET['role'],time()+7*24*60*60);
  header("location:index.php");
?>
