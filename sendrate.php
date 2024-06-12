<?php
  if(!isset($_GET['rate']))
    die("error");
  try {
    require('connection.php');
    echo $_GET['uid'];
    echo "\n".$_GET['mid'];
    echo "\n".$_GET['rate'];
    echo "\n".$_GET['old'];
    echo "\n".$_GET['numberOfRates'];
    $sql1 = "insert into rate values (?,?)";
    $stmt1 = $db->prepare($sql1);
    $stmt1->execute([$_GET['uid'],$_GET['mid']]);

    $updatedRate = round((($_GET['old']*$_GET['numberOfRates'])+$_GET['rate']) / ($_GET['numberOfRates']+1), 2);
    $sql2 = "update movie set rating=?,numberOfRates=? where mid=?";
    $stmt2 = $db->prepare($sql2);
    $stmt2->execute([$updatedRate,$_GET['numberOfRates']+1,$_GET['mid']]);

    $db = null;
  } catch (PDOException $e) {
    echo $e->getMessage();
  }

 ?>
