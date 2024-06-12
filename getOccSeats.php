<?php
  if(!isset($_GET['sid']))
    die("No Show Recived");
  try {
    require('connection.php');
    $sql = "select reservedSeats from showingmovies where showid=?";
    $stmt = $db->prepare($sql);
    $stmt->execute([$_GET['sid']]);
    $r = $stmt->fetch(PDO::FETCH_ASSOC);
    if(isset($r['reservedSeats']))
      echo $r['reservedSeats'];
    else
      echo "null";
    $db = null;
  } catch (PDOException $e) {
    echo "Error: ".$e->getMessage();
  }

 ?>
