<?php require('cookeitosession.php'); ?>
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
</head>

<body class="d-flex flex-column min-vh-100">
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

      <li class="nav-item">
        <a class="nav-link" href="upcomingmovies.php">Upcoming Movies</a>
      </li>
      <?php
      if(isset($_SESSION['activeUser'])){
        if($_SESSION['activeRole']==0){
       ?>
      <li class="nav-item">
        <a class="nav-link" href="reserve.php">Booking</a>
      </li>
      <?php
     }
  }?>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-expanded="false">
          Account
        </a>
        <?php
        if(isset($_SESSION['activeUser'])){
          if($_SESSION['activeRole']==0){
         ?>
           <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
             <a class="dropdown-item" href="topup.php">Balance Top-Up</a>
             <a class="dropdown-item" href="editprofile.php">Edit Profile</a>
             <a class="dropdown-item" href="logout.php">Log Out</a>
           </div>
           <?php
          }
           else{
            ?>
          <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
            <a class="dropdown-item" href="addmovie.php">Add Movies</a>
            <a class="dropdown-item" href="topupapprove.php">Top-ups Requests</a>
            <a class="dropdown-item" href="logout.php">Log Out</a>
          </div>
        <?php
          }
        }
        else{
         ?>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
          <a class="dropdown-item" href="login.php">Login</a>
          <a class="dropdown-item" href="register.php">Register</a>
        </div>
        <?php
        }
         ?>
      </li>
    </ul>
</div>

  </div>
</nav>

<main>

  <h2 style='border-bottom: 3px solid #009ddb;'><em>SHOWING MOVIES</em></h2>
  <hr class="mt-2 mb-5" color='white'/>
  <!-- Movie Cards -->
  <div class="container">
    <div class="row mb-5">
      <div class="col-4">
        <select class="custom-select" onchange="filter(this.value)">
          <option value='default' selected>Filter by Genre</option>
          <option value="Action">Action</option>
          <option value="Drama">Drama</option>
          <option value="Suberhero">Suberhero</option>
          <option value="Adventure">Adventure</option>
          <option value="Animation">Animation</option>
          <option value="Comedy">Comedy</option>
          <option value="Family">Family</option>
          <option value="Fantasy">Fantasy</option>
          <option value="Mystery">Mystery</option>
          <option value="Medieval">Medieval</option>
        </select>
      </div>
    </div>
    <?php
    try{
      require('connection.php');
      $sql1 = "select showingmovies.mid,time,title,duration,genre,rating,poster from showingmovies join movie on showingmovies.mid = movie.mid where isShowing=1";
      $stmt1 = $db->prepare($sql1);
      $stmt1->execute();
      $showingMovies = $stmt1->fetchAll(PDO::FETCH_ASSOC);
      if(count($showingMovies)==0){
        echo "<h2 style='color:red'>Sorry, No Showing Movies at the moment.</h2>";
      }
      else{
        echo "<div class='cards'>\n";
        foreach($showingMovies as $i=>$data){
          echo "\t\t<div class='card d-block' id='{$data['mid']}'>";
          echo "\n\t\t<div style='position: relative; left: 0; top: 0;'>";
          echo "\n\t\t\t<img src='posters/{$data['poster']}' style='position: relative; top: 0; left: 0;' class='card-img-top' alt='{$data['title']}'>";
          echo "\n\t\t</div>";
          echo "\n\t\t<div class='card-body'>";
          echo "\n\t\t\t<h5 class='card-title'>{$data['title']}";
          echo "\n\t\t <span class='imdb'><span id='currentRate'>Ratings: {$data['rating']}</span> /5</span>";
          echo "\n\t\t</h5>";
          echo "\n\t\t\t</h5>";
          echo "\n\t\t\t<p class='card-text'>";
          echo "\n\t\t\t\t<span class='details-style'>Genre : </span>";
          echo "\n\t\t\t\t <span class='genres'>{$data['genre']}</span><br>";
          echo "\n\t\t\t\t <span class='details-style'>Running Time : </span>";
          /*Modifying duration format*/
          $duration = $data['duration'];
          $time = explode(':',$duration);
          $h = substr($time[0],1);
          $m = $time[1];
          echo "\n\t\t\t\t{$h}hr {$m}min<br>";
          echo "\n\t\t\t\t <span class='details-style'>Showing At:</span> {$data['time']}";
          echo "\n\t\t\t</p>";
          echo "\n\t\t\t<a href='movie.php?mid={$data['mid']}' class='btn btn-secondary pull-right'>More Info</a>";
          echo "\n\t\t</div>";
          echo "\n\t</div>\n";
        }
        echo "\n\t</div>";
      }
      $db = null;
    }
    catch(PDOException $e){
      echo "Error: ".$e->getMessage();
    }

       ?>
       <div id='noMovies' class="d-none">
         <h1 style='text-align:center'>No Movies Available for seslected genre.</h1>
       </div>
  </div>

</main>

<!-- Footer -->
<footer class="mt-auto">
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



<script>
  const cards = document.getElementsByClassName('card');
  let genres;
  let noMovies = document.getElementById('noMovies');
  let successFound;

  function filter(genre){
    successFound = 0;
    for(let i=0; i<cards.length; ++i){
      if(noMovies.classList.contains('d-block')){
        noMovies.classList.remove('d-block');
        noMovies.classList.add('d-none');
      }
      if(genre=='default'){
        if(cards[i].classList.contains('d-none')){
          cards[i].classList.remove('d-none');
          cards[i].classList.add('d-block');
          successFound++;
        }
      }
      else{
        genres = cards[i].getElementsByClassName('genres')[0].innerText.split(", ");
        if(genres.includes(genre)){
          successFound++;
          if(cards[i].classList.contains('d-none')){
            cards[i].classList.remove('d-none');
            cards[i].classList.add('d-block');
          }
        }
        else{
          if(cards[i].classList.contains('d-block')){
            cards[i].classList.remove('d-block');
            cards[i].classList.add('d-none');
          }
        }
      }
      if(successFound==0){
        noMovies.classList.remove('d-none');
        noMovies.classList.add('d-block');
      }
    }
  }
</script>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous"></script>



</body></html>
