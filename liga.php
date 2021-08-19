<?php 

/*if ($_SERVER['REMOTE_ADDR'] !== '159.205.43.144') {
  echo "<html><style>body{background-color: #230670; text-align: center; font-size: 18px; color: rgba(240, 246, 255, 0.945);}</style><body><br/>TRWA MODERNIZACJA...<br/>Zapraszamy pozniej! :))</body></html>";
  die();
}*/

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

<!--h2 class = "rules rulesHeader">WYNIKI</h2-->
<h1 class = "subtitle">WYNIKI</h1>

<div>
    <table class="liga">
        <tbody>
            <tr>
                <th>Gracz</th>
                <th>Osiągnięcia</th>
                <th>Punkty</th>
            </tr>
            <?php
                draw_table_2();
            ?>
        </tbody>
    </table>
</div>

  <? readfile("templates/footer.html")?>

</body>
</html>