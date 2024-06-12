<?php require('cookeitosession.php');?>
<!DOCTYPE html>
<html lang="en"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>FOX Cinema</title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
  <!-- Private CSS -->
  <link rel="stylesheet" href="master.css">
  <link rel="stylesheet" href="form.css">

  <style>
    .rateStar{
      font-size:40px;
      cursor:pointer;
    }
    .card {
      width: 100%;
    }
    .details-style {
      font-size: 2rem;
    }
    .card-text {
      font-size: 1.65rem;
      line-height: 1.75rem;
      min-height: 100px;
      text-align: justify;
      padding-bottom: 30px;
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
          <a class="dropdown-item" href="showingMovies.php">Showing</a>
          <a class="dropdown-item" href="upcomingMovies.php">Upcoming</a>
        </div>
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
   }
       ?>
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

      <?php
        if(!isset($_GET['mid']))
          header('location:index.php');

        $mid = htmlspecialchars($_GET['mid']);
        try {
          require('connection.php');
          $sql1 = "select * from movie where mid=$mid";
          $stmt1 = $db->prepare($sql1);
          $stmt1->execute();
          $movie = $stmt1->fetch(PDO::FETCH_ASSOC);
          if(count($movie)==0)
            header('location:index.html');

          $sql2 = "select * from showingmovies where mid=$mid and isShowing=1";
          $stmt2 = $db->prepare($sql2);
          $stmt2->execute();
          $showingTimes = $stmt2->fetchAll(PDO::FETCH_ASSOC);

          $sql3 = "select users.name,comment from moviecomments,users where mid=$mid and moviecomments.uid=users.uid";
          $stmt3 = $db->prepare($sql3);
          $stmt3->execute();
          $comments = $stmt3->fetchAll(PDO::FETCH_ASSOC);

          $sql4 = "select * from showingmovies where mid=$mid and isShowing=0";
          $stmt4 = $db->prepare($sql4);
          $stmt4->execute();
          $upcomingTimes = $stmt4->fetchAll(PDO::FETCH_ASSOC);

          $watched = false;
          $hasRated = true;
          if(isset($_SESSION['activeUser'])){
            $uid = $_SESSION['activeUser'];
            $sql5 = "select uid from tickets,showingmovies,movie where movie.mid=? and uid=? and tickets.showId=showingmovies.showid and movie.mid=showingmovies.mid";
            $stmt5 = $db->prepare($sql5);
            $stmt5->execute([$mid,$uid]);
            if(count($stmt5->fetchAll(PDO::FETCH_ASSOC))>0)
              $watched = true;

            $sql6 = "select * from rate where mid=? and uid=?";
            $stmt6 = $db->prepare($sql6);
            $stmt6->execute([$mid,$uid]);
            if(count($stmt6->fetchAll(PDO::FETCH_ASSOC))==0)
              $hasRated = false;
          }

          $db = null;
        } catch (PDOException $e) {
          echo "Error: ".$e->getMessage();
        }
       ?>
  <h2 style='border-bottom: 3px solid #009ddb;'><em><?php echo $movie['title']; ?></em></h2>
  <!-- Movie Cards -->
  <div class="container">
    <div class="cards">
      <div class="card">
        <?php
          echo "\n\t<div style='position: relative; left: 0; top: 0;'>";
          echo "\n\t\t<img src='posters/{$movie['poster']}' style='position: relative; top: 0; left: 0;' class='card-img-top' alt='{$movie['title']}'>";
          echo "\n\t</div>";
          echo "\n\t<div class='card-body'>";
          echo "\n\t\t<p class='card-text'>";
          echo "\n\t\t\t<span class='details-style'>Genre : </span>";
          echo "\n\t\t\t {$movie['genre']}<br><br>";
          echo "\n\t\t\t <span class='details-style'>Running Time : </span>";
          /*Modifying duration format*/
          $duration = $movie['duration'];
          $time = explode(':',$duration);
          $h = substr($time[0],1);
          $m = $time[1];
          echo "\n\t\t\t{$h}hr {$m}min<br><br><br>";
          echo "\n\t\t\t <span class='details-style'>Description : </span>";
          echo "{$movie['description']}<br><br><br>";
          if(count($showingTimes)>0 || count($upcomingTimes)>0){
            echo "\n\t\t\t <span class='details-style'>Showtimes : </span><br>";
            if(count($showingTimes)>0){
              echo "\n<span>Current Showing Times: </span>";
              foreach ($showingTimes as $key => $data) {
                echo "<br><a href='reserve.php'>At: {$data['time']}</a>";
              }
              echo "<br>";
            }
            if(count($upcomingTimes)>0){
              echo "\n<span>Upcoming Times: </span>";
              foreach ($upcomingTimes as $key => $data) {
                echo "<br><a href='reserve.php'>On: {$data['date']}, At: {$data['time']}</a>";
              }
            }
          }

          echo "\n\t\t\t <br><br><br><span class='details-style'>Ratings : </span>";
          echo "\n\t\t\t<span class='d-none' id='numberOfRates'>{$movie['numberOfRates']}</span>";
          echo "\n\t\t\t<span id='currentRate'>{$movie['rating']}</span> /5";

          if($watched && !$hasRated){
            echo "<div id='rate' onload='refresh()'>";
            echo "<span  onmouseover='changeStar(this)' onclick='changeStar(this)' id='1' class='rateStar fa fa-star checked'></span>";
            echo "<span onmouseover='changeStar(this)' onclick='changeStar(this)' id='2' class='rateStar fa fa-star'></span>";
            echo "<span onmouseover='changeStar(this)' onclick='changeStar(this)' id='3' class='rateStar fa fa-star'></span>";
            echo "<span onmouseover='changeStar(this)' onclick='changeStar(this)' id='4' class='rateStar fa fa-star'></span>";
            echo "<span onmouseover='changeStar(this)' onclick='changeStar(this)' id='5' class='rateStar fa fa-star'></span><br/>";
            echo "<button  id='submitRate' onclick='result({$_SESSION['activeUser']},{$movie['mid']})' type='button' style='margin-top:10px;margin-left:5px;' class='btn btn-primary'>Submit</button>";
            echo "</div>";
          }

          echo "\n\t\t\t <br><br><br><span class='details-style'>Comments : </span>";
          if ($watched) {
            ?>
            <form action="addcomment.php" method="post">
              <div class="form-group">
                <label>Write your comment:</label>
                <textarea class="form-control" rows="3" name="comment"></textarea>
                <input type="hidden" name="mid" value="<?php echo $movie['mid']; ?>"><br>
                <button type="submit" class="btn btn-primary">Submit</button>
              </div>
            </form>
            <?php
          }
              if(count($comments)>0){
                echo "<div class='comments'>";
                foreach ($comments as $commentIndx => $value) {
                  echo "<br>{$value['name']}: {$value['comment']}";
                }
                echo "</div>";
              }
              echo "\n\t</div>";
           ?>
        </div>
      </div>
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
  let count=1;
  let oldRate = document.getElementById('currentRate').innerText;
  let noRate = document.getElementById('numberOfRates').innerText;
  let rateDiv = document.getElementById('rate');

  function changeStar(item){
    count=item.id;
    for(var i=0;i<5;i++){
      if(i<count)
        document.getElementById(i+1).style.color="orange";
      else
        document.getElementById(i+1).style.color="black";
    }
  }


  function result(uid,mid){
    rateDiv.classList.add('d-none');
    const xhttp = new XMLHttpRequest();
    xhttp.open("GET", "sendRate.php?uid="+uid+"&mid="+mid+"&rate="+count+"&old="+oldRate+"&numberOfRates="+noRate);
    xhttp.send();
    //const sleep = ms => new Promise(r => setTimeout(r, ms));
    location.reload();
  }

  function refresh(){
    location.reload();
  }
</script>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous"></script>



</body></html>
