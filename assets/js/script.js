var currentPlaylist = [];
var shufflePlaylist = [];
var tempPlaylist = [];
var audioElement;
var mouseDown = false;
var currentIndex = 0;
var repeat = false;
var shuffle = false;
var userLoggedIn;
var timer;

$(document).click(function (click) {
  var target = $(click.target);

  if (!target.hasClass("item") && !target.hasClass("optionsButton")) {
    hideOptionsMenu();
  }
});

$(window).scroll(function () {
  hideOptionsMenu();
});

$(document).on("change", "select.playlist", function () {
  var playlistId = $(this).val();
  var songId = $(this).prev(".songId").val();

  console.log("playlistId: " + playlistId);
  console.log("songId: " + songId);
});

openPage = (url) => {
  if (timer != null) {
    clearTimeout(timer);
  }
  // If there is no question mark in the url
  if (url.indexOf("?") == -1) {
    url += "?";
  }

  var encodedUrl = encodeURI(url + "&userLoggedIn=" + userLoggedIn);
  $("#mainContent").load(encodedUrl);
  $("body").scrollTop(0);
  history.pushState(null, null, url);
};

createPlaylist = () => {
  let popup = prompt("Please enter the name of your playlist");

  if (popup != null) {
    $.post("includes/handlers/ajax/createPlaylist.php", {
      name: popup,
      username: userLoggedIn,
    }).done((error) => {
      if (error != "") {
        alert(error);
        return;
      }
      openPage("yourMusic.php");
    });
  }
};

deletePlaylist = (playlistId) => {
  var prompt = confirm("Are you sure you want to delete this playlist?");

  if (prompt) {
    $.post("includes/handlers/ajax/deletePlaylist.php", {
      playlistId: playlistId,
    }).done((error) => {
      if (error != "") {
        alert(error);
        return;
      }
      openPage("yourMusic.php");
    });
  }
};

hideOptionsMenu = () => {
  var menu = $(".optionsMenu");
  if (menu.css("display") != "none") {
    menu.css("display", "none");
  }
};

showOptionsMenu = (button) => {
  var songId = $(button).prevAll(".songId").val();
  var menu = $(".optionsMenu");
  var menuWidth = menu.width();
  menu.find(".songId").val(songId);

  var scrollTop = $(window).scrollTop(); // Distance from top of window to top of document
  var elementOffset = $(button).offset().top; // Distance from top of document

  var top = elementOffset - scrollTop;
  var left = $(button).position().left;

  menu.css({
    top: top + "px",
    left: left - menuWidth + "px",
    display: "inline",
  });
};
formatTime = (seconds) => {
  var time = Math.round(seconds);
  var minutes = Math.floor(time / 60);
  var seconds = time - minutes * 60;

  var extraZero = seconds < 10 ? "0" : "";

  return minutes + ":" + extraZero + seconds;
};

updateTimeProgressBar = (audio) => {
  $(".progressTime.current").text(formatTime(audio.currentTime));
  $(".progressTime.remaining").text(
    formatTime(audio.duration - audio.currentTime)
  );

  var progress = (audio.currentTime / audio.duration) * 100;
  $(".playbackBar .progress").css("width", progress + "%");
};

updateVolumeProgressBar = (audio) => {
  var volume = audio.volume * 100;
  $(".volumeBar .progress").css("width", volume + "%");
};

playFirstSong = () => {
  setTrack(tempPlaylist[0], tempPlaylist, true);
};

function Audio() {
  this.currentlyPlaying; // Property to store the currently playing track (initially undefined)
  this.audio = document.createElement("audio"); // Creating an HTML audio element using document.createElement

  this.audio.addEventListener("ended", function () {
    nextSong();
  });

  this.audio.addEventListener("canplay", function () {
    // 'this' refers to the object that the event was called on
    var duration = formatTime(this.duration);
    $(".progressTime.remaining").text(duration);
  });

  this.audio.addEventListener("timeupdate", function () {
    if (this.duration) {
      updateTimeProgressBar(this);
    }
  });

  this.audio.addEventListener("volumechange", function () {
    updateVolumeProgressBar(this);
  });

  this.setTrack = function (track) {
    this.currentlyPlaying = track;
    this.audio.src = track.path; // Set the source of the audio element to the provided src
  };

  this.play = function () {
    this.audio.play();
  };

  this.pause = function () {
    this.audio.pause();
  };

  this.setTime = function (seconds) {
    this.audio.currentTime = seconds;
  };
}
