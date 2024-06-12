<?php

  /*
  MTV = Model Template View
  MVC = Model View     Controller

  */
  require('cookeitosession.php'); require('sessionwithoutstart.php');
  try {
    require('connection.php');
    $sql1 = "select showid,movie.title,reservedSeats,price,halls.rows,time,date,isShowing from showingmovies,halls,movie where showingmovies.hallid=halls.hid and showingmovies.mid=movie.mid order by isShowing desc";
    $stmt1 = $db->prepare($sql1);
    $stmt1->execute();
    $showingRows = $stmt1->fetchAll(PDO::FETCH_ASSOC);

    $db=null;
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
  <link rel="stylesheet" href="layout.css">
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

      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="index.php" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-expanded="false">
          Movies
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
          <a class="dropdown-item" href="showingmovies.php">Showing</a>
          <a class="dropdown-item" href="upcomingmovies.php">Upcoming</a>
        </div>
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
    </ul>
</div>

  </div>
</nav>

<main>
  <div class="container">
      <div class="movie-container">
        <label>Pick a movie:</label>
        <select id="movie">
          <?php
            foreach ($showingRows as $movieIndx => $data) {
              echo "\n<option value='{$data['price']},{$data['showid']}'";
              if($movieIndx==0)
                echo " selected class='firstElem'";
              echo ">{$data['title']} (BHD {$data['price']}) At {$data['time']}";
              if($data['isShowing']==0)
                echo " On {$data['date']}";
              echo "</option>";
            }
          ?>
        </select>
      </div>
      <ul class="showcase">
        <li>
          <div class="seat"></div>
          <small>N/A</small>
        </li>
        <li>
          <div class="seat selected"></div>
          <small>Selected</small>
        </li>
        <li>
          <div class="seat occupied"></div>
          <small>Reserved</small>
        </li>
      </ul>

      <div class="container">
        <div class="screen"></div>
        <div class="seats">
          <?php
            for($i=0; $i<6; ++$i){
              echo "\n\t\t\t\t\t<div class='row'>";
              for($j=0; $j<8; ++$j)
                echo "\n\t\t\t\t\t\t<div class='seat'></div>";
              echo "\n\t\t\t\t\t</div>";
            }
           ?>
        </div>
      </div>
      <p class="text">
        Price per seat: <span id='price'><?php echo $showingRows[0]['price']; ?></span> BHD
      </p>
      <p class="text">
        You have selected <span id="count">0</span> seats for a price of <span id="total">0</span> BHD
      </p>
      <form action="pay.php" method="post">
        <input id='sid' type="hidden" name="sid" value="" class="d-none">
        <input id='totalPrice' type="hidden" name="totalPrice" value="" class="d-none">
        <input id='reserveSeats' type="hidden" name="reserveSeats" value="" class="d-none"><br><br>
        <button id='pay' type="submit" class="btn btn-secondary" disabled='true'>Pay</button>
      </form>



</main>

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
    const container = document.querySelector('.seats');
    const movieSelect = document.getElementById('movie');
    const seats = document.querySelectorAll('.row .seat');
    const count = document.getElementById('count');
    const total = document.getElementById('total');

    const payButton = document.getElementById('pay');

    const seatsInput = document.forms[0].elements['reserveSeats'];
    const totalInput = document.forms[0].elements['totalPrice'];
    const sidInput = document.forms[0].elements['sid'];

    const pricePerSeat = document.getElementById('price');

    document.querySelector('.firstElem').selected = true;

    populateUI(<?php echo "'".json_encode($showingRows[0]['reservedSeats'])."'"; ?>);



    // Update total and count
    function updateSelectedCount() {
      let ticketPrice = movieSelect.value.split(",")[0];

      const selectedSeats = document.querySelectorAll('.row .seat.selected');

      const seatsIndex = [...selectedSeats].map(seat => [...seats].indexOf(seat));

      seatsInput.value = JSON.stringify(seatsIndex);

      const selectedSeatsCount = selectedSeats.length;

      count.innerText = selectedSeatsCount;
      total.innerText = selectedSeatsCount * ticketPrice;
      totalInput.value = selectedSeatsCount * ticketPrice;
      sidInput.value = movieSelect.value.split(",")[1];
    }

    // Get data from localstorage and populate UI
    function populateUI(occupiedSeatsJson) {
      //clear all selections
      seats.forEach((seat, index) => {
        if (seat.classList.contains("selected")) {
          seat.classList.remove('selected');
        }
        if(seat.classList.contains('occupied')){
          seat.classList.remove('occupied');
        }
      });

      const occupiedSeatsIndex = JSON.parse(occupiedSeatsJson);

      if (occupiedSeatsIndex !== null && occupiedSeatsIndex.length > 0) {
        seats.forEach((seat, index) => {
          if (occupiedSeatsIndex.indexOf(index) > -1) {
            seat.classList.add('occupied');
          }
        });
      }
      else {
        seats.forEach((seat, index) => {
          if (seat.classList.contains("occupied")) {
            seat.classList.remove('occupied');
          }
        });
      }
      // Initial count and total set
      updateSelectedCount();
    }


    // Movie select event
    movieSelect.addEventListener('change', e => {
      ticketPrice = +e.target.value;
      //setMovieData(e.target.selectedIndex, e.target.value);
      let info = e.target.value.split(",");
      pricePerSeat.innerText = info[0];
      ticketPrice.innerText = info[0];
      xhttp = new XMLHttpRequest();
      xhttp.onload = function(){
        populateUI(this.response);
      }
      xhttp.open('GET', 'getOccSeats.php?sid='+info[1]);
      xhttp.send();
      updateSelectedCount();
    });


    // Seat click event
    container.addEventListener('click', e => {
      if (
        e.target.classList.contains('seat') &&
        !e.target.classList.contains('occupied')
      ) {
        e.target.classList.toggle('selected');

        updateSelectedCount();
        if(count.innerText>0)
          payButton.disabled = false;
        else
          payButton.disabled = true;
      }
    });
  </script>
  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous"></script>
</body>
</html>
