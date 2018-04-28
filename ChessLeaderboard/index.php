<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Chess Leaderboard</title>
  <link rel="stylesheet" href="./style.css">
</head>
<?php

require_once('../mysqli_connect.php');

$queryElo = "SELECT * FROM `players`";

$responseElo = @mysqli_query($dbc, $queryElo);

?>
<body>
  <div class="wrapper">
    <div class="table">
      <?php 
      if ($responseElo) {
        echo '
        <table id="tableBalance">
          <tr>
            <td><b>id</b></td>
            <td><b>player</b></td>
            <td><b>ELO</b></td>
          </tr>';
      
        while ($rowB = mysqli_fetch_array($responseElo)) {
          echo '<tr>
          <td>' . $rowB['id'] . '</td>' .
          '<td>' . $rowB['player_name'] . '</td>' .
          '<td>' . $rowB['elo'] . '</td>';
          echo '</tr>';
        }
      
        echo '</table>';
      } else {
      
        echo "Couldn't issue db query" . mysqli_error($dbc);
      
      }
      mysqli_close($dbc);

      ?>
      </div>
      <div class="form">
        <form action="./handlePlayer" method="post">
          <span>Player Name:</span>
          <br />
          <input type="text" name="player">
          <input type="submit" name="submit" value="Enter new player">
        </form>
        <form action="./handleElo" method="post">
          <span>Select Players</span>
          <br />
          <select required>
            <option value="volvo">Volvo</option>
            <option value="saab">Saab</option>
            <option value="opel">Opel</option>
            <option value="audi">Audi</option>
          </select>
          <span>VS</span>
          <select required>
            <option value="volvo">Volvo</option>
            <option value="saab">Saab</option>
            <option value="opel">Opel</option>
            <option value="audi">Audi</option>
          </select>
          <br />
          <span>Select Winner</span>
          <select required>
            <option value="volvo">Volvo</option>
            <option value="saab">Saab</option>
            <option value="opel">Opel</option>
            <option value="audi">Audi</option>
          </select>
          <input type="submit" name="submit" value="Submit winner">
        </form>
      </div>
    </div>
  <script src="./script.js"></script>
</body>