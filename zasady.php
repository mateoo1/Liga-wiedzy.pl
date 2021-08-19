<?php 
//BAN
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

<div class = "rules bg">
  <h1 class = "subtitle">ZASADY</h1>

  <textarea readonly class="rules-textarea" rows="30">
CEL GRY
Celem gry jest udzielenie odpowiedzi na 500 pytań w jak najmniejszej ilości RUND. Pytania serwowane są graczowi w losowej kolejności. Pytania, na które gracz udzielił prawidłowej odpowiedzi są usuwane z puli natomiast pytania, na które gracz odpowiedział błędnie zadawane są w kolejnych rundach. Gra kończy się w momencie udzielenia odpowiedzi na wszystkie pytania (przyznawany jest Puchar Wiedzy) natomiast pozycja w lidze zależy od zebranej na drodze do pucharu liczby punktów.

RUNDA
W każdej rundzie gracz stara się odpowiedzieć na jak największą ilość pytań. Czas na udzielenie odpowiedzi na jedno pytanie to 20 sekund. Gracz może pomylić się 3 razy w ramach danej rundy (3 szanse). Runda kończy się po wyczerpaniu szans lub po wyczerpaniu puli pytań. W każdej chwili można przerwać rundę, jednak zdobyte punkty przepadną, a te same pytania zostaną zadane ponownie w kolejnych próbach. W ten sposób można rozgrywać treningi wiedzy. Liczba rund możliwych do rozegrania jest nieograniczona i zależy tylko od gracza.

PUNKTY
Za każdą prawidłową odpowiedź gracz otrzymuje 10 punktów. Za każdą zakończoną niepowodzeniem rundę odejmowane jest 30 punktów. 

Przykład:
Gracz odpowiedział na 500 pytań w 20 rundach (19 rund zakończonych niepowodzeniem) czyli:
(500 x 10 pkt) + (19 x -30 pkt) = 4430 pkt

PAUZA
Istnieje możliwość zatrzymania rundy w dowolnym momencie, służy do tego przycisk „PUZA”. Użycie przycisku jest równoznaczne z udzieleniem odpowiedzi na bieżące pytanie. Gra zostaje zatrzymana po weryfikacji odpowiedzi.

ODZNACZENIA
W zależności od postępu gry i jej przebiegu gracz może zdobywać odznaczenia wymienione poniżej.



  </textarea>
</div>

<div>
  <div class="award">
    <img border="0" src="img/awards/puchar_wiedzy.png" alt="!" title="Puchar wiedzy" width="65" height="75"> 
    <br><b> Puchar wiedzy</b> 
    <br>Dla gracza który odpowiedział na wszystkie pytania.
  </div>

  <div class="award">
    <img id="ekspert" border="0" src="img/awards/bezbledny.png" alt="!" title="Wysoka skuteczność" width="55" height="55"> 
    <br><b> Wysoka skuteczność</b> 
    <br>Gracz uzyskał dużą ilość punktów przy małej ilość rozegranych rund.
  </div>

  <div class="award">
    <img id="ekspert" border="0" src="img/awards/zapalony.png" alt="!" title="Zapalony zawodnik" width="50" height="55"> 
    <br><b> Zapalony zawodnik</b> 
    <br>Gracz rozegrał dużą ilośc rund
  </div>

  <div class="award">
    <img border="0" src="img/awards/general_wiedzy.png" alt="******" title="Generał wiedzy" width="50" height="75"> 
    <br><b> Generał wiedzy </b> 
    <br>Nie ma rzeczy której by nie wiedział.  (ukończone co najmniej 75% gry)
  </div>

  <div class="award">
    <img border="0" src="img/awards/erudyta.png" alt="Erudyta" title="Erudyta" width="50" height="75"> 
    <br><b> Erudyta </b> 
    <br>Cięzki do zagięcia, solidna wiedza (>60%)
  </div>

  <div class="award">
    <img border="0" src="img/awards/starszy_obeznany.png" alt="****" title="Starszy obeznany" width="50" height="65"> 
    <br><b> Starszy obeznany </b> 
    <br>Świetne obeznanie w wielu tematach (>45%)
  </div>

  <div class="award">
    <img border="0" src="img/awards/mlodszy_obeznany.png" alt="***" title="Młodszy obeznany" width="50" height="65"> 
    <br><b> Młodszy obeznany </b> 
    <br>Poziom wiedzy zaczyna wzbudzać podziw! (>30%)
  </div>

  <div class="award">
    <img border="0" src="img/awards/wschodzaca_gwiazda.png" alt="**" title="Wschodząca gwiazda" width="50" height="65"> 
    <br><b> Wschodząca gwiazda </b> 
    <br>Dobrze zapowiadający się zawodnik (>10%)
  </div>

  <div class="award">
    <img border="0" src="img/awards/adept_wiedzy.png" alt="*" title="Adept wiedzy" width="55" height="80"> 
    <br><b> Adept </b> 
    <br>Coś tam wie ale przede wszystkim chce pokazać, że stać go na więcej! (<10%)
  </div>

</div>

  <? readfile("templates/footer.html")?>
</body>
</html>