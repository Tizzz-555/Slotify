var currentPlaylist = [];
var audioElement;

function Audio() {
  this.currentlyPlaying; // Property to store the currently playing track (initially undefined)
  this.audio = document.createElement("audio"); // Creating an HTML audio element using document.createElement

  this.audio.addEventListener("canplay", function () {
    // 'this' refers to the object that the event was called on
    $(".progressTime.remaining").text(this.duration);
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
