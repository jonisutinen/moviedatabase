<?php
$id = $_GET['id'];
//Connect DB

include 'dbconn.inc.php';
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// sql to delete a record
$sql = "DELETE FROM Elokuva WHERE Elokuva_id = $id";

if (mysqli_query($conn, $sql)) {
    mysqli_close($conn);
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit;
} else {
     echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
}
?>
