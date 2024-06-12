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
              <a class="dropdown-item" href="showingMovies.php">Now Showing?</a>
              <a class="dropdown-item" href="upcomingMovies.php">Coming Soon</a>
            </div>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <!-- End of Navbar -->

<main>
  <!-- Login Form -->
  <div class="container login">
    <?php
      if(isset($_POST['name']) && isset($_POST['email']) && isset($_POST['password']) && !empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['name'])){
        /*input validation here*/
        $name = trim($_POST['name']);
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);

        $myname = "/^\w{3,}$/";
        $myemail = "/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/";
        $mypass = "/^[\w\d#?&\*$!@%^\-]{8,12}$/";
        $p1 = "/[A-Z]/";
        $p2 = "/[a-z]/";
        $p3 = "/\d/";
        $p4 = "/[#?&\*$!@%^\-]/";
        if(preg_match($myname,$name)==1 && preg_match($myemail,$email)==1 && preg_match($p1,$password)==1 && preg_match($p2,$password)==1 && preg_match($p3,$password)==1 && preg_match($p4,$password)==1){
          $password = password_hash($password, PASSWORD_DEFAULT);
          try{
            require('connection.php');
            $sql1 = "insert into users values (null,?,?,?,0)";
            $sql2 = "insert into userbalance values (?,0)";
            $stmt1 = $db->prepare($sql1);
            $stmt1->execute([$name,$password,$email]);
            $stmt2 = $db->prepare($sql2);
            $stmt2->execute([$db->lastInsertId()]);
            $db = null;
            header('location:login.php');
          }
          catch(PDOException $e){
            die("Error: "+$e.getMessage());
          }
        }
        else
          echo "<h2>Invalid Input!</h2>";
      }
      else{
     ?>
    <form method="post" id='form'>
      <h2>Create Your Account</h2>
        <div class="row">
          <div class="container col-lg-4">
            <div class="form-group">
              <label for="exampleInputEmail1">Name</label>
              <input type="text" class="form-control" id="username" placeholder="Enter your name" name="name">
              <small class="invisible">Error Message</small>
            </div>
          <div class="form-group">
            <label for="exampleInputEmail1">Email Address</label>
            <input type="email" class="form-control" id="email" placeholder="Enter email address" name="email">
            <small class="invisible">Error Message</small>
          </div>
          <div class="form-group">
            <label for="exampleInputPassword1">Password</label>
            <input type="password" class="form-control" id="password" placeholder="Enter password" name="password">
            <small class="invisible">Error Message</small>
          </div>
          <div class="form-group">
            <label for="exampleInputPassword1">Confirm Password</label>
            <input type="password" class="form-control" id="password2" placeholder="Confirm password" name="password">
            <small class="invisible">Error Message</small>
          </div>
          <button type="submit" class="btn btn-light btn-lg btn-block">Register</button>
        <div class="container mt-3 mb-5">
          Already have an account? <a href="login.php">Log In</a>
        </div>
    </form>
    <?php
    } ?>
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
    const username = document.getElementById('username');
    const email = document.getElementById('email');
    const password = document.getElementById('password');
    const password2 = document.getElementById('password2');

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

      xhttp.onload = function(){
        if(+this.response==1)
          found = true;
          if (!(re.test(input.value.trim()))) {
            showError(input, 'Email is not valid');
            ++error;
          } else if(found) {
            showError(input, 'Email already exists');
            ++error;
          }else {
            showSuccess(input);
          }
      }
      xhttp.open('GET','getEmail.php?email='+input.value);
      xhttp.send();

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

    // Check passwords match
    function checkPasswordsMatch(input1, input2) {
      let error = 0;
      if (input1.value !== input2.value) {
        showError(input2, 'Passwords do not match');
        ++error;
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
      let allErrors = 0;
      allErrors+=checkRequired([username, email, password, password2]);
      allErrors+=checkLength(username, 3, 15);
      allErrors+=checkLength(password, 6, 25);
      allErrors+=checkEmail(email);
      allErrors+=checkPasswordsMatch(password, password2);

      //If all requirements are successful, submit the form
      if (allErrors===0)
          form.submit();
    });



  </script>
  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous"></script>




</body></html>
