var currentPlaylist = [];
var audioElement;

function formatTime(seconds) {
  var time = Math.round(seconds);
  var minutes = Math.floor(time / 60);
  var seconds = time - minutes * 60;

  var extraZero = seconds < 10 ? "0" : "";

  return minutes + ":" + extraZero + seconds;
}

function updateTimeProgressBar(audio) {
  $(".progressTime.current").text(formatTime(audio.currentTime));
  $(".progressTime.remaining").text(
    formatTime(audio.duration - audio.currentTime)
  );

  var progress = (audio.currentTime / audio.duration) * 100;
  $(".playbackBar .progress").css("width", progress + "%");
}

function Audio() {
  this.currentlyPlaying; // Property to store the currently playing track (initially undefined)
  this.audio = document.createElement("audio"); // Creating an HTML audio element using document.createElement

  this.audio.addEventListener("canplay", function () {
    // 'this' refers to the object that the event was called on
    var duration = formatTime(this.duration);
    $(".progressTime.remaining").text(duration);
  });

  this.audio.addEventListener("timeupdate", function () {
    // 'this' refers to the object that the event was called on
    if (this.duration) {
      updateTimeProgressBar(this);
    }
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
}
