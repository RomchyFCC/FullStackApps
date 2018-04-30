<head>
		<meta http-equiv="refresh" content="0;URL=http://localhost/chess/">
</head>
<?php

if (empty($_POST['winner'])) {
  echo "\n Error: all fields are required";
} else {

  $winner = $_POST['winner'];
  $loser = $_POST['loser'];
  $game = $_POST['game'];

  require_once('../mysqli_connect.php');

  $queryWinner = "SELECT * FROM `players` WHERE player_name = '$winner'";
  $queryLoser = "SELECT * FROM `players` WHERE player_name = '$loser'";

  $responseWinner = @mysqli_query($dbc, $queryWinner);
  $responseLoser = @mysqli_query($dbc, $queryLoser);

  $rowW = mysqli_fetch_array($responseWinner);
  $rowL = mysqli_fetch_array($responseLoser);

  $elo_win = (int)$rowW["elo"];
  $elo_lose = (int)$rowL["elo"];
  $games_win = (int)$rowW["games_played"] + 1;
  $games_lose = (int)$rowL["games_played"] + 1;
  $draws_win = (int)$rowW["draw"] + 1;
  $draws_lose = (int)$rowL["draw"] + 1;
  $wins_win = (int)$rowW["win"] + 1;
  $loss_lose = (int)$rowL["loss"] + 1;

  #calculate new elo
  $elo_win = 10 ** ($elo_win/400);
  $elo_lose = 10 ** ($elo_lose/400);

  $elo_perc_win = $elo_win/($elo_win + $elo_lose);
  $elo_perc_lose = $elo_lose/($elo_win + $elo_lose);

  $resultWin;
  $resultLose;
  if ($game == "draw") {
    $calc_win = 0.5 - $elo_perc_win;
    $calc_lose = 0.5 - $elo_perc_lose;
    $kWin;
    $kLose;
    if ($games_win < 10) {
      $kWin = 64;
    } else {
      $kWin = 32;
    }

    if ($games_lose < 10) {
      $kLose = 64;
    } else {
      $kLose = 32;
    }

    $resultWin = $kWin * $calc_win;
    $resultLose = $kLose * $calc_lose;

  } else {

    $calc_win = 1 - $elo_perc_win;
    $calc_lose = 0 - $elo_perc_lose;
    $kWin;
    $kLose;
    if ($games_win <= 10) {
      $kWin = 64;
    } else {
      $kWin = 32;
    }

    if ($games_lose <= 10) {
      $kLose = 64;
    } else {
      $kLose = 32;
    }

    $resultWin = $kWin * $calc_win;
    $resultLose = $kLose * $calc_lose;
  }

  $newWinElo = round($rowW["elo"] + $resultWin);
  $newLoseElo = round($rowL["elo"] + $resultLose);
  echo "$newWinElo, $newLoseElo";

  $query;
  if ($game == "draw") {
    $query = "UPDATE `players` SET draw = '$draws_win' WHERE player_name = '$winner';";
    $query .= "UPDATE `players` SET games_played = '$games_win' WHERE player_name = '$winner';";
    $query .= "UPDATE `players` SET elo = '$newWinElo' WHERE player_name = '$winner';";
    $query .= "UPDATE `players` SET draw = '$draws_lose' WHERE player_name = '$loser';";
    $query .= "UPDATE `players` SET games_played = '$games_lose' WHERE player_name = '$loser';";
    $query .= "UPDATE `players` SET elo = '$newLoseElo' WHERE player_name = '$loser';";
  } else {
    $query = "UPDATE `players` SET win = '$wins_win' WHERE player_name = '$winner';";
    $query .= "UPDATE `players` SET games_played = '$games_win' WHERE player_name = '$winner';";
    $query .= "UPDATE `players` SET elo = '$newWinElo' WHERE player_name = '$winner';";
    $query .= "UPDATE `players` SET loss = '$loss_lose' WHERE player_name = '$loser';";
    $query .= "UPDATE `players` SET games_played = '$games_lose' WHERE player_name = '$loser';";
    $query .= "UPDATE `players` SET elo = '$newLoseElo' WHERE player_name = '$loser';";
  }

  #$query = "INSERT INTO `players` (id,number_one,number_two,number_three,number_four,number_five,number_six,number_seven ) VALUES (NULL, ?, ?, ?, ?, ?, ?, ?)";
  if(mysqli_multi_query($dbc, $query)) {
    echo "NICE it worked, check db";
  } else {
    echo "Error: " . $query . "<br>" . mysqli_error($dbc);
  }

  mysqli_close($dbc);
}


?>