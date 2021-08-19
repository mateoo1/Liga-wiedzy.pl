<?php header('Content-type: text/html; charset=utf8');
session_start();
require "cred.php";
require "functions.php";

$i = $_SERVER['REMOTE_ADDR'];

//---weryfikacja danych w formularzu---
// 1) czy zminne sa ustawione?
$isset = (isset($_POST["imie"]) && isset($_POST["pass"]) && isset($_POST["pass_confirm"]));

// 2) czy pola nie sa puste?
$empty = (!empty($_POST["imie"]) && !empty($_POST["pass"]) && !empty($_POST["pass_confirm"]));

// 3) czy imię zawiera wulgaryzmy? (hasło może)
$swear = (prevent_swearwords($_POST["imie"]));

// 4) czy zawieraja tylko dozwolone znaki?
$allow_chars = '/^[a-zA-ZąęćżźńłóśĄĆĘŁŃÓŚŹŻ0-9 :,.!().#%@?";\'-]+$/i';
$chars = (preg_match($allow_chars , $_POST["imie"]) && preg_match($allow_chars , $_POST["pass"]) && preg_match($allow_chars , $_POST["pass_confirm"]));

// 5) czy maja mniej niz 20 znakow?
$len = (strlen($_POST["imie"]) <= 20 && strlen($_POST["pass"]) <= 20 && strlen($_POST["pass_confirm"]) <= 20);

// 6) czy dane wpisał bot?
$honeypot = empty($_POST["sec"]);

// 7) czy zawieraja same spacje lub pojedyncze litery? (specjalna funkcja w functions.php)
$empty_2 = empty_test($_POST["imie"]);

//sprawdzenie warunkow
if ($isset && $swear && $chars && $len && $honeypot && $empty_2) {

    //przypisanie zmiennych po pomyslnej walidacji
    $imie = ltrim(rtrim($_POST["imie"]));
    $haslo = $_POST["pass"];
    $haslo_confirm = $_POST["pass_confirm"];

    //SPRAWDZENIE CZY GRACZ (player_name) ISTNIEJE W LIDZE
    $check = $db->query("SELECT player_name FROM league WHERE player_name = '$imie'");
    $is_exist_count = $check -> rowCount();
    $is_exist = $check -> fetch(PDO::FETCH_NUM);

    if ($haslo === $haslo_confirm && $is_exist_count == 0) {

        // nowy gracz - zapis do bazy
        $query = $db->prepare('INSERT INTO league (player_name, player_location, points, attempts, ip, pass) VALUES (:Player_name, :Player_location, :Player_points, :Player_attempt, :Ip, :Player_pass)');
        $query->bindValue(':Player_name', $imie, PDO::PARAM_STR);
        $query->bindValue(':Player_location', "brak", PDO::PARAM_STR);
        $query->bindValue(':Player_points', 0, PDO::PARAM_INT);
        $query->bindValue(':Player_attempt', 0, PDO::PARAM_INT);
        $query->bindValue(':Ip', $i, PDO::PARAM_STR);
        $query->bindValue(':Player_pass', $haslo, PDO::PARAM_STR);
        $query->execute();

        //zapisanie zmiennych sesji i przekierowanie do profilu
        header('Location: ../welcome.php');
        $_SESSION["logged"]  = 1;
        $_SESSION["player_name"] = $imie;

    } else if ($is_exist_count > 0) {

        //komunikat
        $_SESSION["post_alert_2"] = "Istnieje już gracz o nazwie: " . $is_exist[0] . "</br>Spróbuj ponownie. ";

        //zachowanie formularzy
        $_SESSION["imie"] = ltrim(rtrim($_POST["imie"]));
        $_SESSION["pass"] = $haslo;
        $_SESSION["pass_confirm"] = $haslo_confirm;

        //przekierowanie
        header('Location: ../new_player.php');

    } else if ($haslo !== $haslo_confirm) {

        //komunikat
        $_SESSION["post_alert_2"] = "Hasła się nie zgadzają.";

        //zachowanie formularza
        $_SESSION["imie"] = ltrim(rtrim($_POST["imie"]));

        //przekierowanie
        header('Location: ../new_player.php');
    } 

} else {

    //weryfikacja zakonczona niepowodzeniem
    //odnotowanie tego faktu w bazie
    $query_forms = $db->prepare("UPDATE traffic SET forms = 'suspicious behaviour' WHERE ip = '$i'");
    $query_forms->execute();

    //zrzut danych z formularza do pliku
    $czas = date("d-m-y h:i:sa");

    //dodanie wpisu do pliku
    $txt =  "\n" . $czas . "\n" . $_SERVER['REMOTE_ADDR'] . "\n" . "haslo: " . $_POST["pass"] . "\n" . "potwierdz haslo: " . $_POST["pass_confirm"] . "\n" . "Imie: " . $_POST["imie"] . "\n";
    $myfile = file_put_contents('suspicious_behaviour.txt', $txt.PHP_EOL , FILE_APPEND | LOCK_EX);
    $_SESSION["imie"] = ltrim(rtrim($_POST["imie"]));
    $_SESSION["pass"] = $_POST["pass"];
    $_SESSION["pass_confirm"] = $_POST["pass_confirm"];
    $_SESSION["post_alert_2"] = "Pola muszą zawierać od 2 do 20 znaków lub<br> pola są puste albo zwierają wulgaryzmy.";
    header('Location: ../new_player.php');
}
?>