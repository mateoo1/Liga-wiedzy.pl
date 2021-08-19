<?php
session_start();
require "php/functions.php";
redirect($_SESSION["logged"]);
?>

<!DOCTYPE html>
<html lang="pl-PL">

<head>
  <? readfile("templates/head.html")?>
</head>

<body>

  <? readfile("templates/navbar.html")?>

    <div class = "titles bg">
    <img id="logo" src="./img/logo.png">
    <p class = "main_title enjoy-css">LIGA-WIEDZY.PL</p>
    <!-- Wygenerowanie profilu gracza -->
    <? player_profile($_SESSION["player_name"]) ?>

</div>

<form action="/game.php">
    <input type="submit" name="submit" class="play game" value="Graj" />
</form>

<form action="/php/logout.php">
    <input type="submit" name="submit" class="play game" value="Wyloguj" />
</form>

<form class="reset-div" action="/php/reset.php">
    <input type="submit" name="submit" class="reset" value="Reset" />
</form>


<? readfile("templates/footer.html")?>

</body>


</html>