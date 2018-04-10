<?php
/*Just for your server-side code*/
header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html lang="fi">
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <link rel="stylesheet" type="text/css" href="style.css">
  <title>Elokuvatietokanta</title>
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
  <a class="navbar-brand" href="index.php">MovieDB</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
    <div class="navbar-nav">
      <a class="nav-item nav-link active" href="index.php">Kaikki elokuvat<span class="sr-only">(current)</span></a>
      <a class="nav-item nav-link" href="lisaauusi.php">Lisää uusi</a>
    </div>
  </div>
</div>
</nav>

  <div class="container">
    <table class="table table-striped table-hover table-bordered">
      <thead class="thead-dark">
        <tr>
          <th>Elokuva</th>
          <th>Genre</th>
          <th>Julkaisuvuosi</th>
          <th>Valmistusmaa</th>
          <th>IMDb</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <?php

        // Create connection
        //$conn = new mysqli($servername, $username, $password, $dbname);
        include 'includes/dbconn.inc.php';
        // Check connection
        if ($conn->connect_error) {
          die("Connection failed: " . $conn->connect_error . "\n");
        }

        // sql to create table
        $sql1 = "CREATE OR REPLACE VIEW elokuvaview AS
        SELECT Elokuva_id, Elokuva_nimi AS Elokuva, Genre.Genre_nimi AS Genre, Elokuva_julkaisuvuosi AS Julkaisuvuosi, Valmistusmaa.Valmistusmaa_nimi AS Valmistusmaa, IMDblinkki.IMDBlinkki_linkki AS IMDb
        FROM Elokuva

        INNER JOIN Genre ON Elokuva.Genre_Genre_id = Genre.Genre_id

        INNER JOIN Elokuva_has_Valmistusmaa ON Elokuva.Elokuva_id = Elokuva_has_Valmistusmaa.Elokuva_Elokuva_id
        INNER JOIN Valmistusmaa ON Elokuva_has_Valmistusmaa.Valmistusmaa_Valmistusmaa_id = Valmistusmaa.Valmistusmaa_id

        INNER JOIN IMDblinkki ON Elokuva.Elokuva_id = IMDblinkki.Elokuva_Elokuva_id

        ORDER BY Elokuva_nimi


;";
        $sql2 = "SELECT * FROM elokuvaview;";

        if($result = mysqli_query($conn, $sql1)){


        } else{
          echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
        }


        if($result = mysqli_query($conn, $sql2)){

          while($row = mysqli_fetch_array($result)){
            echo "<tr>";
            echo "<td><a href='henkilot.php?id=" . $row['Elokuva_id'] . "'>" . $row['Elokuva'] . "</a></td>";
            echo "<td>" . $row['Genre'] . "</td>";
            echo "<td>" . $row['Julkaisuvuosi'] . "</td>";
            echo "<td>" . $row['Valmistusmaa'] . "</td>";
            echo "<td><a href='" . $row['IMDb'] . "'>Linkki</a></td>";
            echo "<td><a href='delete.php?id=" . $row['Elokuva_id'] . "'>Poista</a></td>";
            echo "</tr>";
          }

        } else{
          echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
        }
        // close connection
        mysqli_close($conn);
        ?>
      </tbody>
    </table>

  </div>

  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>
