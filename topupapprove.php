<?php /**/require('cookeitosession.php');
  require('sessionwithoutstart.php');
  if($_SESSION['activeRole']==0)
    die('Access Denied');

    $reqCount = 0;
    try {
      require('connection.php');
      if(!isset($_POST['submit'])){
        $sql = "select uid,topupid,amount,users.Name,users.Email from topup,users where topup.userid=users.uid and approved=0";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $usersRequests = $stmt->fetchAll();
        $reqCount = count($usersRequests);
      }
      else{
        $recived = explode(',',$_POST['submit']);
        $status = $recived[0];
        $tid = $recived[1];
        $sql = "update topup set approved=? where topupid=?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$status,$tid]);
        if($status==1){
          $amount = $recived[2];
          $uid = $recived[3];
          $sql1 = "update userbalance set balance = balance + ? where uid = ?";
          $stmt1 = $db->prepare($sql1);
          $stmt1->execute([$amount,$uid]);
        }
      }
      $db=null;
    } catch (PDOException $e) {
      echo "Error: ".$e->getMessage();
    }
    if(isset($_POST['submit']))
      header('location:topupapprove.php');
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
          <a class="dropdown-item" href="#">Upcoming</a>
        </div>
      </li>


      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-expanded="false">
          Account
        </a>
           <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
             <a class="dropdown-item" href="addmovie.php">Add Movies</a>
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
            <h1 class="display-6">Approve Top-Up Requests</h1>
        </div>
    </div>
    <div class="row">
      <?php if($reqCount>0){
       ?>
        <div class="col-lg-6 mx-auto">
            <div class="card">
              <form method="post">
                <?php
                  foreach ($usersRequests as $key => $value) {
                    echo "<div class='card-header'>";
                    echo "<div class='bg-white shadow-sm pt-4 pl-2 pr-2 pb-2'>";
                    echo "<ul role='tablist' class='nav bg-light nav-pills rounded nav-fill mb-3'>";
                    echo "User Name: {$value['Name']} <br>";
                    echo "Email: {$value['Email']} <br>";
                    echo "Amount: BHD {$value['amount']} <br>";
                    echo "<button type='submit' name='submit' value='1,{$value['topupid']},{$value['amount']},{$value['uid']}' class='btn btn-success ml-auto'>Approve</button>";
                    echo "<button type='submit' name='submit' value='2,{$value['topupid']},{$value['amount']},{$value['uid']}' class='btn btn-danger ml-1'>Decline</button>";
                    echo "</ul>";
                    echo "</div></div>";
                  }
                 ?>
                </form>
            </div>
        </div>
      <?php }else {
        echo "<div class='alert alert-info mx-auto'>No Requests to be Approved</div>";
      } ?>
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



<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous"></script>



</body></html>
