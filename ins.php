<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link href="https://fonts.googleapis.com/css?family=Lato&amp;subset=latin-ext" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Lato|Luckiest+Guy&display=swap" rel="stylesheet">
  <link href = "./css/bootstrap.min.css" type="text/css" rel="stylesheet">
  <link href = "./css/main.css" type="text/css" rel="stylesheet">
  <link href = "./css/font-awesome.min.css" type="text/css" rel="stylesheet">  
</head>

<body>

<div class="topnav">
        <a href="index.php">START</a>
        <a href="liga.php">LIGA</a>
        <a href="zasady.php">ZASADY</a>
        <a href="board.php">BOARD</a>
        <a href="project.php">INFO</a>
    </div>


<br><br>

<?php
require "php/cred.php";

$vi = $db->query("SELECT SUM(visits) FROM traffic");
$visit = $vi->fetch(PDO::FETCH_NUM);
echo "Wyświetleń: " . $visit[0];


$qr = $db->query("SELECT COUNT(DISTINCT ip) FROM traffic");
$ins = $qr->fetch(PDO::FETCH_NUM);
echo "<br/>Odwiedzających: " . $ins[0];

$wrn = $db->query("SELECT COUNT(DISTINCT ip) FROM traffic WHERE forms = 'suspicious behaviour'");
$warns = $wrn->fetch(PDO::FETCH_NUM);
echo "<br/>Odmowy: " . $warns[0];

$qry3 = $db->query("SELECT COUNT(*) FROM league");
$count = $qry3->fetch(PDO::FETCH_NUM);
echo "<br/>Graczy: " . $count[0];

//echo "<br/> Grywalność: ". ceil(($count[0] / $ins[0]) * 100) . "%";
?>

<br/><br/>

<table class="liga">
  <thead>
    <tr>
      <th>MIEJSCE </th>
      <th>GRACZ</th>
      <th>MIEJSCOWOŚĆ</th>
      <th>PUNKTY</th>
      <th>PRÓBY</th>
      <th>DATA</th>
    </tr>
  </thead>
  
  <tbody>
  
  <?php
  require "php/cred.php";

  $league_results = $db->query("SELECT player_name, player_location, points, attempts, date_data FROM league ORDER BY date_data DESC");
  $count = $league_results -> rowCount();

  for($i = 0; $i < $count; $i++) {

    $place = $i + 1;

    $row = $league_results->fetch(PDO::FETCH_ASSOC);

    echo '<tr class = "firsten">';
    echo '<td>' . $place . '</td>';            
    echo '<td>' . $row['player_name'] . '</td>'; 
    echo '<td>' . $row['player_location'] . '</td>';
    echo '<td>' . $row['points'] . '</td>';
    echo '<td>' . $row['attempts'] . '</td>';
    echo '<td>' . $row['date_data'] . '</td>';
    echo '</tr>';

  }
  ?>

  </tbody>

</table>


</body>
</html>