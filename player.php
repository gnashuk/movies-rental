<!DOCTYPE html> 
<html> 
<body> 

<div style="text-align:center; margin-top: 5vw;"> 
  <h1><?php echo $_GET['data']; ?></h1><br>
  <button onclick="playPause()">Play/Pause</button> 
  <button onclick="makeBig()">Big</button>
  <button onclick="makeSmall()">Small</button>
  <button onclick="makeNormal()">Normal</button>
  <br> 
  <video id="video1" width="840">
<?php
    $title = "movies/".$_GET['data'].".mp4";
    echo "<source src='$title' type='video/mp4'>";
?>
    Your browser does not support HTML5 video.
  </video>
</div> 

<script> 
var myVideo = document.getElementById("video1"); 

function playPause() { 
    if (myVideo.paused) 
        myVideo.play(); 
    else 
        myVideo.pause(); 
} 

function makeBig() { 
    myVideo.width = 1080; 
} 

function makeSmall() { 
    myVideo.width = 420; 
} 

function makeNormal() { 
    myVideo.width = 840; 
} 
</script> 

</body> 
</html>