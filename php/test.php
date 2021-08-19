<?php

require "cred.php";

$Player_name = 'rob26son';

//pobranie ilosci pytan
$number_of_questions_query = $db->query("SELECT * FROM questions");
$number_of_questions = $number_of_questions_query -> rowCount();

//wygenerowanie losowego array na podstawie ilosci pytan
$random_array_easy = range(1, 110);
shuffle($random_array_easy);

$random_array_normal = range(111, $number_of_questions);
shuffle($random_array_normal);

$random_array = array_merge($random_array_easy, $random_array_normal);

//pobranie numerow pytan na ktore gracz udzielil prawidlowej odpowiedzi
$answered_by_player_query = $db->query("SELECT passed_questions FROM league WHERE player_name = '$Player_name'");
$answered_by_player = $answered_by_player_query -> fetch(PDO::FETCH_NUM);
//zamiana wyniku na array
$answered_by_player_array = explode(',', $answered_by_player[0]);

//porownanie dwoch tablic i zwrocenie tablicy wynikowej
$not_answered_by_player = array_diff($random_array, $answered_by_player_array);


//Zwrocenie dla AJAX, chyba, że gracz dopowiedział już na wszystkie pytania

    //echo implode(",", $not_answered_by_player);


//echo implode(",", $random_array);

/*
print_r($answered_by_player);

//print_r($answered_by_player_array);

foreach ($not_answered_by_player as $x) {
    echo "<br>" . $x;
}
*/

?>