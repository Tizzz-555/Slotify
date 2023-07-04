<?php
  include("includes/config.php");

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
    <div id="nowPlayingBarContainer">

    </div>
</body>
</html>