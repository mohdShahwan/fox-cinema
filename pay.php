<?php
    require('session.php');
    if(!isset($_POST['totalPrice']) || !isset($_POST['reserveSeats']) ||!isset($_POST['sid']) )
      die('No Inputs Received');
    $totalPrice = $_POST['totalPrice'];
    try {
      require('connection.php');
      $db->beginTransaction();
      $uid = $_SESSION['activeUser'];
      $sql1 = "select balance from userbalance where uid=?";
      $stmt1 = $db->prepare($sql1);
      $stmt1->execute([$uid]);
      $r = $stmt1->fetch(PDO::FETCH_ASSOC);
      $balance = $r['balance'];
      if($balance < $totalPrice)
        die('Insufficient Balance');

        $sql2 = "update userbalance set balance=balance-? where uid=?";
        $stmt2 = $db->prepare($sql2);
        $stmt2->execute([$totalPrice,$uid]);

        /**/$sql3 = "update showingmovies set reservedSeats = json_merge_preserve(`reservedSeats`,?) where showid=?";
        $stmt3 = $db->prepare($sql3);
        $stmt3->execute([$_POST['reserveSeats'],$_POST['sid']]);

        $sql4 = "insert into tickets values (null,?,?,?)";
        $stmt4 = $db->prepare($sql4);
        $stmt4->execute([$uid,$_POST['sid'],$_POST['reserveSeats']]);
        $tid = $db->lastInsertId();

      $db->commit();
      $db = null;
    } catch (PDOException $e) {
      $db->rollBack();
      echo "Error: ".$e->getMessage();
    }
    header("location:ticket.php?tid=$tid");
 ?>
