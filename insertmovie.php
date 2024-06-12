<?php
  session_start();
  if(isset($_SESSION['activeRole']) && $_SESSION['activeRole']==1 && isset($_POST['titles']) && isset($_POST['durations']) && isset($_POST['desciptions']) && isset($_POST['genres']) && isset($_POST['posters'])){
    /*input validation*/
    $myTitle = "/^.{3,50}$/i";
    $myDuration = "/^0[1-4]:[0-5]\d$/";
    $myPoster = "/^[\w\d]{1,46}\.(jpg|png|jpeg)$/";
    foreach ($_POST['titles'] as $title) {
      if(preg_match($myTitle,trim($title)))
        $titles[] = $title;
      else
        die("Invalid Input for Titles: $title");
    }

    foreach ($_POST['desciptions'] as $description)
        $desciptions[] = $description;

    foreach ($_POST['durations'] as $duration) {
      if(preg_match($myDuration,trim($duration)))
        $durations[] = $duration;
      else
        die("Invalid Input for Durations: $duration");
    }

    foreach ($_POST['genres'] as $genre)
        $genres[] = $genre;

    foreach ($_POST['posters'] as $poster) {
      if(preg_match($myPoster,trim($poster)))
        $posters[] = $poster;
      else
        die("Invalid Input for Posters: $poster");
    }

    if(!(count($titles)==count($desciptions) && count($titles)==count($durations) && count($titles)==count($genres) && count($titles)==count($posters)))
      die("Missing Inputs");
    try{
      require('connection.php');
      $db->beginTransaction();
      $sql = "insert into movie values (null,?,?,?,?,0,?)";
      $stmt = $db->prepare($sql);
      for($i=0; $i<count($titles); ++$i)
        $stmt->execute([$titles[$i],$desciptions[$i],$durations[$i].":00",$genres[$i],$posters[$i]]);
      $db->commit();
      $db->null;
      header("location:addmovie.php?status=1");
    }
    catch(PDOException $ex){
      $db->rollBack();
      echo "Error: ".$ex->getMessage();
    }
  }
  else {
    die("Error");
  }
?>
