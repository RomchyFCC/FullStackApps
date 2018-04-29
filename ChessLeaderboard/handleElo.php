<head>
		<meta http-equiv="refresh" content="10;URL=http://localhost/chess/">
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

  echo $rowW["elo"], $rowL["elo"];

  #$query = "INSERT INTO `players` (id,number_one,number_two,number_three,number_four,number_five,number_six,number_seven ) VALUES (NULL, ?, ?, ?, ?, ?, ?, ?)";

  $stmt = mysqli_prepare($dbc, $query);

  mysqli_stmt_bind_param($stmt, "iiiiiii", $one, $two, $three, $four, $five, $six, $seven);
  mysqli_stmt_execute($stmt);

  $affected_rows = mysqli_stmt_affected_rows($stmt);
  if ($affected_rows == 2) {
    echo 'numbers updated';

    mysqli_stmt_close($stmt);

    mysqli_close($dbc);
  } else {
    echo 'ERROR MATE' . mysqli_error($dbc);
  }
  
  echo "none";
}


?>