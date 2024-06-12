<?php
  session_start();
  if(!isset($_POST['comment']) || !isset($_SESSION['activeUser']))
    die("No Data Found.");
  else {
    try {
      require('connection.php');
      $sql = "insert into moviecomments values (?,?,?)";
      $stmt = $db->prepare($sql);
      $stmt->execute([$_SESSION['activeUser'],$_POST['mid'],$_POST['comment']]);
      $db=null;
      header("location:movie.php?mid={$_POST['mid']}");
    } catch (PDOException $e) {
      echo $e->getMessage();
    }
  }
?>
