<?php
include('head.php');
?>
<div class="container">
  <h3 class="title">Lisää uusi elokuva:</h3>
  <form action="includes/insert.php" method="post" class="needs-validation" novalidate>

    <div class="form-group row">
      <label for="elokuvannimi" class="col-sm-2 col-form-label">Elokuvan nimi</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" id="elokuvannimi" name="Elokuva_nimi" placeholder="Elokuvan nimi" required>
        <div class="invalid-feedback">
          Anna elokuvan nimi.
        </div>
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-2 col-form-label">Genre</label>
      <div class="col-sm-2" >
        <?php
        /* Attempt MySQL server connection. Assuming you are running MySQL
        server with default setting (user 'root' with no password) */
        include 'includes/dbconn.inc.php';
        // Check connection
        if($conn === false){
          die("ERROR: Could not connect. " . mysqli_connect_error());
        }

        $sql = "SELECT Genre_id, Genre_nimi FROM Genre";
        $result = mysqli_query($conn, $sql);

        echo "<select name='Genre_genre_id' required>";
        echo "<option selected>Valitse</option>";
        while ($row = mysqli_fetch_array($result)) {
          echo "<option value='" . $row['Genre_id'] ."'>" . $row['Genre_nimi'] ."</option>";
        }
        echo "</select>";

        // close connection
        mysqli_close($conn);
        ?>

      </div>
      <div class="col-sm-8">
        <input type="text" class="form-control" id="elokuvagenre" name="Elokuva_genre" placeholder="Muu, mikä?">
      </div>
    </div>
    <div class="form-group row">
      <label for="julkaisuvuosi" class="col-sm-2 col-form-label">Julkaisuvuosi</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" id="julkaisuvuosi" name="Elokuva_julkaisuvuosi" placeholder="Julkaisuvuosi" required>
      </div>
      <div class="invalid-feedback">
        Anna elokuvan julkaisuvuosi.
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-2 col-form-label">Valmistusmaa</label>
      <div class="col-sm-2">
        <?php
        /* Attempt MySQL server connection. Assuming you are running MySQL
        server with default setting (user 'root' with no password) */
        $conn = mysqli_connect("localhost", "parityo", "MagicMike", "moviedb");

        // Check connection
        if($conn === false){
          die("ERROR: Could not connect. " . mysqli_connect_error());
        }

        $sql = "SELECT Valmistusmaa_id, Valmistusmaa_nimi FROM Valmistusmaa";
        $result = mysqli_query($conn, $sql);

        echo "<select name='Valmistusmaa_valmistusmaa_id' required>";
        echo "<option selected>Valitse</option>";
        while ($row = mysqli_fetch_array($result)) {
          echo "<option value='" . $row['Valmistusmaa_id'] ."'>" . $row['Valmistusmaa_nimi'] ."</option>";
        }
        echo "</select>";

        // close connection
        mysqli_close($conn);
        ?>
      </div>
      <div class="col-sm-8">
        <input type="text" class="form-control" id="elokuvavalmistusmaa" name="Elokuva_valmistusmaa" placeholder="Muu, mikä?">
      </div>
    </div>
    <!-- <div class="form-group">
    <label class="sr-only" for="valmistusmaa">Valmistusmaa</label>
    <input type="text" class="form-control" id="valmistusmaa" name="valmistusmaa" placeholder="Valmistusmaa">
  </div> -->
  <div class="form-group row">
    <label for="imdblinkki" class="col-sm-2 col-form-label">IMDb-linkki</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="imdblinkki" name="IMDBlinkki_linkki" placeholder="IMDb-linkki" required>
    </div>
    <div class="invalid-feedback">
      Anna elokuvan IMDb-linkki.
    </div>
  </div>
  <div class="form-group row">
    <div class="col-sm-2"></div>
    <div class="form-check">
      <input class="form-check-input" type="checkbox" value="" id="invalidCheck" required>
      <label class="form-check-label" for="invalidCheck">
        Vakuutan antamani tiedot oikeiksi
      </label>
      <div class="invalid-feedback">
        Sinun täytyy vakuuttaa tietosi oikeiksi
      </div>
    </div>
  </div>
  <div class="form-group row">
    <div class="col-sm-2"></div>
    <div class="col-sm-10">
      <button type="submit" name="submit" class="btn btn-primary">Lisää</button>
    </div>
  </div>
</form>
</div>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script>
// Example starter JavaScript for disabling form submissions if there are invalid fields
(function() {
  'use strict';
  window.addEventListener('load', function() {
    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    var forms = document.getElementsByClassName('needs-validation');
    // Loop over them and prevent submission
    var validation = Array.prototype.filter.call(forms, function(form) {
      form.addEventListener('submit', function(event) {
        if (form.checkValidity() === false) {
          event.preventDefault();
          event.stopPropagation();
        }
        form.classList.add('was-validated');
      }, false);
    });
  }, false);
})();
</script>
<?php
  include('footer.php');
?>
