<?php
  session_start();
  if($_SESSION['activeUser']){
    $uid = $_SESSION['activeUser'];
    $email = trim($_POST['email']);
    $confirmEmail = trim($_POST['confirmEmail']);
    $myemail = "/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/";
    if(preg_match($myemail,$email) && $email==$confirmEmail){
      try{
        require('connection.php');
        $sql = "update users set email=? where uid=?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$email,$uid]);
        $db=null;
      }
      catch(PDOException $e){
        echo "Error: ".$e->getMessage();
      }
    }
    header('location:editprofile.php');
  }
  else {
    die("Access Denied.");
  }
 ?>
