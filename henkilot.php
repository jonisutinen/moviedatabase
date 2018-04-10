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
    <h1 class="title">
    <?php
      $id = $_GET['id'];
      $servername = "localhost";
      $username = "parityo";
      $password = "MagicMike";
      $dbname = "moviedb";

      // Create connection
      $conn = mysqli_connect($servername, $username, $password, $dbname);
      // Check connection
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
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// sql to delete a record
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
    /* Attempt MySQL server connection. Assuming you are running MySQL
    server with default setting (user 'root' with no password) */
    include 'includes/dbconn.inc.php';

    // Check connection
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

    // close connection
    mysqli_close($conn);
    ?>
  </div>
  </div>
  <div class="form-group row">
    <label class="col-sm-2 col-form-label">Elokuva</label>
    <div class="col-sm-10">
    <?php
    $id = $_GET['id'];
    /* Attempt MySQL server connection. Assuming you are running MySQL
    server with default setting (user 'root' with no password) */
    include 'includes/dbconn.inc.php';

    // Check connection
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

    // close connection
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

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>
