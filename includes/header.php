<?php
  include("includes/config.php");
  include("includes/classes/Artist.php");
  include("includes/classes/Album.php");

  //session_destroy(); LOGOUT

  if(isset($_SESSION['userLoggedIn'])) {
    $userLoggedIn = $_SESSION['userLoggedIn'];
  }
  else {
    header("Location: register.php");
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" type="text/css" href="assets/css/style.css">
</head>

<body>

  <div id="mainContainer">
    
    <div id="topContainer">

      <?php include("includes/navBarContainer.php"); ?>

      <div id="mainViewContainer">

        <div id="mainContent">