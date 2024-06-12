<?php
  try {
    require('connection.php');
    $sql = "select Email from users where email=?";
    $stmt = $db->prepare($sql);
    $stmt->execute([$_GET['email']]);
    if($stmt->rowCount()>0)
      echo '1';
    else
      echo "0";
  } catch (PDOException $e) {
    echo $e->getMessage();
  }

 ?>
