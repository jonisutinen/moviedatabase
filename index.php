<?php
include('head.php');
?>
<div class="container">
  <table class="table table-striped table-hover table-bordered table-responsive-sm">
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
      include 'includes/dbconn.inc.php';
      if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error . "\n");
      }

      $sql1 = "CREATE OR REPLACE VIEW elokuvaview AS
      SELECT Elokuva_id, Elokuva_nimi AS Elokuva, Genre.Genre_nimi AS Genre, Elokuva_julkaisuvuosi AS Julkaisuvuosi, Valmistusmaa.Valmistusmaa_nimi AS Valmistusmaa, IMDblinkki.IMDBlinkki_linkki AS IMDb
      FROM Elokuva

      INNER JOIN Genre ON Elokuva.Genre_Genre_id = Genre.Genre_id

      INNER JOIN Elokuva_has_Valmistusmaa ON Elokuva.Elokuva_id = Elokuva_has_Valmistusmaa.Elokuva_Elokuva_id
      INNER JOIN Valmistusmaa ON Elokuva_has_Valmistusmaa.Valmistusmaa_Valmistusmaa_id = Valmistusmaa.Valmistusmaa_id

      INNER JOIN IMDblinkki ON Elokuva.Elokuva_id = IMDblinkki.Elokuva_Elokuva_id

      ORDER BY Elokuva_nimi;";
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
          echo "<td><a href='includes/delete.php?id=" . $row['Elokuva_id'] . "'>Poista</a></td>";
          echo "</tr>";
        }
      } else{
        echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
      }
      mysqli_close($conn);
      ?>
    </tbody>
  </table>
</div>

<?php
  include('footer.php');
?>
