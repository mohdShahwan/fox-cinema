<?php require('cookeitosession.php');
  try{
    require('connection.php');
    $sql = "select * from movie";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $movies = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $db = null;
  }
  catch(PDOException $e){
    echo "Error: ".$e->getMessage();
  }
 ?>
<!DOCTYPE html>
<html lang="en"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>FOX Cinema</title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
  <!-- Private CSS -->
  <link rel="icon" href="logo.png">
  <link rel="stylesheet" href="master.css">
  <style>
    .imdb{
      font-family: 'Effra', serif;
    }
  </style>
</head>

<body>
<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top">
  <div class="container">
    <a class="navbar-brand" href="index.php">
      <img src="logo.png" alt="logo" width="35" height="35" class="d-inline-block align-text-top">
      <span class="brand-name">FOX CINEMA</span>
    </a>

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
    </button>
  <div class="nav-container collapse navbar-collapse" id="navbarNavDropdown">
    <ul class="navbar-nav">

      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-expanded="false">
          Movies
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
          <a class="dropdown-item" href="showingmovies.php">Showing</a>
          <a class="dropdown-item" href="upcomingmovies.php">Upcoming</a>
        </div>
      </li>
        <?php
        if(isset($_SESSION['activeUser'])){
          if($_SESSION['activeRole']==0){
         ?>
         <li class="nav-item">
           <a class="nav-link" href="reserve.php">Booking</a>
         </li>
         <li class="nav-item dropdown">
           <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-expanded="false">
             Account
           </a>
           <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
             <a class="dropdown-item" href="topup.php">Balance Top-Up</a>
             <a class="dropdown-item" href="editprofile.php">Edit Profile</a>
             <a class="dropdown-item" href="logout.php">Log Out</a>
           </div>
          </li>
           <?php
          }
           else{
            ?>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-expanded="false">
                Account
              </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
            <a class="dropdown-item" href="addmovie.php">Add Movies</a>
            <a class="dropdown-item" href="topupapprove.php">Top-ups Requests</a>
            <a class="dropdown-item" href="logout.php">Log Out</a>
          </div>
        </li>
        <?php
          }
        }
        else{
         ?>
         <li class="nav-item">
           <a class="nav-link" href="login.php">Login</a>
         </li>
         <li class="nav-item">
           <a class="nav-link" href="register.php">Register</a>
         </li>
        <?php
        }
         ?>

    </ul>
</div>

  </div>
</nav>

<main>
  <div class="container">
    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
    <ol class="carousel-indicators">
      <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
      <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
      <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
      <li data-target="#carouselExampleIndicators" data-slide-to="3"></li>
    </ol>
    <div class="carousel-inner">
      <?php
        /**/echo "\n";
        shuffle($movies);
        for($i=0; $i<4; ++$i){
          echo "\t\t<div class='carousel-item";
          if($i==0)
            echo " active";
          echo "'>\n\t\t\t<img class='d-block w-100' src='./posters/{$movies[$i]['poster']}' alt='{$movies[$i]['title']}'>";
          echo "\n\t\t</div>\n";
        }
       ?>
    </div>
    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="sr-only">Next</span>
    </a>
    </div>
  </div>

  <h2 id="featured"><em>BROWSE MOVIES</em></h2>

  <!-- Movie Cards -->
  <div class="container">
    <div class="cards">
      <?php
          for($i=0; $i<count($movies); ++$i){
            echo "<div class='card'>";
            echo "\n\t<div style='position: relative; left: 0; top: 0;'>";
            echo "\n\t\t<img src='posters/{$movies[$i]['poster']}' style='position: relative; top: 0; left: 0;' class='card-img-top' alt='{$movies[$i]['title']}'>";
            echo "\n\t</div>";
            echo "\n\t<div class='card-body'>";
            echo "\n\t\t<h5 class='card-title'>{$movies[$i]['title']}";
            echo "\n\t\t <span class='imdb'><span id='currentRate'>Ratings: {$movies[$i]['rating']}</span> /5</span>";
            echo "\n\t\t</h5>";
            echo "\n\t\t<p class='card-text'>";
            echo "\n\t\t\t<span class='details-style'>Genre : </span>";
            echo "\n\t\t\t {$movies[$i]['genre']}<br>";
            echo "\n\t\t\t <span class='details-style'>Running Time : </span>";
            /*Modifying duration format*/
            $duration = $movies[$i]['duration'];
            $time = explode(':',$duration);
            $h = substr($time[0],1);
            $m = $time[1];
            echo "\n\t\t\t{$h}hr {$m}min<br>";
            echo "\n\t\t<a href='movie.php?mid={$movies[$i]['mid']}' class='btn btn-secondary'>More Info</a>";
            echo "\n\t</div>";
            echo "\n</div>\n";
          }
       ?>
    </div>
  </div>

  <!-- Location -->
  <h2><em>OUR LOCATION</em></h2>

  <div class="text-center mx-auto">
    <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d3578.490396560871!2d50.584992!3d26.245743!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xe0aae9ebaaec9a58!2sThe%20Avenues!5e0!3m2!1sen!2sbh!4v1647622377317!5m2!1sen!2sbh" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
  </div>

</main>

<!-- Footer -->
<footer>
  <div class="container text-center">
    <div class="row">
      <div class="col-xs-12 col-sm-12 col-md-12 mt-2 mt-sm-5">
        <ul class="list-unstyled list-inline social">
          <li class="list-inline-item footer-item"><a href="#"><i class="fa fa-facebook"></i></a></li>
          <li class="list-inline-item footer-item"><a href="#"><i class="fa fa-instagram"></i></a></li>
          <li class="list-inline-item footer-item"><a href="#"><i class="fa fa-twitter"></i></a></li>
          <li class="list-inline-item footer-item"><a href="#" target="_blank"><i class="fa fa-envelope"></i></a></li>
        </ul>
      </div>
    </div>
    <div class="row">
      <div class="rights col-xs-12 col-sm-12 col-md-12 mt-2 mt-sm-2">
        <p>© All right Reversed.<a class="ml-2" href="#" target="_blank">FOX CINEMA</a></p>
      </div>
    </div>
  </div>
</footer>




<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous"></script>



</body></html>
