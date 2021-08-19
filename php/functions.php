<?php

//Sprawdza czy adres IP jest na liście banów
function ban($ip) {
    require "cred.php";
    $lista_banow = $db->query("SELECT * FROM bany");
    $bans = $lista_banow -> fetch(PDO::FETCH_NUM);

    if (empty($bans)) {

        return "";

    } else {

        foreach($bans as $address) {

            if(strpos($ip, $address) === 0) {
                echo "<html><style>body{background-color: #230670; text-align: center; font-size: 18px; color: rgba(240, 246, 255, 0.945);}</style><body><br/>DOSTEP ZABLOKOWANY<br/>Aby poznac powod skontaktuj sie z nami na Facebooku.</body></html>";
                die();

            } else {

            }
        }
    }
}


//Sprawdza czy gracz jest zalogowany
function redirect() {
    if ($_SESSION["logged"] !== 1) {
        header("Location: ../index.php");
        $_SESSION['post_alert'] = "Musisz się zalogować!";
    }
}

//zwraca false jezeli wykryje wyrazenie podobne do wulgaryzmu. Używana przy validacji rejestracji.
function prevent_swearwords ($word) {
    $swearwords = array("kurw","huj","chuj","erdol","<", ">");
    $word = strtolower($word);
    $check = array();
    foreach($swearwords as $element) {
      if (strpos($word, $element) !== false) {
        array_push($check, true);
      } else {
        // do nothing
      }
    }
    if (count($check) === 0) {
      return true;
    } else {
      return false;
    }
  }



function empty_test($string_to_test) {
    /*
    Funkcja do sprawdzania formularza, zwraca FALSE jeżeli zawiera:
    - tylko spacje
    - pojedynczy znak
    - pojedynczy znak ze spacjami
    - tylko liczbę
    */

    $alfabet = "/^[a-zA-ZąęćżźńłóśĄĆĘŁŃÓŚŹŻ0-9\\-\']+$/";
    $is_empty = 0;
    $string_to_test_array = array();
    foreach (str_split($string_to_test) as $char) {
        if($char === " ") {
            
            array_push($string_to_test_array, $char);
        }
    }

    $inne_array = array();
    foreach (str_split($string_to_test) as $char) {
        if(preg_match($alfabet , $char) == true) {
            array_push($inne_array, $char);
        }
    }

    if (count($string_to_test_array) > 0 && count($inne_array) == 0) {
        $is_empty = 1;
    } elseif (empty($string_to_test)) {
        $is_empty = 1; 
	} elseif (is_numeric($string_to_test)) {
		$is_empty = 1; 
    } else {
        $is_empty = 0;    
    }
    if($is_empty == 1 || count($inne_array) < 2) {
        return FALSE;
    } else {
        return TRUE;
    }
}


function isrepeated($s) {
    $s_array = str_split($s);
    if (strlen($s) > 2) {
        if ($s_array[0] === $s_array[1] && $s_array[1] === $s_array[2]) {
       return TRUE;
        } else {
        return FALSE;
    } 
    } else {
        return FALSE;
    }
}

function draw_table($maximum_points, $minimum_points){

    require "cred.php";
    $league_results = $db->query("SELECT player_name, points FROM league WHERE points > $minimum_points AND points < $maximum_points ORDER BY points DESC");
    $count = $league_results -> rowCount();

    for($i = 0; $i < $count; $i++) {
        $row = $league_results->fetch(PDO::FETCH_ASSOC);  

            echo '<tr class = "firsten">';
            echo '<td>' . $row['player_name'] . '</td>'; 
            echo '<td>' . $row['points'] . '</td>';
            echo '</tr>';
    }
}

function draw_table_2() {
    require "cred.php";
    require "player_class.php";

    $Player_query = $db->query("SELECT player_name FROM league WHERE points > 0 ORDER BY points DESC");
    $count = $Player_query->rowCount();


    for ($i=0; $i < $count; $i++) {

        $Player = $Player_query -> fetch(PDO::FETCH_ASSOC);
        $x = new member($Player['player_name']);

        echo '<tr>';
        echo '<td>' . $x->member_name . '</td>';
        echo '<td>';
        foreach ($x->member_achievments as $star) {
            echo $star;
        }
        echo '</td>';
        echo '<td>' . $x->member_points . '</td>';              
        echo '</tr>';
    }
}

// funkcja tworzy widok profilu gracza (wykorzystuje klase member)
function player_profile($player_name) {

    require "player_class.php";
    require "cred.php";

    // zliczenie ilosci pytan w bazie
    $questions_table_query = $db->query("SELECT * FROM questions");
    $count_questions = $questions_table_query->rowCount();

    $Gracz = new member($player_name);
    echo '<p class = "profile-name">' . $Gracz->member_name . '</br>';
    foreach ($Gracz->member_achievments as $star) {
        echo $star;
    }
    echo '<p class="profile-section"> Punkty: ' . $Gracz->member_points;
    echo '<p class="profile-section"> Rundy: ' . $Gracz->member_attempts;
    echo '<p class="profile-section"> Pytania: ' . $Gracz->count_of_member_passed_questions . " z " . $Gracz->number_of_questions;
    echo $Gracz->puchar_wiedzy;
}


?>