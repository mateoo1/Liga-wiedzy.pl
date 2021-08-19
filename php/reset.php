<?php
//resetuje wynik gracza
session_start();
require "cred.php";

//nazwa gracza
$player_name = $_SESSION["player_name"];

//pobranie ilości resetów i zwiększenie o 1
$NumberOfResets_query = $db->query("SELECT reset FROM league WHERE player_name = '$player_name' ");
$NumberOfResets = $NumberOfResets_query -> fetch(PDO::FETCH_NUM);
$NumberOfResets[0] = $NumberOfResets[0] + 1;

//Wyczyszczenie postępu gry dla danego użytkownika
$reset_query = $db -> prepare("UPDATE league SET points = 0, attempts = 0, ans = '', passed_questions = '', reset = '$NumberOfResets[0]' WHERE player_name = '$player_name' ");
$reset_query -> execute();
header("location: ../welcome.php")
?>