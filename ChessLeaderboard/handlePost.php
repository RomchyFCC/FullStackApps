<head>
		<meta http-equiv="refresh" content="1;URL=http://localhost/jackpot/">
</head>
<?php

if (empty($_POST['number_one'])) {
  echo "\n Error: all fields are required";
} else {

  $one = $_POST['number_one'];

  require_once('../mysqli_connect.php');
  $query = "INSERT INTO `numbers` (id,number_one,number_two,number_three,number_four,number_five,number_six,number_seven ) VALUES (NULL, ?, ?, ?, ?, ?, ?, ?)";

  $stmt = mysqli_prepare($dbc, $query);

  mysqli_stmt_bind_param($stmt, "iiiiiii", $one, $two, $three, $four, $five, $six, $seven);
  mysqli_stmt_execute($stmt);

  $affected_rows = mysqli_stmt_affected_rows($stmt);
  if ($affected_rows == 1) {
    echo 'numbers updated';

    mysqli_stmt_close($stmt);

    mysqli_close($dbc);
  } else {
    echo 'ERROR MATE' . mysqli_error($dbc);
  }
  
  echo "$one";
}


?>