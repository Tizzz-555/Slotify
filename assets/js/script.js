var currentPlaylist = [];
var audioElement;

function Audio() {
  this.currentlyPlaying; // Property to store the currently playing track (initially undefined)
  this.audio = document.createElement("audio"); // Creating an HTML audio element using document.createElement

  this.setTrack = function (src) {
    this.audio.src = src; // Set the source of the audio element to the provided src
  };

  this.play = function () {
    this.audio.play();
  };
}