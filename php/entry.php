<?php
require "cred.php";

session_start(); 

function time_diff ($t){
  $entry_time = strtotime($t);
  $this_time = strtotime(date('Y-m-d h:i:s a'));
  $diff = $this_time - $entry_time;

  if ($diff < 600){
    $left = (10 - ceil($diff/60));
    return $left;
  }
}

$aid = $_SESSION["player_id"];
$ip = $_SERVER['REMOTE_ADDR'];

// Warunki do sprawdzania formularza
$isset = (isset($_POST["author"]) && isset($_POST["entry"])); 
$empty = (empty($_POST["author"]) && empty($_POST["entry"])); 
$patt = '/^[a-zA-ZąęćżźńłóśĄĆĘŁŃÓŚŹŻ0-9 :,.!().#%@?";\'-]+$/i';
$match = (preg_match($patt, $_POST["author"]) && preg_match($patt, $_POST["entry"]));
$honeypot = empty($_POST["sec"]);


// Pobranie daty i czasu ostatniego wpisu dla danej sesji
$qry = $db->query("SELECT date FROM board WHERE aid = '$aid'");
$res = $qry->fetch(PDO::FETCH_NUM);

// Sprawdzenie formularza
if ($isset && !$empty && $match && $honeypot && time_diff($res[0]) == 0) {
  
  $author = $_POST["author"];
  $entry = $_POST["entry"];
  
  $query = $db->prepare('INSERT INTO board (name, comment, aid, ip) VALUES (:ar, :ey, :ad, :ip)');
  $query->bindValue(':ar', $author, PDO::PARAM_STR);
  $query->bindValue(':ey', $entry, PDO::PARAM_STR);
  $query->bindValue(':ad', $aid, PDO::PARAM_STR);
  $query->bindValue(':ip', $ip, PDO::PARAM_STR);
  $query->execute();

  $_SESSION["entry_alert"] = "Komentarz dodany.";
  
  header('Location: ../board.php');

} elseif ($isset === false || $empty === true) {

    $_SESSION["entry_alert"] = "Nie wyełniono pól lub użyto niedozwolonych znaków.";
    $_SESSION["author"] = $_POST["author"];
    $_SESSION["entry"] = $_POST["entry"];
    header('Location: ../board.php');

  } elseif($match === false) {

    $_SESSION["entry_alert"] = "Nie wyełniono pól lub użyto niedozwolonych znaków.";
    $_SESSION["author"] = $_POST["author"];
    $_SESSION["entry"] = $_POST["entry"];
    header('Location: ../board.php');

  } elseif (time_diff($res[0]) !== 0) {

    $_SESSION["entry_alert"] = "Mozesz dodać kolejny komentarz za " . time_diff($res[0]) . ":00 min.";
    $_SESSION["author"] = $_POST["author"];
    $_SESSION["entry"] = $_POST["entry"];
    header('Location: ../board.php');

  } else {
    $_SESSION["entry_alert"] = "Wystąpił błąd w trakcie dodawania komenatrza.";
    $_SESSION["author"] = $_POST["author"];
    $_SESSION["entry"] = $_POST["entry"];
    header('Location: ../board.php');
  }

?>
