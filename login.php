<?php
  session_start();
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
  <!-- Form CSS -->
  <link rel="stylesheet" href="form.css">
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
              <a class="dropdown-item" href="showingMovies.php">Showing</a>
              <a class="dropdown-item" href="upcomingMovies.php">Upcoming</a>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="reserve.php">Booking</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <!-- End of Navbar -->

<main>
  <div class="container login">
  <?php
  if(isset($_POST['email']) && isset($_POST['password']) && !empty($_POST['email']) && !empty($_POST['password'])){
    /*input validation here*/
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    /*
      Password Requirments:
      - min 8 and max 12
      - at least one upper case
      - at least one lower case
      - at least one number
      - at least onespecial character
    */
    $myemail = "/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/";
    if(preg_match($myemail,$email)==1){
      try{
        require('connection.php');
        $sql = "select * from users where email=?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$email]);
        $db = null;
        if($row = $stmt->fetch(PDO::FETCH_NUM)){
          if(password_verify($password,$row[2])){
            $_SESSION['activeUser'] = $row[0];
            $_SESSION['activeRole'] = $row[4];
            if(isset($_POST['remember']))
              header("location:setcookie.php?id=$row[0]&role=$row[4]");
            else
              header("location:index.php");
          }
            else{
              header("refresh:2;url:index.php");
              echo "<h2>Wrong Password</h2>";
              header("location:index.php");
            }
          }
          else {
            echo "<h2>User does not exist!</h2>";
            header("location:index.php");
          }
        }
        catch(PDOException $e){
          die("Error: "+$e.getMessage());
        }
      }
      else{
        echo "<h2>Invalid Input!</h2>";
        header("location:index.php");
      }
    }
    else{
   ?>
  <!-- Login Form -->
    <form method='post' id='form'>
      <h2>Log Into Your Account</h2>
        <div class="row">
          <div class="container col-lg-4">
            <div class="form-group">
              <label for="exampleInputEmail1">Email Address</label>
              <input type="text" class="form-control" id="email" placeholder="Enter email address" name="email">
              <small class="invisible">Error Message</small>
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1">Password</label>
              <input type="password" class="form-control" id="password" placeholder="Enter password" name="password">
              <small class="invisible">Error Message</small>
            </div>
            <div class="form-group form-check">
              <input type="checkbox" class="form-check-input" id="remember" name='remember'>
              <label class="form-check-label" for="remember">Remember me</label>
            </div>
            <button type="submit" class="btn btn-light btn-lg btn-block">Log In</button>
          <div class="container mt-3 mb-5">
            Don't have an account? <a href="register.php">Register Now!</a>
          </div>
        </div>
      </form>
    <?php
    } ?>
  </div>
</div>
  <!-- End of Login Form -->
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
    const form = document.getElementById('form');
    const email = document.getElementById('email');
    const password = document.getElementById('password');
    let allErrors;

    // Show input error message
    function showError(input, message) {
      const formControl = input.parentElement;
      const small = formControl.querySelector('small');
      small.classList.remove('invisible');
      small.classList.add('visible');
      small.innerText = message;
    }

    // Show success outline
    function showSuccess(input) {
      const formControl = input.parentElement;
      const small = formControl.querySelector('small');
      small.classList.remove('visible');
      small.classList.add('invisible');
    }

    // Check email is valid
    function checkEmail(input) {
      const xhttp = new XMLHttpRequest();
      let found = false;

      let error = 0;
      const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

      if (re.test(input.value.trim())) {
        showSuccess(input);
        ++error;
      } else if(found) {
        showError(input, 'Email is not valid');
        ++error;
      }

      return error;


    }

    // Check required fields
    function checkRequired(inputArr) {
      let error=0;
      inputArr.forEach(function(input) {
        if (input.value.trim() === '') {
          showError(input, `${getFieldName(input)} is required`);
          ++error;
        } else {
          showSuccess(input);
        }
      });
      return error;
    }

    // Check input length
    function checkLength(input, min, max) {
      let error=0;
      if (input.value.length < min) {
        showError(
          input,
          `${getFieldName(input)} must be at least ${min} characters`
        );
        ++error;
      } else if (input.value.length > max) {
        showError(
          input,
          `${getFieldName(input)} must be less than ${max} characters`
        );
        ++error;
      } else {
        showSuccess(input);
      }
      return error;
    }


    // Get fieldname
    function getFieldName(input) {
      return input.id.charAt(0).toUpperCase() + input.id.slice(1);
    }

    // Event listeners
    form.addEventListener('submit', function(e) {
      e.preventDefault(); //prevents auto submit
      allErrors = 0;
      allErrors+=checkRequired([email, password]);
      allErrors+=checkLength(password, 2, 25);
      //allErrors+=checkEmail(email);

      //If all requirements are successful, submit the form
      if (allErrors===0)
          form.submit();
    });



  </script>
  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous"></script>




</body></html>
