<?php

require "php/functions.php";
ban($_SERVER['REMOTE_ADDR']);

?>

<!DOCTYPE html>
<html lang="pl-PL">

<head>
  <? readfile("templates/head.html")?>
</head>

<body>

  <? readfile("templates/navbar.html")?>

<h1 class = "subtitle">O PROJEKCIE</h1>

<div class = "project bg">
Liga-wiedzy.pl jest niekomercyjnym projektem, którego celem jest dostarczenie rozrywki każdemu kto chciałby sprawdzić się odpowiadając na pytania z wiedzy ogólnej, ale nie tylko. Po każdej błędnej odpowiedzi gracz otrzymuje jednocześnie informację jaka powinna być poprawna odpowiedź na zadane pytanie – to też świetny sposób, aby szybko dowiedzieć się ciekawych rzeczy z każdej dziedziny życia!
</div>
<div class = "project bg">
Przed przystąpieniem do rozgrywki warto zapoznać się z technicznymi wskazówkami jak należy odpowiadać na pytania (dział Zasady). Swoimi wrażeniami i uwagami na temat rozgrywki można podzielić się w dziale Board.
</div>
<div class = "project bg">
Udanej zabawy i powodzenia! :-)

</div>

  <? readfile("templates/footer.html")?>

</body>

</html>