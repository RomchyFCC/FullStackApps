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
        <table id="players">
          <tr>
            <td><b>id</b></td>
            <td><b>Name</b></td>
            <td><b>ELO</b></td>
            <td><b>WIN</b></td>
            <td><b>LOSS</b></td>
            <td><b>DRAW</b></td>
            <td><b>GAMES PLAYED</b></td>
          </tr>';
      
        while ($rowB = mysqli_fetch_array($responseElo)) {
          echo '<tr>
          <td>' . $rowB['id'] . '</td>' .
          '<td>' . $rowB['player_name'] . '</td>' .
          '<td>' . $rowB['elo'] . '</td>' .
          '<td>' . $rowB['win'] . '</td>' .
          '<td>' . $rowB['loss'] . '</td>' .
          '<td>' . $rowB['draw'] . '</td>' .
          '<td>' . $rowB['games_played'] . '</td>';
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
        <form action="./handlePlayer.php" method="post">
          <span>Player Name:</span>
          <br />
          <input id="newPlayer" type="text" name="player">
          <input id="newPlayBut" type="submit" name="submit" value="Enter new player">
        </form>
        <form action="./handleElo.php" method="post">
          <span>Select Players</span>
          <br />
          <span>Winner: </span>
          <select required id="selectionOne" name="winner">
            
          </select>
          <br />
          <span>VS</span>
          <br />
          <span>Loser: </span>
          <select required id="selectionTwo" name="loser">
            
          </select>
          <br />
          <select id="game" name="game">
            <option value="win">WIN</option>
            <option value="draw">DRAW</option>
          </select>
          <input id="gameButton" type="submit" name="submit" value="Submit winner">
        </form>
      </div>
    </div>
  <script src="./script.js"></script>
</body>