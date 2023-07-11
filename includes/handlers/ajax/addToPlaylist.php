<?php 
include("../../config.php");

if(isset($_POST['playlistId']) && isset($_POST['songId'])) {
	$playlistId = $_POST['playlistId'];
  $songId = $_POST['songId'];

  // Add to the end of the playlist id by adding 1 to the song with the highest order
  // If it's the first song to be added set playlistOrder to 1 with "IFNULL"
  $orderIdQuery = mysqli_query($con, "SELECT IFNULL(MAX(playlistOrder) + 1, 1) as playlistOrder FROM playlistSongs WHERE playlistId = '{$playlistId}'");
  $row = mysqli_fetch_array($orderIdQuery);
  $order = $row['playlistOrder'];

  $query = mysqli_query($con, "INSERT INTO playlistSongs VALUES(NULL, '$songId', '$playlistId', '$order')");
} 
else {
	echo "PlaylistId or songId not passed into addToPlaylist.php";
}

?>