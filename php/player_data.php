<?php header('Content-type: text/html; charset=utf8');
require "cred.php";

//przejecie zmiennych z funkcji SSTD()
$Player_name = $_POST["imie"];
$Player_points = $_POST["punkty"];
$Passed_questions = strval($_POST["pytania"]);

//wybranie punktów, prob, numerow pytan
$select_score = $db->query("SELECT points, attempts, passed_questions FROM league WHERE player_name = '$Player_name'");
$score = $select_score -> fetch(PDO::FETCH_NUM);

//dodanie punktow
$Player_points_updated = $score[0] + $Player_points;

//inkrementacja proby gracza
$increase_attempt = $score[1] + 1;

//dodanie numerow pytań
$Passed_questions_updated = $score[2] . "," . $Passed_questions;

//update (punkty, proby, pytania na ktore zostala udzielona prawidlowa odpowiedz) jezeli gracz istnieje (na podstawie name)
if ($Passed_questions == "") {
    // zabezpieczenie przed zapisaniem pustej wartości w kolumnie passed_questions
    $updt2 = $db->prepare("UPDATE league SET points='$Player_points_updated', attempts='$increase_attempt' WHERE player_name = '$Player_name'");
    $updt2->execute();

} else {

    $updt2 = $db->prepare("UPDATE league SET points='$Player_points_updated', attempts='$increase_attempt', passed_questions ='$Passed_questions_updated' WHERE player_name = '$Player_name'");
    $updt2->execute();

}



?>