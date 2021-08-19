<?php header('Content-type: text/html; charset=utf8');

// zmienne z XMLHttpRequest
$question_id = $_POST['question_id']; //numer pytania
$column_nr = $_POST['column_nr']; //wybor kolumny (pytanie czy odpowiedz)
$player_answer = $_POST['player_answer']; //odpowiedz gracza
$player_name = $_POST['player_name']; //imie gracza
$allow_chars = "/^[a-zA-ZąęćżźńłóśĄĆĘŁŃÓŚŹŻ0-9 \\- \']+$/"; //dozwolone znaki

// ******************** DEKLARACJA FUNKCJI SPRAWDZAJĄCEJ ODPOWIEDŹ ***************************************************
function verify_answer($pl, $corr){

    $player = strtolower($pl);
    $correct = strtolower($corr);

    $complience = ceil( (similar_text($correct, $player) / strlen($correct) ) * 100 ); 

    //jezeli liczba to musi byc identyczna
    if (is_numeric($correct)) {

        if ($player === $correct) {
            return 1;
        } else {
            return 0;
        }

    //jezeli poprawna odpowiedz jest krotsza niz 4 znaki to musi byc identyczna
    } else if(strlen($correct) < 4) {

        if ($player === $correct) {
            return 1;
        } else {
            return 0;
        }

    // w pozostalych przypadkach wymagana zgodnosc 60%
    } else if ($complience > 60) {
        return 1;
    } else {
        return 0;
    }
}
// ****************************************************************************************************


// weryfikacja danych z formularza
if (is_numeric($question_id) && 
    ($player_answer == "" || preg_match($allow_chars, $player_answer)) && 
    ($column_nr === "question" || $column_nr === "answer")) {
    
    require "cred.php";
    
    // pobranie pytania w celu sprawdzenia odpowiedzi
    $result = $db->query("SELECT question, answer, answer2, calls, answers, mistake FROM questions WHERE id = $question_id");
    $Q = $result->fetch(PDO::FETCH_NUM);

    // połączenie wszystkich elementów w jeden array
    if(empty($Q[2])) {

        $Result = verify_answer($player_answer, $Q[1]);

    } else {

        $merge_variants = explode("|", $Q[2]);
        array_unshift($merge_variants, $Q[1]);

        $foreach_result = 0;

        //iteracja przez array ze sprawdzeniem funkcją verify_answer
        foreach($merge_variants as $element){

        if (verify_answer($player_answer, $element) == 1){
            $foreach_result = $foreach_result + 1;
          } else {
        }
          if($foreach_result > 0) {
            $Result = 1;
          } else {
            $Result = 0;
          }
        }
    }

    // zwrocenie danych dla AJAXa
    if($column_nr == "question") {
        echo $Result . "|" . $Q[0];
    } elseif($column_nr == "answer") {
        echo $Result . "|" . $Q[1];
    } else {
    }

    /* ** AKTUALIZACJA DANYCH W BAZIE **
    - zwiększenie licznka pytania (informacja o tym ile razy pytanie zostało wyświetlone)
    - zapisanie przy graczu numery pytania jakie zostało wyświetlone (numer porządkowy dla odpowiedzi i numer dla tabeli wykorzystywanej przez random_array_generator)
    - zapisanie udzielonej opowiedzi (wlasciwym numerze odpowiedzi oraz w bazie z pytaniami w kolumnie answers w celu analizy)
    - zwiekszenie lcznika blednych odpowiedzi
    */
  
    if ($column_nr == "question") {

        // zwiekszenia licznika wyswietelnia pytania    
        $this_call = $Q[3] + 1;
        $query = $db->prepare("UPDATE questions SET calls = $this_call WHERE id = $question_id");
        $query->execute();
        
        //pobranie informacji o NUMERACH pytań na które odpowiedział gracz
        $ans_query = $db -> query("SELECT ans FROM league WHERE player_name = '$player_name'");
        $ans = $ans_query -> fetch(PDO::FETCH_NUM);

        // przygotowanie zaktualizowanych wpisow
        $ans_update = $ans[0] . " " . $question_id . ")";
        
        //zapisanie informacji o numerach pytan i odpowiedziach jakie udzielił gracz
        $save_ans = $db -> prepare("UPDATE league SET ans = '$ans_update'  WHERE player_name = '$player_name'");
        $save_ans -> execute();
    
    } elseif ($column_nr == "answer") {
        if ($player_answer == "") {
            $player_answer_db = "empty";
        } else {
            $player_answer_db = $player_answer;
        }
        
        //zapisanie ODPOWIEDZI gracza w tabeli questions (answers) w celu analizy jakich odpowiedzi udzielają gracze
        $this_answer = $Q[4] . "|" . $player_answer_db;
        $query = $db->prepare("UPDATE questions SET answers = '$this_answer' WHERE id = $question_id");
        $query->execute();

        //przypisanie ODPOWIEDZI do gracza w tabeli league (działa tylko w ramach sesji)
        $ans_query = $db -> query("SELECT ans FROM league WHERE player_name = '$player_name'");
        $ans = $ans_query -> fetch(PDO::FETCH_NUM);
        $ans_update = $ans[0] . $player_answer;

        $save_ans = $db -> prepare("UPDATE league SET ans = '$ans_update' WHERE player_name = '$player_name'");
        $save_ans -> execute();

        //zliczanie blednych odpowiedzi w kolumnie mistake tabeli questions
        if ($Result === 0) {

            $x = $Q[5] + 1;
    
            $learn = $db->query("UPDATE questions SET mistake = $x WHERE id = $question_id");
            $learn->execute();
    
        } else {
        }
    }

} else {
    $question_id = null;
    $column_nr = null;
    $player_answer = null;
}

?>