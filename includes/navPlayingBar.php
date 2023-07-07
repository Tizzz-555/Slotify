<?php
// Query to select 10 random song IDs from the Songs table
$songQuery = mysqli_query($con, "SELECT id FROM Songs ORDER BY RAND() LIMIT 10");

$resultArray = array(); // Initialize an empty array to store the song IDs

while ($row = mysqli_fetch_array($songQuery)) {
  array_push($resultArray, $row['id']); // Push each song ID into the result array
}

// Convert the array of song IDs to JSON format
$jsonArray = json_encode($resultArray);
?>

<script>

$(document).ready(function() {
  currentPlaylist = <?php echo $jsonArray; ?>; // Retrieve the JSON array of song IDs and assign it to the "currentPlaylist" variable
  audioElement = new Audio(); // Create a new Audio object
  setTrack(currentPlaylist[0], currentPlaylist, false); // Call the "setTrack" function with the first song ID from the playlist
  updateVolumeProgressBar(audioElement.audio);


  $("#nowPlayingBarContainer").on("mousedown touchstart mousemove touchmove", function(e) {
    e.preventDefault();
  });

  // SONG PROGRESS CONTROLS
  $(".playbackBar .progressBar").mousedown(function() {
    mouseDown = true;
  });

  $(".playbackBar .progressBar").mousemove(function(e) {
    if(mouseDown) {
      timeFromOffset(e, this);
    };
  });

  $(".playbackBar .progressBar").mouseup(function(e) {    
    timeFromOffset(e, this);
  });

  // VOLUME CONTROLS
  $(".volumeBar .progressBar").mousedown(function() {
    mouseDown = true;
  });

  $(".volumeBar .progressBar").mousemove(function(e) {
    if(mouseDown) {

      var percentage = e.offsetX / $(this).width();

      if(percentage >= 0 && percentage <= 1) {
        audioElement.audio.volume = percentage;
      }
      
    }
  });

  $(".volumeBar .progressBar").mouseup(function(e) {  
    var percentage = e.offsetX / $(this).width();  

    if(percentage >= 0 && percentage <= 1) {
        audioElement.audio.volume = percentage;
      }
  });

  $(document).mouseup(function() {
    mouseDown = false;
  });


});

function timeFromOffset(mouse, progressBar) {
  var percentage = mouse.offsetX / $(progressBar).width() * 100;
  var seconds = audioElement.audio.duration * (percentage / 100);
  audioElement.setTime(seconds);
}

function prevSong() {
  if(audioElement.audio.currentTime >= 3 || currentIndex == 0) {
    audioElement.setTime(0);
  } else {
    currentIndex--;
    setTrack(currentPlaylist[currentIndex], currentPlaylist, true);
  }

  var trackToPlay = currentPlaylist[currentIndex];
  setTrack(trackToPlay, currentPlaylist, true);
}

function nextSong() {
  if(repeat) {
    audioElement.setTime(0);
    playSong();
    return;
  }
  if(currentIndex == currentPlaylist.length - 1) {
    currentIndex = 0;
  } else {
    currentIndex++;
  }

  var trackToPlay = currentPlaylist[currentIndex];
  setTrack(trackToPlay, currentPlaylist, true);
}

function setRepeat() {
  repeat = !repeat;
  var imageName = repeat ? "repeat-active.png" : "repeat.png";
  $(".controlButton.volume img").attr("src", "assets/images/icons/" + imageName);
}

function setMute() {
  audioElement.audio.muted = !audioElement.audio.muted;
  var imageName = audioElement.audio.muted ? "volume-mute.png" : "volume.png";
  $(".controlButton.volume img").attr("src", "assets/images/icons/" + imageName);
}

function setTrack(trackId, newPlaylist, play) {
  currentIndex = currentPlaylist.indexOf(trackId);
  pauseSong();

  // Perform an AJAX POST request to get the song details using the trackId
  $.post("includes/handlers/ajax/getSongJson.php", { songId: trackId }, function(data) {
      var track = JSON.parse(data); // Parse the JSON response and assign it to the "track" variable

      $(".trackName span").text(track.title); // Set the track title in the HTML element with the class "trackName"

      $.post("includes/handlers/ajax/getArtistJson.php", { artistId: track.artist }, function(data) {
        
        var artist = JSON.parse(data); 

        $(".artistName span").text(artist.name); 
      });

      $.post("includes/handlers/ajax/getAlbumJson.php", { albumId: track.album }, function(data) {
        
        var album = JSON.parse(data); 

        $(".albumLink img").attr("src", album.artworkPath); 
      });
      
      audioElement.setTrack(track); // Set the audio element's track path to the song's path
      playSong(); // Play the audio element
  });
  
  if(play) {
    audioElement.play(); // If the "play" parameter is true, play the audio element
  }
}

function playSong() {

  if(audioElement.audio.currentTime == 0) {
    $.post("includes/handlers/ajax/updatePlays.php", { songId: audioElement.currentlyPlaying.id });
  }

  $(".controlButton.play").hide(); 
  $(".controlButton.pause").show(); 

  audioElement.play(); 
}

function pauseSong() {
  $(".controlButton.play").show(); 
  $(".controlButton.pause").hide(); 
  audioElement.pause();
}
</script>


<div id="nowPlayingBarContainer">
  
    <div id="nowPlayingBar">

      <div id="nowPlayingLeft">
        <div class="content">
          <span class="albumLink">
            <img src="" class="albumArtwork" alt="">
          </span>

          <div class="trackInfo">
            <span class="trackName">
              <span></span>
            </span>

            <span class="artistName">
              <span></span>
            </span>

          </div>

        </div>

      </div>

      <div id="nowPlayingCenter">

        <div class="content playerControls">
          
          <div class="buttons">      
            <button class="controlButton shuffle" title="Shuffle button">
              <img src="assets/images/icons/shuffle.png" alt="Shuffle">
            </button>

            <button class="controlButton previuos" title="Previous button" onclick="prevSong()">
              <img src="assets/images/icons/previous.png" alt="Previous">
            </button>

            <button class="controlButton play" title="Play button" onclick="playSong()">
              <img src="assets/images/icons/play.png" alt="Play">
            </button>

            <button class="controlButton pause" title="Pause button" style="display: none;" onclick="pauseSong()">
              <img src="assets/images/icons/pause.png" alt="Pause">
            </button>

            <button class="controlButton next" title="Next button" onclick="nextSong()">
              <img src="assets/images/icons/next.png" alt="Next">
            </button>

            <button class="controlButton repeat" title="Repeat button" onclick="setRepeat()">
              <img src="assets/images/icons/repeat.png" alt="Repeat">
            </button>       
          </div>


          <div class="playbackBar">

            <span class="progressTime current">0.00</span>
            <div class="progressBar">
              <div class="progressBarBg">
                <div class="progress"></div>
              </div>
            </div>
            <span class="progressTime remaining">0.00</span>
            
          </div>

      </div>

    </div>

    <div id="nowPlayingRight">    
      <div class="volumeBar">

        <button class="controlButton volume" title="Volume button" onclick="setMute()">
          <img src="assets/images/icons/volume.png" alt="Volume">
        </button>

        <div class="progressBar">
            <div class="progressBarBg">
              <div class="progress"></div>
            </div>
        </div>

      </div>
      
    </div>

  </div>

</div>