<!DOCTYPE html><?php require('cookeitosession.php'); require('sessionwithoutstart.php'); ?>
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
    .sidebar{
      background-image: linear-gradient(#0A043C, #0A043C);
    }
    .container-fluid {
      background-image: linear-gradient(#0A043C, #0A043C);
    }

    .sidebar {
    width: 180px;
    }

    @media (min-width: 768px) {
    .main {
    padding-right: 40px;
    padding-left: 220px; /* 180 + 40 */
    }
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
        <a class="nav-link dropdown-toggle" href="index.php" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-expanded="false">
          Movies
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
          <a class="dropdown-item" href="showingmovies.php">Showing</a>
          <a class="dropdown-item" href="upcomingmovies.php">Upcoming</a>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="reserve.php">Booking</a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-expanded="false">
          Account
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
          <a class="dropdown-item" href="topup.php">Balance Top-Up</a>
          <a class="dropdown-item" href="logout.php">Log Out</a>
        </div>
       </li>
    </ul>
</div>

  </div>
</nav>

<div class="container-fluid d-flex flex-column min-vh-100">
  <div class="row">
    <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar side-collapse">
      <div class="sidebar-sticky pt-3">
        <ul class="nav flex-column">
        <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
          <span>Edit Profile</span>
          <a class="d-flex align-items-center text-muted" href="#">
            <span data-feather="plus-circle"></span>
          </a>
        </h6>
        <ul class="nav flex-column mb-2">
          <li class="nav-item">
            <a class="nav-link" href="#" onclick="showInfo()">
              <span data-feather="file-text"></span>
              Your Information
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#" onclick="changeContent(1)">
              <span data-feather="file-text"></span>
              Change Information
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#" onclick="changeContent(2)">
              <span data-feather="file-text"></span>
              Change Password
            </a>
          </li>
        </ul>
      </div>
    </nav>

    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
          <h1 class="h2" id='functionHeader'>Change Information</h1>
        </div>
        <div>
          <div class="row">
            <form id='info' class="col-lg-4" method='post' action='changeemail.php'>
              <div class="form-group">
                <label>New Email Address</label>
                <input type="text" class="form-control" placeholder="Enter your new email address" name="email">
              </div>
              <div class="form-group">
                <label>Confirm New Email Address</label>
                <input type="text" class="form-control" placeholder="Confirm your new email address" name="confirmEmail">
              </div>
              <button type="submit" class="btn btn-primary">Submit</button>
            </form>

            <form id='pass' class="col-lg-4 d-none">
              <div class="form-group">
                <label>Old Password</label>
                <input type="text" class="form-control" placeholder="Enter your current password" name="password">
              </div>
              <div class="form-group">
                <label>New Password</label>
                <input type="text" class="form-control" placeholder="Enter your new password" name="confirmPassword">
              </div>
              <div class="form-group">
                <label>Confirm New Password</label>
                <input type="text" class="form-control" placeholder="Confirm your new password">
              </div>
              <button type="submit" class="btn btn-primary">Submit</button>
            </form>

            <div id='userInfo' class="col-lg-4 d-none">

            </div>
          </div>
        </div>
      </div>
    </main>
  </div>
</div>

<!-- Footer -->
<footer class="mt-auto">
  <div class="container text-center">
    <div class="row">
      <div class="col-xs-12 col-sm-12 col-md-12 mt-2 mt-sm-5">
        <ul class="list-unstyled list-inline social">
          <li class="list-inline-item footer-item"><a href="index.php"><i class="fa fa-facebook"></i></a></li>
          <li class="list-inline-item footer-item"><a href="index.php"><i class="fa fa-instagram"></i></a></li>
          <li class="list-inline-item footer-item"><a href="index.php"><i class="fa fa-twitter"></i></a></li>
          <li class="list-inline-item footer-item"><a href="index.php" target="_blank"><i class="fa fa-envelope"></i></a></li>
        </ul>
      </div>
    </div>
    <div class="row">
      <div class="rights col-xs-12 col-sm-12 col-md-12 mt-2 mt-sm-2">
        <p>© All right Reversed.<a class="ml-2" href="index.php" target="_blank">FOX CINEMA</a></p>
      </div>
    </div>
  </div>
</footer>



  <script>
    let header = document.getElementById('functionHeader');
    let content = document.getElementById('content');
    let userInfo = document.getElementById('userInfo');
    let info = document.getElementById('info');
    let pass = document.getElementById('pass');
    function changeContent(contentType){
      if(contentType == "1"){
        header.innerText = "Change Information";
        if(!pass.classList.contains('d-none'))
          pass.classList.add('d-none');
        if(!userInfo.classList.contains('d-none'))
          userInfo.classList.add('d-none');
        if(info.classList.contains('d-none'))
          info.classList.remove('d-none');
      }
      else{
        header.innerText = "Change Password";
        if(!info.classList.contains('d-none'))
          info.classList.add('d-none');
        if(!userInfo.classList.contains('d-none'))
          userInfo.classList.add('d-none');
        if(pass.classList.contains('d-none'))
          pass.classList.remove('d-none');
      }
    }

    function showInfo(){
      header.innerText = "Your Information";
      if(userInfo.classList.contains('d-none'))
        userInfo.classList.remove('d-none');
      if(!pass.classList.contains('d-none'))
        pass.classList.add('d-none');
      if(!info.classList.contains('d-none'))
        info.classList.add('d-none');

      const xhttp = new XMLHttpRequest();

      xhttp.onload = function(){
        userInfo.innerHTML = this.responseText;
      }
      xhttp.open("GET","getinfo.php");
      xhttp.send();
    }
  </script>
  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous"></script>




</body></html>
