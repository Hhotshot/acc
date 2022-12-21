<?php
#include("../connect/connect.php");
@session_start();
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="/docs/4.0/assets/img/favicons/favicon.ico">

    <title>Cph_login</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/4.0/examples/sign-in/">

    <!-- Bootstrap core CSS -->
    <link href="ref/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="ref/signin.css" rel="stylesheet">
  </head>

  <body class="text-center">
    <form class="form-signin" method="post" action="login_check.php">
      <img class="mb-4 img-fluid" src="ref/logo_money.png" alt="">

      <h1 class="h1 mb-3 font-weight-normal">Login</h1>
      
      <?php 
      if(isset($_REQUEST["up"])){
      ?>
      <span style="color:red;font-weight:bold"><h2>User หรือ pass ผิด</h2></span>
      <?php 
      }
      ?>
      <input type="text" name="username" maxlength="13"  class="form-control" placeholder="Username" required autofocus>
      
      <input type="password" name="password"  class="form-control" placeholder="Password" required>
      

      <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
      
    </form>
  </body>
</html>


