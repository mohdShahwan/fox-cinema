<?php require('cookeitosession.php'); require('sessionwithoutstart.php')?>
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
  <link rel="stylesheet" href="form.css">
  <style>
    h3{
      color: #3eb2e0;
    }
    a{
      text-align: center;
    }
  </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top">
  <div class="container">
    <a class="navbar-brand" href="./index.php">
      <img src="logo.png" alt="logo" width="35" height="35" class="d-inline-block align-text-top">
      <span class="brand-name">FOX CINEMA</span>
    </a>

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
    </button>
  <div class="nav-container collapse navbar-collapse" id="navbarNavDropdown">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" href="addmovie.php">Add Movies</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="topupapprove.php">Top-ups Requests</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="logout.php">Log Out</a>
      </li>
    </ul>
</div>

  </div>
</nav>

<main class="container-fluid d-flex flex-column min-vh-100">
  <?php if(isset($_GET['status'])){
    echo "<h2>Status Recieved</h2>";
    if($_GET['status']==1)
      echo "<h2>Success!</h2>";
    echo "<a href='addmovie.php'>Insert More Movies</a><br>";
    echo "<a href='index.php'>Return to the Homepage</a>";
  }else{

  ?>
  <div class="container mb-4">
    <form method="post" action="insertmovie.php">
      <h2 style="border-bottom: 3px solid #009ddb;">Add a Movie</h2>
      <div class="row">
        <div class="container col-lg-4">
          <div class="form-group">
            <label>Number of Movies to Add:</label>
            <input type="number" class="form-control" value='1' min='1' max='5' onKeyDown="return false" onchange="modifyFields(this.value)">
          </div><br><br>


          <div id="moviesToAdd">
            <div class="movie mb-5">
              <h3>Movie <span class='indx'>1</span>:</h3>
              <div class="form-group">
                <label>Movie Title: </label>
                <input type="text" class="form-control" name="titles[]">
              </div>
              <div class="form-group">
                <label>Movie Desciption: </label>
                <textarea class="form-control" rows="3" name="desciptions[]"></textarea>
              </div>
              <div class="form-group">
                <label>Movie Duration: </label><br>
                <input class="form-control" placeholder="HH:MM" type="text" name="durations[]">
              </div>
              <div class="form-group">
                <label>Movie Genre: </label><br>
                <input class="form-control" type="text" name="genres[]">
              </div>
              <div class="form-group">
                <label>Poster File Name: </label><br>
                <input class="form-control" type="text" name="posters[]">
                <small class="form-text text-muted">Please make sure to upload the poster in the server path folder (/poster) and don't forget to specify the poster file type (png, jpg, etc).</small>
              </div>
            </div>


          </div>
          <button type="submit" class="btn btn-info d-block">Submit</button>
        </div>
      </div>
    </form>
  </div>
  <?php } ?>
</main>


<div id="movieTemplate" class='d-none'>
  <div class="movie mb-5">
    <h3>Movie <span class='indx'>1</span>:</h3>
    <div class="form-group">
      <label>Movie Title: </label>
      <input type="text" class="form-control" name="titles[]">
    </div>
    <div class="form-group">
      <label>Movie Desciption: </label>
      <textarea class="form-control" rows="3" name="desciptions[]"></textarea>
    </div>
    <div class="form-group">
      <label>Movie Duration: </label><br>
      <input class="form-control" type="text" placeholder="HH:MM" name="durations[]">
    </div>
    <div class="form-group">
      <label>Movie Genre: </label><br>
      <input class="form-control" type="text" name="genres[]">
    </div>
    <div class="form-group">
      <label>Poster File Name: </label><br>
      <input class="form-control" type="text" name="posters[]">
      <small class="form-text text-muted">Please make sure to upload the poster in the server path folder (/poster) and don't forget to specify the poster file type (png, jpg, etc).</small>
    </div><br><br>
  </div>
</div>



<!-- Footer -->
<footer class="mt-auto">
  <div class="container text-center">
    <div class="row">
      <div class="col-xs-12 col-sm-12 col-md-12 mt-2 mt-sm-5">
        <ul class="list-unstyled list-inline social">
          <li class="list-inline-item footer-item"><a href="./index.php"><i class="fa fa-facebook"></i></a></li>
          <li class="list-inline-item footer-item"><a href="./index.php"><i class="fa fa-instagram"></i></a></li>
          <li class="list-inline-item footer-item"><a href="./index.php"><i class="fa fa-twitter"></i></a></li>
          <li class="list-inline-item footer-item"><a href="./index.php" target="_blank"><i class="fa fa-envelope"></i></a></li>
        </ul>
      </div>
    </div>
    <div class="row">
      <div class="rights col-xs-12 col-sm-12 col-md-12 mt-2 mt-sm-2">
        <p>© All right Reversed.<a class="ml-2" href="./index.php" target="_blank">FOX CINEMA</a></p>
      </div>
    </div>
  </div>
</footer>



  <script>
    let movieIndx = 1;
    let movieTemplate = document.getElementById('movieTemplate');
    let moviesToAdd = document.getElementById('moviesToAdd');
    let lastChild;

    function modifyFields(currentIndx){
      if(currentIndx>movieIndx){
        movieIndx++;
        movieTemplate.getElementsByClassName('indx')[0].innerText = movieIndx;
        movieTemplate.querySelector('.movie').setAttribute("id","indx"+movieIndx);
        moviesToAdd.innerHTML+=movieTemplate.innerHTML;
      }
      else if(currentIndx<movieIndx){
        moviesToAdd.querySelectorAll('.movie').item(movieIndx-1).remove()
        movieIndx--;
      }
    }
  </script>
  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous"></script>




</body></html>
