<!-- Jumbotron -->
<div class="jumbotron-minside">
  <div class="container bg-jumbo">
    <h1>Min side</h1>
    <form action="" method="post" onsubmit="return validerBrukerInnlogging()">
      <div class="form-group">
        <label>Personnr</label><input type="text" class="form-control" id="personnr" name="personnr" required />
        <label>Passord</label><input type="password" class="form-control" name="passord" required />
      </div>
      <input class="btn btn-success btn-lg" type="submit" name="submitLogin" value="Logg inn &raquo;">
    </form>
    <p>Har du ikke brukerkonto? Registrer deg <a href="#registrer" onclick="ajaxMinsideRegistrering()">her</a></p>
  </div>
</div>

<!-- Columns -->
<div class="cover-bottom">
  <div class="container">
    <div class="bg-bottom" id="ajax">
      <div class="row">
        <div class="col-md-6">
          <h2>Min side</h2>
          <p>Med brukerkonto hos Bjarum Medical kan du enkelt registrere og endre timeavtaler selv på vår kundeportal uten å måtte ringe kontoret</p>
          <p>Registrer deg med personnr og logg inn for å nyte fordelene</p>
        </div>
        <div class="col-md-6">
          <h2>Fordeler</h2>
          <ul class="list-group">
            <li class="list-group-item">Bestill time</li>
            <li class="list-group-item">Vis, endre eller slett timer</li>
            <li class="list-group-item">Se når behandlere er ledig</li>
            <li class="list-group-item">Slipp telefonkø</li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>
<?php
if(isset($_POST["submitLogin"])) {
  include("libs/db.php");
  $personnr = mysqli_real_escape_string($conn, $_POST["personnr"]);
  $passord = mysqli_real_escape_string($conn, $_POST["passord"]);
  if(!sjekkLogin($personnr, $passord)) {
    echo "<div class=\"alert alert-danger\">Feil brukernavn eller passord.</div>\n";
  } else {
    $_SESSION["personnr"] = $personnr;
    echo "<meta http-equiv=\"refresh\" content=\"0;url=minside.php\">\n";
  }

  mysqli_close($conn);
}
?>
