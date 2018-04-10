<?php
/* Attempt MySQL server connection. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
//$conn = mysqli_connect("localhost", "parityo", "MagicMike", "moviedb");
  include 'dbconn.inc.php';
  // Check connection
  if($conn === false){
      die("ERROR: Could not connect. " . mysqli_connect_error());
  }

  // Escape user inputs for security
  $Elokuva_id = mysqli_real_escape_string($conn, $_REQUEST['Elokuva_id']);
  $Elokuva_julkaisuvuosi = mysqli_real_escape_string($conn, $_REQUEST['Elokuva_julkaisuvuosi']);
  $Elokuva_nimi = mysqli_real_escape_string($conn, $_REQUEST['Elokuva_nimi']);
  $Genre_genre_id = mysqli_real_escape_string($conn, $_REQUEST['Genre_genre_id']);
  $Valmistusmaa_valmistusmaa_id = mysqli_real_escape_string($conn, $_REQUEST['Valmistusmaa_valmistusmaa_id']);
  $IMDB_linkki = mysqli_real_escape_string($conn, $_REQUEST['IMDBlinkki_linkki']);
  $Elokuva_genre = mysqli_real_escape_string($conn, $_REQUEST['Elokuva_genre']);
  $Elokuva_valmistusmaa = mysqli_real_escape_string($conn, $_REQUEST['Elokuva_valmistusmaa']);


  if ($Elokuva != null or $Elokuva_genre != '') {
    $genresql = "INSERT INTO Genre (Genre_id, Genre_nimi) VALUES (null, '$Elokuva_genre')";
    if(mysqli_query($conn, $genresql)){
    } else{
        echo "ERROR: Could not able to execute $genresql. " . mysqli_error($conn);
    }


    $result = mysqli_insert_id($conn);
    $Genre_genre_id = $result;
  }

  if ($Elokuva_valmistusmaa != null or $Elokuva_valmistusmaa != '') {
    $valmistusql = "INSERT INTO Valmistusmaa (Valmistusmaa_id, Valmistusmaa_nimi) VALUES (null, '$Elokuva_valmistusmaa')";
    if(mysqli_query($conn, $valmistusql)){
    } else{
        echo "ERROR: Could not able to execute $valmistusql . " . mysqli_error($conn);
    }
    $result2 = mysqli_insert_id($conn);
    $Valmistusmaa_valmistusmaa_id = $result2;
  }

  // attempt insert query execution
  $sql1 = "INSERT INTO Elokuva (Elokuva_id, Elokuva_julkaisuvuosi, Elokuva_nimi, Genre_Genre_id) VALUES ('$Elokuva_id', '$Elokuva_julkaisuvuosi', '$Elokuva_nimi', '$Genre_genre_id')";
  $sql2 = "INSERT INTO Elokuva_has_Valmistusmaa (Elokuva_Elokuva_id, Valmistusmaa_Valmistusmaa_id) VALUES (LAST_INSERT_ID(), '$Valmistusmaa_valmistusmaa_id')";
  $sql3 = "INSERT INTO IMDblinkki (Elokuva_Elokuva_id, IMDBlinkki_linkki) VALUES (LAST_INSERT_ID(), '$IMDB_linkki')";


  if(mysqli_query($conn, $sql1)){
  } else{
      echo "ERROR: Could not able to execute $sql1. " . mysqli_error();
  }
  //-----------------------------------------------


  if(mysqli_query($conn, $sql2)){
  } else{
      echo "ERROR: Could not able to execute $sql2. " . mysqli_error($conn);
  }

  //----------------------------------------------
   if(mysqli_query($conn, $sql3)){
   } else{
       echo "ERROR: Could not able to execute $sql3. " . mysqli_error($conn);
   }


 //$takaisin = 'index.php';
 //echo "<a href='".$takaisin."'>Takaisin</a>";



// close connection

mysqli_close($conn);
header('Location: ../index.php');
exit;
?>
