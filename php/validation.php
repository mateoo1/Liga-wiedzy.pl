<?php
//filter_has_var(INPUT_POST, $var1, $var2); //saprawdza czy zmienne są ustawione
//filter_var($var, FILTER_SANITIZE_SPECIAL_CHARS); //koduje znaki specjalne
session_start();
require "cred.php";
require "functions.php";

$i = $_SERVER['REMOTE_ADDR'];
//warunki przpisane do zmiennych

// 1) czy zminne sa ustawione?
$isset = (isset($_POST["imie"]) && isset($_POST["pass"]));

// 2) czy zawieraja tylko dozwolone znaki?
$allow_chars = '/^[a-zA-ZąęćżźńłóśĄĆĘŁŃÓŚŹŻ0-9 :,.!().#%@?";\'-]+$/i';
$chars = (preg_match($allow_chars , $_POST["imie"]) && preg_match($allow_chars , $_POST["pass"]));

// 3) czy dane wpisał bot?
$honeypot = empty($_POST["sec"]);

//sprawdzenie warunkow

if ($chars && $honeypot && $isset) {

    //przypisanie zmiennych po pomyslnej walidacji
    $imie = ltrim(rtrim($_POST["imie"]));
    $haslo = $_POST["pass"];

    //SPRAWDZENIE CZY GRACZ (player_name) ISTNIEJE W LIDZE oraz pobranie ilosci punktow i rund
    $check = $db->query("SELECT pass, points, attempts FROM league WHERE player_name = '$imie'");
    $is_exist = $check -> rowCount();
    $sql_data = $check -> fetch(PDO::FETCH_NUM);

    if ($is_exist > 0) {
        //weryfikacja hasla

        if($haslo !== $sql_data[0]) {
    
            //hasla nie zgadzają sie - odesłanie do ../index.php
            header('Location: ../index.php');
            $_SESSION["post_alert"] = "Niepoprawne hasło.";

        } else {

            // --- !!! OK !!! --- gracz zweryfikowany - opusc warunki --- !!! OK !!! ---
            header('Location: ../welcome.php');
            $_SESSION["logged"]  = 1;
            $_SESSION["player_name"] = $imie;

            }
    } else {

    //nie istnieje - odesłanie do ../index.php
    header('Location: ../index.php');
    $_SESSION["post_alert"] = "Nie odnaleziono gracza. Przejdź do sekcji Nowy gracz";
    }

} else {

    //weryfikacja zakonczona niepowodzeniem
    //odnotowanie tego faktu w bazie
    $query_forms = $db->prepare("UPDATE traffic SET forms = 'suspicious behaviour' WHERE ip = '$i'");
    $query_forms->execute();

    //nadpisanie zmiennej dla informacji ze uzytkownik pozostawil puste pole i zapis czasu
    if ($_POST["imie"] == "") {$_POST["imie"] = "puste";} 
    if ($_POST["pass"] == "") {$_POST["pass"] = "puste";} 

    $czas = date("d-m-y h:i:sa");
    //dodanie wpisu do pliku
    $txt =  "\n" . $czas . "\n" . $_SERVER['REMOTE_ADDR'] . "\n" . "haslo: " . $_POST["pass"] . "\n" . "Imie: " . $_POST["imie"] . "\n";
    $myfile = file_put_contents('suspicious_behaviour.txt', $txt.PHP_EOL , FILE_APPEND | LOCK_EX);

    //wyczyszczenie "puste" żeby nie wrocily do formularza ../index.php
    unset($_POST["imie"]);
    unset($_POST["pass"]);

    //odesłanie do ../index.php
    header('Location: ../index.php');
    $_SESSION["post_alert"] = "Podaj prawidłowe dane logowania.";
}
?>