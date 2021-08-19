<?php
    session_start();
    require "./php/functions.php";

    //Sprawdzenie bana
    ban($_SERVER['REMOTE_ADDR']);

    //przekierowanie z index.php jeżeli uzytkownik jest zalogowany
    if ($_SESSION['logged'] === 1) {
        header("Location: welcome.php");
    }

    /*
    // SERWIS
    if ($_SERVER['REMOTE_ADDR'] !== '159.205.47.245') {
    echo "<html><style>body{background-color: #230670; text-align: center; font-size: 18px; color: rgba(240, 246, 255, 0.945);}</style><body><br/>TRWA MODERNIZACJA...<br/>Zapraszamy pozniej! :))</body></html>";
    die();}
    */
?>

<!DOCTYPE html>
<html lang="pl-PL">

<head>
  <? readfile("templates/head.html")?>

  <meta property="og:url"           content="http://www.liga-wiedzy.pl/" />
  <meta property="og:type"          content="website" />
  <meta property="og:title"         content="Liga-wiedzy.pl" />
  <meta property="og:description"   content="Weź udział w maratonie wiedzy o świecie i zmierz się z innymi na liga-wiedzy.pl" />
  <meta property="og:image"         content="http://liga-wiedzy.pl/img/fb_img.jpg" />
</head>

<body>
  <!-- Load Facebook SDK for JavaScript -->
  <div id="fb-root"></div>
  <script>(function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v3.0";
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));</script>

    <? readfile("templates/navbar.html")?>

    <div class = "titles bg">
        <img id="logo" src="./img/logo.png">
        <p class = " main_title enjoy-css">LIGA-WIEDZY.PL</p>
        <p class = "t3">Podejmij wyzwanie i zmierz się z innymi.
        <br>Sprawdź siebie i dowiedz się więcej!</p>
        <!--p id="alert">Trwa modernizacja, pewne funkcje mogą być niedostępne.</p-->
    </div>

        <?php
        if (isset($_SESSION['post_alert'])) {
            echo '<p id="alert">' . $_SESSION['post_alert'] . '</p>';
            unset($_SESSION['post_alert']);
        }
        ?>

    <form name="playerData" method="post" autocomplete = "on" action="<?php echo htmlspecialchars("/php/validation.php")?>">
        <input id="answerIndex" type="text" name="imie" placeholder="nick" <?php if(isset($_SESSION["imie"]))  echo 'value = "' . $_SESSION["imie"] . '"'?>>
        <input id="answerIndex" type="password" name="pass" placeholder="hasło">
        <!--pułapka na bota, id jest sprawdzane (czy istnieje), funkcja w pliku validation-->
        <input id="pid" type="text" name="sec">
        <input type="submit" name="submit" class="play game" value="Zaloguj">
    </form>

    <form action="/new_player.php">
        <input type="submit" name="submit" class="play game" value="Nowy gracz" />
    </form>

    <!-- FB -->
    <div class="facebook">
      <div class="facebook-section">
        <div class="facebook-txt">Odwiedź nas na Facebooku</div>
        <a href="https://www.facebook.com/ligawiedzy/"><img id="fb" border="0" src="img/fl.jpg" width="35" height="35"></a>
      </div>

      <div class="facebook-section">
        <div class="facebook-txt">Poleć znajomym</div>
        <div class="fb-share-button" data-href="http://liga-wiedzy.pl" data-layout="button_count" data-size="large"></div>
      </div>

    </div>

    <!-- cookie alert -->
    <script src="./js/cookieinfo.js"></script>

    <? readfile("templates/footer.html")?>
    
</body>

<!-- statystyka odwiedzin -->
<?php 
    //odnotowanie wizyty w tabeli traffic
    require "php/cred.php";

    $b = $_SERVER['HTTP_USER_AGENT'];
    $i = $_SERVER['REMOTE_ADDR'];

    // sprawdzenie czy adres juz istnieje
    $check_ip = $db->query("SELECT ip FROM traffic WHERE ip = '$i'");
    $ip_exist = $check_ip -> rowCount();

    if ($ip_exist > 0) {
        // inkrementacja licznika wizyty z tego samego adresu 
        $slect_visits = $db->query("SELECT visits FROM traffic WHERE ip = '$i'");
        $visits = $slect_visits -> fetch(PDO::FETCH_NUM);
        $visits_update = $visits[0] + 1;
        $save_visit = $db->prepare("UPDATE traffic SET visits = '$visits_update' WHERE ip = '$i'");
        $save_visit->execute();
    } else {
    //zapis nowego adresu do tabeli traffic
    $query = $db->prepare('INSERT INTO traffic (ip, visits, browser) VALUES (:ip, :visits ,:br)');
    $query->bindValue(':ip', $i, PDO::PARAM_STR);
    $query->bindValue(':visits', 1, PDO::PARAM_INT);
    $query->bindValue(':br', $b, PDO::PARAM_STR);
    $query->execute();
    }

    //Wyczyszczenie zmiennych sesji
    unset($_SESSION['post_alert']);
    unset($_SESSION["imie"]);
    unset($_SESSION["miejscowosc"]);
    unset($_SESSION["pass"]);
    unset($_SESSION["pass_confirm"]);

?>
</html>
