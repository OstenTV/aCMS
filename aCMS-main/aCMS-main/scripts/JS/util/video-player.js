
// Get elements.
var VideoContaioner = document.getElementById('video-container');
var Video = document.getElementById('video');
var SeekBar = document.getElementById('SeekBar');
var TogglePlay = document.getElementById('TogglePlay');
var CurrentTimeText = document.getElementById('CurrentTimeText');
var DurationText = document.getElementById('DurationText');
var ToggleMute = document.getElementById('ToggleMute');
var VolumeBar = document.getElementById('VolumeBar');
var ToggleFullscreen = document.getElementById('ToggleFullscreen');
var lastDownTarget;

// PlayPause.
Video.addEventListener('click', togglePlay);
TogglePlay.addEventListener('click', togglePlay);
Video.addEventListener('play', updateTogglePlay)
Video.addEventListener('pause', updateTogglePlay)

// SeekBar.
SeekBar.addEventListener('change', seek);
Video.addEventListener('timeupdate', updateSeekBar);
Video.addEventListener('loadedmetadata', updateSeekBar);
Video.addEventListener('durationchange', updateSeekBar);

// Time text.
Video.addEventListener('timeupdate', updateTimeText);
Video.addEventListener('loadedmetadata', updateTimeText);
Video.addEventListener('durationchange', updateTimeText);

// Volume.
ToggleMute.addEventListener('click', toggleMute);
VolumeBar.addEventListener('input', changeVolume);
Video.addEventListener('volumechange', updateToggleMute);

// Fullscreen button.
ToggleFullscreen.addEventListener('click', toggleFullscreen);

// Event for keyboard shortcuts.
document.addEventListener('mousedown', function (e) {
    lastDownTarget = e.target;
}, false);
document.addEventListener('keydown', function (e) {
    if (lastDownTarget == Video) {
        checkKey(e);
    }
}, false);

// Toogle video playback.
function togglePlay() {
    if (Video.paused) {
        Video.play();
    } else {
        Video.pause();
    }
}

// Update the play/pause button.
function updateTogglePlay() {
    if (Video.paused) {
        TogglePlay.innerHTML = 'Play';
    } else {
        TogglePlay.innerHTML = 'Pause';
    }
}

// Seek video.
function seek() {
    var SeekTo = Video.duration * (SeekBar.value / 100);
    Video.currentTime = SeekTo;
}

// Make the SeekBar follow the video.
function updateSeekBar() {
    var nt = Video.currentTime * (100 / Video.duration);
    SeekBar.value = nt;
}

function updateTimeText() {
    var CurrentHours = Math.floor(Video.currentTime / 3600);
    var CurrentMinutes = Math.floor(Video.currentTime / 60 - CurrentHours * 60);
    var CurrentSeconds = Math.floor(Video.currentTime - (CurrentMinutes * 60) - (CurrentHours * 3600));

    var DurationHours = Math.floor(Video.duration / 3600);
    var DurationMinutes = Math.floor(Video.duration / 60 - DurationHours * 60);
    var DurationSeconds = Math.floor(Video.duration - (DurationMinutes * 60) - (DurationHours * 3600));

    if (CurrentMinutes < 10) { CurrentMinutes = "0" + CurrentMinutes }
    if (CurrentSeconds < 10) { CurrentSeconds = "0" + CurrentSeconds }
    if (DurationMinutes < 10) { DurationMinutes = "0" + DurationMinutes }
    if (DurationSeconds < 10) { DurationSeconds = "0" + DurationSeconds }

    if (DurationHours < 1) {
        CurrentTimeText.innerHTML = CurrentMinutes + ":" + CurrentSeconds;
        DurationText.innerHTML = DurationMinutes + ":" + DurationSeconds;
    } else {
        CurrentTimeText.innerHTML = CurrentHours + ":" + CurrentMinutes + ":" + CurrentSeconds;
        DurationText.innerHTML = DurationHours + ":" + DurationMinutes + ":" + DurationSeconds;
    }
}

function changeVolume() {
    
}

function toggleMute() {
    if (Video.muted) {
        Video.muted = false;
    } else {
        Video.muted = true;
    }
}

function updateToggleMute() {
    if (Video.muted) {
        ToggleMute.innerHTML = "Unmute";
    } else {
        ToggleMute.innerHTML = "Mute";
    }
}

function toggleFullscreen() {
    
}

// Listen for keyboard shortcuts.
function checkKey(e) {
    e = e || document.event;

    console.log('KeyCode is: ' + e.keyCode);
    
    if (e.keyCode == '32') {
        togglePlay();
    }
    else if (e.keyCode == '37') {
        video.currentTime -= 5;
    }
    else if (e.keyCode == '39') {
        video.currentTime += 5;
    }
    else if (e.keyCode == '190') {
        video.currentTime += 0.05;
    }
    else if (e.keyCode == '188') {
        video.currentTime -= 0.05;
    }
    else if (e.keyCode == '77') {
        toggleMute();
    }
    else if (e.keyCode == '70') {
        toggleFullscreen();
    }
}