<?php
$id = $_GET['id'];

include 'dbconn.inc.php';
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "DELETE FROM Elokuva WHERE Elokuva_id = $id";

if (mysqli_query($conn, $sql)) {
    mysqli_close($conn);
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit;
} else {
     echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
}
?>
