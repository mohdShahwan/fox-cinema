<?php
  if(!isset($_GET['tid']))
    die('No Tickets Recieved');
  try {
    $tid = $_GET['tid'];
    require('connection.php');
    $sql = "select * from tickets,users,showingmovies,movie where ticketid=? and tickets.uid=users.uid and tickets.showId=showingmovies.showid and showingmovies.mid=movie.mid";
    $stmt = $db->prepare($sql);
    $stmt->execute([$_GET['tid']]);
    $r = $stmt->fetch(PDO::FETCH_ASSOC);
    $seats = json_decode($r['reserved seats']);
    $db = null;
  } catch (PDOException $e) {
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
    .card{
      width: revert;
      margin-bottom: revert;
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
          <a class="dropdown-item" href="editprofile.php">Edit Profile</a>
          <a class="dropdown-item" href="logout.php">Log Out</a>
        </div>
    </ul>
</div>

  </div>
</nav>

<main>
  <div class="container">
    <div class="cards">
      <div class="card mb-5 mx-auto">
      <div class="card-body mx-4">
        <div class="container">
          <p class="my-5 mx-5" style="font-size: 30px;">Thank for your reservation</p>
          <div class="row">
            <ul class="list-unstyled">
              <li class="text-black">Name: <?php echo $r['Name']; ?></li>
              <li class="text-muted mt-1"><span class="text-black">Ticket</span> #<?php echo $r['ticketId']; ?></li>
              <li class="text-black mt-1">Movie: <?php echo $r['title']; ?></li>
              <li class="text-black mt-1">On: <?php echo $r['date']; ?> At: <?php echo $r['time']; ?></li>
              <li class="text-black mt-1">Reserved Seats: <?php for($i=0; $i<count($seats); $i++){
                if($i==count($seats)-1)
                  echo $seats[$i];
                else
                  echo $seats[$i].", ";
              } ?></li>
              <li class="text-black mt-1">In Hall #<?php echo $r['hallId']; ?></li>
              </ul>
            <div class="col-xl-12">
              <p class="float-end fw-bold">Total Price: BHD <?php echo $r['Price']*count($seats); ?>
              </p>
            </div>
          </div>
          <div class="text-center" style="margin-top: 90px;">
            <a href="#" onclick="printTicket()"><u class="text-info">Print your ticket</u></a>
          </div>
        </div>
      </div>
    </div>
    </div>
  </div>
</main>

<!-- Footer -->
<footer>
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
    function printTicket(){
      window.print();
    }
  </script>
  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous"></script>




</body></html>
