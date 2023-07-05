<?php
  include("includes/config.php");
  include("includes/classes/Artist.php");
  include("includes/classes/Album.php");
  include("includes/classes/Song.php");


  //session_destroy(); LOGOUT

  if(isset($_SESSION['userLoggedIn'])) { // Check if the 'userLoggedIn' key is set in the $_SESSION array
    $userLoggedIn = $_SESSION['userLoggedIn']; // Assign the value of $_SESSION['userLoggedIn'] to $userLoggedIn
  }
  else {
    header("Location: register.php"); // Redirect the user to the "register.php" page if the 'userLoggedIn' key is not set
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Welcome to Slotify!</title>
  <link rel="stylesheet" type="text/css" href="assets/css/style.css">
  
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
  <script src="assets/js/script.js"></script>
</head>

<body>

  <div id="mainContainer">
    
    <div id="topContainer">

      <?php include("includes/navBarContainer.php"); ?>

      <div id="mainViewContainer">

        <div id="mainContent">