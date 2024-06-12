<?php
  session_start();
  if($_SESSION['activeUser']){
    try{
      require('connection.php');
      $uid = $_SESSION['activeUser'];
      $sql1 = "select * from users where uid=?";
      $sql2 = "select balance from userbalance where uid=?";
      $stmt1 = $db->prepare($sql1);
      $stmt1->execute([$uid]);
      $userRow = $stmt1->fetch(PDO::FETCH_ASSOC);
      $stmt2 = $db->prepare($sql2);
      $stmt2->execute([$uid]);
      $balanceRow = $stmt2->fetch(PDO::FETCH_ASSOC);
      $db = null;
      echo "<h3>Name: {$userRow['Name']}</h3>";
      echo "<h3>Email: {$userRow['Email']}</h3>";
      echo "<h3>Balance: {$balanceRow['balance']} BHD</h3>";
    }
    catch(PDOException $e){
      echo "Error: ".$e->getMessage();
    }
  }
  else {
    die("Access Denied.");
  }
 ?>
