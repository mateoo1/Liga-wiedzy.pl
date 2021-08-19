<?php
session_start(); 
require "php/cred.php";
require "php/functions.php";

if (ban($_SERVER['REMOTE_ADDR']) === TRUE) {
  echo "<html><style>body{background-color: #230670; text-align: center; font-size: 18px; color: rgba(240, 246, 255, 0.945);}</style><body><br/>BRAK DOSTEPU<br/>Aby wyjasnic sytuacje skontaktuj sie z nami na Facebooku.</body></html>";
  die();
}
//nadanie id uzytkownikowi owiedzjącemu stronę na czas trwania sesji
if (!isset($_SESSION["player_id"])) {
  $_SESSION["player_id"] = md5(microtime(true));
}
?>

<!DOCTYPE html>
<html lang="pl-PL">

<head>
  <? readfile("templates/head.html")?>
</head>

<body>

  <? readfile("templates/navbar.html")?>

<h1 class = "subtitle">KOMENTARZE</h1>

<div class = "board-form">
<form name="boardEntry" method="post" action="<?php echo htmlspecialchars("php/entry.php")?>">
  <input class="entry" name="author" type="text" placeholder="autor" <?php if(isset($_SESSION["author"]))  echo 'value = "' . $_SESSION["author"] . '"'?>>
  <textarea id = "textarea" class="board-textarea" name="entry" placeholder="komentarz..."><?php if(isset($_SESSION["entry"]))  echo $_SESSION["entry"]?></textarea>
  <input id="pid" name="sec" type="text" placeholder="autor2">
  <input type="submit" name="submit" class="play save" value="DODAJ">
</form><br>
<span id = "alert"><?php 

if (isset($_SESSION["entry_alert"])) {
  echo $_SESSION["entry_alert"];
  unset($_SESSION["entry_alert"]);
} else {

}

unset($_SESSION["author"]);
unset($_SESSION["entry"]);
?>
</span>
</div>

<div class = "board bg">
  <?php
  require "php/cred.php";
  $entries = $db->query('SELECT name, comment, date FROM board ORDER BY date DESC');
  $count = $entries -> rowCount();

  for($i = 0; $i < $count; $i++) {
    $row = $entries->fetch(PDO::FETCH_ASSOC);            
      echo '<span class = "at">' . $row['name'] . '</span>';
      echo '<span class = "dt">' . $row['date'] . '</span>'; 
      echo '<span class = "et">' . $row['comment'] . '</span>';
  }
  ?>
</div>
  <? readfile("templates/footer.html")?>
</body>

</html>