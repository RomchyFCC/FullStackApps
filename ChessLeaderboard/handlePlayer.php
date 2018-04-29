<head>
		<meta http-equiv="refresh" content="0;URL=http://localhost/chess/">
</head>
<?php

if (empty($_POST['player'])) {
  echo "\n Error: all fields are required";
} else {

  $player = $_POST['player'];
  $elo = 1200;
  $loss = $win = $draw = $games_played = 0;

  require_once('../mysqli_connect.php');
  $query = "INSERT INTO `players` (player_name) VALUES (?)";

  $stmt = mysqli_prepare($dbc, $query);

  mysqli_stmt_bind_param($stmt, "s", $player);
  mysqli_stmt_execute($stmt);

  $affected_rows = mysqli_stmt_affected_rows($stmt);
  if ($affected_rows == 1) {
    echo 'players updated';

    mysqli_stmt_close($stmt);

    mysqli_close($dbc);
  } else {
    echo 'ERROR MATE' . mysqli_error($dbc);
  }
  
  echo "$player, $elo, $win, $loss, $draw, $games_played";
}


?>