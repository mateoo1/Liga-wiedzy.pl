<?php header('Content-type: text/html; charset=utf8');
session_start();
require "php/functions.php";
redirect($_SESSION["logged"]);
?>

<!DOCTYPE html>
<html lang="pl-PL">

<head>
  <script type="text/javascript" src="./js/game.js"></script>
  <script type="text/javascript" src="./js/redirect.js"></script>
  <? readfile("templates/head.html")?>
</head>

<body>

<?// readfile("templates/navbar.html")?>

<div id = "panel">

  <div id="lights">
    <div class = "single_3"></div>
    <div class = "single_3"></div>
    <div class = "single_3"></div>
  </div>

  <div class = "playerInfo">
    <b><span id="imie"><?php echo $_SESSION['player_name']?></span></b>
  </div>

  <div class = "playerPanel">
    <div id="corrAn"></div>
    <div id="Pdiv">0</div>
    <div id="timer"></div>
  </div>
</div>

<div id="Qdiv" class="questionAnimate">Wczytywanie...</div>
<input id="answer" type="text" placeholder="naciśnij Enter">
<button id="pause_button" class="play play1 game" onClick="pause(POINTER, ra)">PAUZA </button>
<button id="go_to_profile" class="play play1 game" onclick="window.location.href = '/welcome.php';">WYJŚCIE</button>
<br>
<button id="go_button" class="play play1 game hide" onClick="checkAnswer(POINTER, ra)">ENTER</button>
<button id="play_again" class="play play1 game" onclick="window.location.href = '/game.php';">NOWA RUNDA</button>

<br/><br/><p id="alert"></p>

<p id = "pip"><?php echo $_SERVER['REMOTE_ADDR'] ?></p>

<script>

//ukrycie przycisków
document.getElementById('play_again').hidden = true
document.getElementById('go_button').hidden = true
//document.getElementById('go_to_profile').hidden = true

  var ra = randomArray()
  var POINTER = 0;

  displayQuestion(0, ra)

  var input = document.getElementById("answer");
  
  input.addEventListener("keyup", function(event) {
    event.preventDefault();
      if (event.keyCode === 13) {
      document.getElementById("go_button").click();
    }
  });

</script>
  <? readfile("templates/footer.html")?>
</body>
</html>