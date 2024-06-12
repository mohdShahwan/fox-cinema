<?php /**/require('cookeitosession.php');
  require('sessionwithoutstart.php');
  if($_SESSION['activeRole']==1)
    die('Access Denied');
  $formSubmitted = false;
  $executed = false;
  if(isset($_POST['cardOwner']) && isset($_POST['cardNumber']) && isset($_POST['expMonth']) && isset($_POST['expYear']) && isset($_POST['cvv']) && isset($_POST['amount'])){
    $formSubmitted = true;
    $uid = $_SESSION['activeUser'];
    $amount = $_POST['amount'];
    $cardInfo = json_encode([$_POST['cardOwner'],$_POST['cardNumber'],$_POST['expMonth'],$_POST['expYear'],$_POST['cvv']]);
    try {
      require('connection.php');
      $sql = "insert into topup values (null,?,?,?,0)";
      $stmt = $db->prepare($sql);
      $stmt->execute([$uid,$amount,$cardInfo]);
      $db=null;
      $executed = true;
    } catch (PDOException $e) {
      echo "Error: ".$e->getMessage();
    }

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
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css">
  <!-- Private CSS -->
  <link rel="icon" href="logo.png">
  <link rel="stylesheet" href="master.css">
  <style>
    .card{
      width: revert;
      margin-bottom: revert;
    }
    .rounded{
      border-radius: 1rem
    }
    .nav-pills .nav-link{
      color: #555
    }
    .nav-pills .nav-link.active{
      color: white
    }
    input[type="radio"]{
      margin-right: 5px
    }
    .bold{
      font-weight:bold
    }
  </style>
</head>

<body class="d-flex flex-column min-vh-100">
<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top">
  <div class="container">
    <a class="navbar-brand" href="index.php">
      <img src="./index_files/logo.png" alt="logo" width="35" height="35" class="d-inline-block align-text-top">
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
          <a class="dropdown-item" href="#">Upcoming</a>
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
             <a class="dropdown-item" href="editprofile.php">Edit Profile</a>
             <a class="dropdown-item" href="logout.php">Log Out</a>
           </div>
      </li>
    </ul>
</div>

  </div>
</nav>

<main>
  <div class="container py-5">
    <div class="row mb-4">
        <div class="col-8 mx-auto text-center">
            <h1 class="display-6">Balance Top-Up</h1>
        </div>
    </div>
    <div class="row">
      <?php
        if(!$formSubmitted){
       ?>
        <div class="col-lg-6 mx-auto">
            <div class="card">
                <div class="card-header">
                    <div class="bg-white shadow-sm pt-4 pl-2 pr-2 pb-2">
                        <!-- Credit card form tabs -->
                        <ul role="tablist" class="nav bg-light nav-pills rounded nav-fill mb-3">
                            <li class="nav-item"> <a class="nav-link active "> <i class="fas fa-credit-card mr-2"></i> Credit Card </a> </li>
                        </ul>
                    </div>
                    <!-- Credit card form content -->
                    <div class="tab-content">
                        <!-- credit card info-->
                        <div id="credit-card" class="tab-pane fade show active pt-3">
                            <form method="post" onsubmit="return validation()">
                                <div class="form-group"> <label for="username">
                                        <h6>Card Owner</h6>
                                    </label> <input type="text" name="cardOwner" placeholder="Card Owner Name" class="form-control "> </div>
                                <div class="form-group"> <label for="cardNumber">
                                        <h6>Card number</h6>
                                    </label>
                                    <div class="input-group"> <input type="text" name="cardNumber" placeholder="Valid card number" class="form-control">
                                        <div class="input-group-append"> <span class="input-group-text text-muted"> <i class="fab fa-cc-visa mx-1"></i> <i class="fab fa-cc-mastercard mx-1"></i> <i class="fab fa-cc-amex mx-1"></i> </span> </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-8">
                                        <div class="form-group"> <label><span class="hidden-xs">
                                                    <h6>Expiration Date</h6>
                                                </span></label>
                                            <div class="input-group"> <input type="number" placeholder="MM" name="expMonth" class="form-control"> <input type="number" placeholder="YY" name="expYear" class="form-control"> </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group mb-4"> <label data-toggle="tooltip" title="Three digit CV code on the back of your card">
                                                <h6>CVV <i class="fa fa-question-circle d-inline"></i></h6>
                                            </label> <input type="text" class="form-control" name="cvv"> </div>
                                    </div>
                                </div>
                                <div class="form-group"> <label for="amount">
                                        <h6>Amount</h6>
                                    </label> <input type="text" name="amount" placeholder="Amount in BHD" class="form-control "> </div>
                                <div class="card-footer"> <button type="submit" class="subscribe btn btn-primary btn-block shadow-sm"> Confirm Payment </button>
                            </form>
                        </div>
                    </div> <!-- End -->
                    <!-- End -->
                </div>
            </div>
        </div>
    </div>
  <?php }
    else if($formSubmitted && $executed) {
      //echo "<div class>";
      echo "<div class='alert alert-success mx-auto'>  Top-up Requested Successfully <br> <a href='topup.php'>Top-up Again?</a></div>";
      echo "";
    }
   ?>
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



<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous"></script>



</body></html>
