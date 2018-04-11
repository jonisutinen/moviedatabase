<?php
include('head.php');
?>

<div class="container">
  <h1 class="title">
    <?php
    $id = $_GET['id'];
    $servername = "localhost";
    $username = "parityo";
    $password = "MagicMike";
    $dbname = "moviedb";

    $conn = mysqli_connect($servername, $username, $password, $dbname);
    if (!$conn) {
      die("Connection failed: " . mysqli_connect_error());
    }

    $sql = "SELECT Elokuva_nimi FROM Elokuva WHERE Elokuva_id = $id";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    echo $row['Elokuva_nimi'];

    mysqli_close($conn);
    ?>
  </h1>
  <h3 class="henkilot">Henkilöt ja roolit:</h3>
  <table class="table table-striped table-hover table-bordered">
    <thead class="thead-dark">
      <tr>
        <th>Nimi</th>
        <th>Rooli</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      <?php
      $id = $_GET['id'];

      include 'includes/dbconn.inc.php';

      if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
      }

      $sql1 = "CREATE OR REPLACE VIEW henkiloview AS
      SELECT Elokuva_id, Henkilo.Henkilo_id AS Henkilo_id, Rooli.Rooli_id AS Rooli_id, Henkilo.Henkilo_nimi AS Nimi, Rooli.Rooli_nimi AS Rooli
      FROM Elokuva
      INNER JOIN Elokuva_has_Henkilo_and_Rooli ON Elokuva.Elokuva_id = Elokuva_has_Henkilo_and_Rooli.Elokuva_Elokuva_id
      INNER JOIN Henkilo ON Elokuva_has_Henkilo_and_Rooli.Henkilo_Henkilo_id = Henkilo.Henkilo_id
      INNER JOIN Rooli ON Elokuva_has_Henkilo_and_Rooli.Rooli_Rooli_id = Rooli.Rooli_id

      ORDER BY Elokuva_id, Rooli_nimi DESC
      ";
      $sql2 = "SELECT * FROM henkiloview WHERE Elokuva_id = $id";

      if (mysqli_query($conn, $sql1)) {

      } else {
        echo "ERROR: Could not able to execute $sql1. " . mysqli_error($conn);
      }

      if($result = mysqli_query($conn, $sql2)){
        while($row = mysqli_fetch_array($result)){
          echo "<tr>";
          echo "<td>" . $row['Nimi'] . "</td>";
          echo "<td>" . $row['Rooli'] . "</td>";
          echo "<td><a href='includes/deleteperson.php?id=" . $row['Henkilo_id'] . "&elokuva=" . $row['Elokuva_id'] . "&rooli=" . $row['Rooli_id'] . "'>Poista</a></td>";
          echo "</tr>";
        }
      } else{
        echo "ERROR: Could not able to execute $sql2. " . mysqli_error($conn);
      }

      mysqli_close($conn);
      ?>
    </tbody>
  </table>
  <h3 class="henkilot">Lisää uusi henkilö:</h3>
  <form action="includes/insertperson.php" method="post">
    <div class="form-group row">
      <label for="nimi" class="col-sm-2 col-form-label">Nimi</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" id="nimi" name="nimi" placeholder="Nimi">
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-2 col-form-label">Rooli</label>
      <div class="col-sm-10">
        <?php
        include 'includes/dbconn.inc.php';

        if($conn === false){
          die("ERROR: Could not connect. " . mysqli_connect_error());
        }

        $sql = "SELECT Rooli_id, Rooli_nimi FROM Rooli";
        $result = mysqli_query($conn, $sql);

        echo "<select name='Rooli_rooli_id'>";
        while ($row = mysqli_fetch_array($result)) {
          echo "<option value='" . $row['Rooli_id'] ."'>" . $row['Rooli_nimi'] ."</option>";
        }
        echo "</select>";

        mysqli_close($conn);
        ?>
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-2 col-form-label">Elokuva</label>
      <div class="col-sm-10">
        <?php
        $id = $_GET['id'];

        include 'includes/dbconn.inc.php';

        if($conn === false){
          die("ERROR: Could not connect. " . mysqli_connect_error());
        }

        $sql = "SELECT Elokuva_id, Elokuva_nimi FROM Elokuva WHERE Elokuva_id=$id";
        $result = mysqli_query($conn, $sql);

        echo "<select name='Elokuva_elokuva_id'>";
        while ($row = mysqli_fetch_array($result)) {
          echo "<option value='" . $row['Elokuva_id'] ."'>" . $row['Elokuva_nimi'] ."</option>";
        }
        echo "</select>";

        mysqli_close($conn);
        ?>
      </div>
    </div>
    <div class="form-group row">
      <div class="col-sm-2"></div>
      <div class="col-sm-10">
        <button type="submit" class="btn btn-primary">Lisää</button>
      </div>
    </div>
  </form>
</div>
<?php include('footer.php'); ?>
