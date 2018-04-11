<?php
include('includes/dbconn.inc.php');
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql1 = "SELECT * FROM Elokuva";

if($result = mysqli_query($conn, $sql1)){
  $rowcount = mysqli_num_rows($result);
  echo $rowcount;
} else{
    echo "1ERROR: Could not able to execute $sql1. " . mysqli_error($conn);
}

?>
