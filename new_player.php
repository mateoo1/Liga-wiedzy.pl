<?php 
session_start();

require "php/functions.php";
ban($_SERVER['REMOTE_ADDR']);

?>

<!DOCTYPE html>
<html lang="pl-PL">

<head>
  <? readfile("templates/head.html")?>
</head>

<body>

  <? readfile("templates/navbar.html")?>

<div class = "warning">

<h1 class = "subtitle">NOWY GRACZ</h1>

<br/>Witaj! 
<br> Wprowadź swoją nazwę gracza i hasło aby rozpocząć grę.
<p id="alert"> Zapisz gdzieś swoje hasło ponieważ nie ma możliwości jego odzyskania.</p>

</div>

<?php
  if (isset($_SESSION['post_alert_2'])) {

    echo '<p id="alert">' . $_SESSION['post_alert_2'] . '</p>';
    unset($_SESSION["post_alert_2"]);

  }
?>

<form name="playerData" method="post" autocomplete = "on" action="<?php echo htmlspecialchars("/php/new_player_registration.php")?>">
  <input id="answerIndex" type="text" name="imie" placeholder="nick" <?php if(isset($_SESSION["imie"]))  echo 'value = "' . $_SESSION["imie"] . '"'?>>
  <input id="answerIndex" type="password" name="pass" placeholder="hasło"<?php if(isset($_SESSION["pass"]))  echo 'value = "' . $_SESSION["pass"] . '"'?>>
  <input id="answerIndex" type="password" name="pass_confirm" placeholder="powtórz hasło"<?php if(isset($_SESSION["pass_confirm"]))  echo 'value = "' . $_SESSION["pass_confirm"] . '"'?>>
  <!--pułapka na bota, id jest sprawdzane (czy istnieje) funkcja w pliku game.php-->
  <input id="pid" type="text" name="sec">
  <input type="submit" name="submit" class="play game" value="DALEJ">
</form>

<a href="/index.php"><button type="button" class="play game">COFNIJ</button> </a> 

<? readfile("templates/footer.html")?>

<?
unset($_SESSION["imie"]);
unset($_SESSION["pass"]);
unset($_SESSION["pass_confirm"]);
?>
</body>
</html>