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

$queryElo = "SELECT * FROM `players` ORDER BY elo DESC";

$responseElo = @mysqli_query($dbc, $queryElo);

?>
<body>
  <div class="wrapper">
    <div class="table">
      <?php 
      if ($responseElo) {
        echo '
        <h1>Elo Rankings</h1>
        <table id="players">
          <tr>
            <td><b>Rank</b></td>
            <td><b>Name</b></td>
            <td><b>ELO</b></td>
            <td><b>Wins</b></td>
            <td><b>Losses</b></td>
            <td><b>Draws</b></td>
            <td><b>Games Played</b></td>
          </tr>';

        $index = 1;
        while ($rowB = mysqli_fetch_array($responseElo)) {
          echo '<tr>
          <td>' . $index . '</td>' .
          '<td>' . $rowB['player_name'] . '</td>' .
          '<td>' . $rowB['elo'] . '</td>' .
          '<td>' . $rowB['win'] . '</td>' .
          '<td>' . $rowB['loss'] . '</td>' .
          '<td>' . $rowB['draw'] . '</td>' .
          '<td>' . $rowB['games_played'] . '</td>';
          echo '</tr>';
          $index++;
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
          <h2>New Player Name</h2>
          <input id="newPlayer" type="text" name="player">
          <input id="newPlayBut" type="submit" name="submit" value="Enter new player">
        </form>
        <form action="./handleElo.php" method="post">
          <h2>New Match</h2>
          <span>Winner: 
          <select required id="selectionOne" name="winner">
            
          </select></span>
          <span>VS</span>
          <span>Loser: 
          <select required id="selectionTwo" name="loser">
            
          </select></span>
          <span>Match: <select id="game" name="game">
            <option value="win">WIN</option>
            <option value="draw">DRAW</option>
          </select></span>
          <input id="gameButton" type="submit" name="submit" value="Submit result">
        </form>
      </div>
    </div>
  <script src="./script.js"></script>
</body>