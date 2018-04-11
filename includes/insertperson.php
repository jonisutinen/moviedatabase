<?php
include 'dbconn.inc.php';

if($conn === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

$Henkilo_id = mysqli_real_escape_string($conn, $_REQUEST['Henkilo_id']);
$Nimi = mysqli_real_escape_string($conn, $_REQUEST['nimi']);
$Rooli_id = mysqli_real_escape_string($conn, $_REQUEST['Rooli_rooli_id']);
$Elokuva_id = mysqli_real_escape_string($conn, $_REQUEST['Elokuva_elokuva_id']);

$sql11 ="SELECT Henkilo_id FROM Henkilo WHERE Henkilo_nimi = '$Nimi'";
$sql1 = "INSERT INTO Henkilo (Henkilo_id, Henkilo_nimi) VALUES ('$Henkilo_id', '$Nimi')";
$sql2 = "INSERT INTO Elokuva_has_Henkilo_and_Rooli (Elokuva_Elokuva_id, Henkilo_Henkilo_id, Rooli_Rooli_id) VALUES ('$Elokuva_id', LAST_INSERT_ID(), '$Rooli_id')";

if($result = mysqli_query($conn, $sql11)){
  $rowcount = mysqli_num_rows($result);
  echo $rowcount;
  if ($rowcount > 0){
    $row = mysqli_fetch_row($result);
    $id = $row[0];

    $sql22 = "INSERT INTO Elokuva_has_Henkilo_and_Rooli (Elokuva_Elokuva_id, Henkilo_Henkilo_id, Rooli_Rooli_id) VALUES ('$Elokuva_id', '$id', '$Rooli_id')";

    if(mysqli_query($conn, $sql22)){
    } else{
        echo "22ERROR: Could not able to execute $sql22. " . mysqli_error($conn);
    }

  } else {
    if(mysqli_query($conn, $sql1)){
    } else{
        echo "2ERROR: Could not able to execute $sql1. " . mysqli_error($conn);
    }
    if(mysqli_query($conn, $sql2)){
    } else{
        echo "3ERROR: Could not able to execute $sql2. " . mysqli_error($conn);
    }
  }

} else{
    echo "1ERROR: Could not able to execute $sql11. " . mysqli_error($conn);
}

mysqli_close($conn);
header('Location: ' . $_SERVER['HTTP_REFERER']);
exit;
?>
