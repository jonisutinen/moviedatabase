<?php
$id = $_GET['id'];
$elokuva = $_GET['elokuva'];
$rooli = $_GET['rooli'];

include 'dbconn.inc.php';
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
echo $id;
echo $elokuva;
echo $rooli;

$sql = "DELETE FROM Elokuva_has_Henkilo_and_Rooli WHERE Elokuva_Elokuva_id = $elokuva AND Henkilo_Henkilo_id = $id AND Rooli_Rooli_id = $rooli";
echo "yes";
if (mysqli_query($conn, $sql)) {
    mysqli_close($conn);
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit;
    echo "yes";
} else {
     echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
}
?>
