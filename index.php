<?php  
include("includes/includedFiles.php");
?>

<h1 class="pageHeadingBig">You Might Also Like</h1>

<div class="gridViewContainer">

  <?php
    $albumQuery = mysqli_query($con, "SELECT * FROM albums ORDER BY RAND() LIMIT 10");
    // Query the "albums" table in the database to select 10 random albums, ordering them randomly
    
    while($row = mysqli_fetch_array($albumQuery)) {
      // Iterate through each row (album) fetched from the query result
      
      echo "<div class='gridViewItem'>
      <span role='link' tabindex='0' onclick='openPage(\"album.php?id=" . $row['id'] . "\")'>
                <img src='" . $row['artworkPath'] . "'>
              
                <div class='gridViewInfo'>"
                  . $row['title'] . 
                "</div>
              </span>
              
            </div>";
      // Output the album information in HTML format, including the album ID, artwork path, and title
    }
    
  ?>

</div>
 