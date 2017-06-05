<?php
include("libs/bilde.php");
include("libs/listeboks.php");
?>
  <ul class="nav nav-tabs">
    <li class="active"><a data-toggle="tab" href="#vis">Vis</a></li>
    <li><a data-toggle="tab" href="#registrer">Registrer</a></li>
    <li><a data-toggle="tab" href="#endre">Endre</a></li>
    <li><a data-toggle="tab" href="#slett">Slett</a></li>
  </ul>

  <div class="tab-content">
    <div id="vis" class="tab-pane fade in active">
      <p>
      <h3>
        Vis bilder
        <a data-toggle="tooltip" class="tooltipLink">
          <span class="glyphicon glyphicon-info-sign icon_info" title="Viser eksisterende bilder i databasen"></span>
        </a>
      </h3>
      <div class="table-responsive">
        <table class="table table-striped">
          <tr>
            <th>Bildenr</th>
            <th>Opplastingsdato</th>
            <th>Filnavn</th>
            <th>Beskrivelse</th>
            <th>Endre</th>
            <th>Slett</th>
          </tr>
          <?php visBilde(); ?>
        </table>
      </div>
      </p>
    </div>
    <div id="registrer" class="tab-pane fade">
      <p>
      <h3>
        Registrer bilder
        <a data-toggle="tooltip" class="tooltipLink">
          <span class="glyphicon glyphicon-info-sign icon_info" title="Registrer et ny bilde"></span>
        </a>
      </h3>
      <form method="post" name="regbilde" enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF'] ?>">
        <label>Fil</label><input type="file" name="filnavn" required /><br/>
        <label>Beskrivelse</label><input type="text" name="beskrivelse" required /><br/>
        <label>&nbsp;</label><input class="btn btn-success" type="submit" value="Registrer" name="submitRegBilde">
      </form>
      </p>
    </div>
    <div id="endre" class="tab-pane fade">
      <h3>
        Endre bilde
        <a data-toggle="tooltip" class="tooltipLink">
          <span class="glyphicon glyphicon-info-sign icon_info" title="Endre et eksisterende bilde"></span>
        </a>
      </h3>
      <p>
      <form method="post" name="endrebilde" action="<?php echo $_SERVER['PHP_SELF'] ?>">
        <label>Bildenr</label>
        <select name="velgBildenr">
          <?php listeboksBilde(); ?>
        </select><br/>
        <label>&nbsp;</label><input class="btn btn-primary" type="submit" value="Endre" name="submitVelgBilde">
      </form>
      </p>
    </div>
    <div id="slett" class="tab-pane fade">
      <p>
      <h3>
        Slett bilde
        <a data-toggle="tooltip" class="tooltipLink">
          <span class="glyphicon glyphicon-info-sign icon_info" title="Slett et eksisterende bilde"></span>
        </a>
      </h3>
      <form method="post" name="slettbilde" action="<?php echo $_SERVER['PHP_SELF'] ?>">
        <label>Bildenr</label>
        <select name="velgBildenr">
          <?php listeboksBilde(); ?>
        </select><br/>
        <label>&nbsp;</label><input class="btn btn-danger" type="submit" value="Slett" name="submitSlettBilde">
      </form>
      </p>
    </div>
  </div>

<?php
if(isset($_POST["submitRegBilde"])) {
  include("libs/upload.php");
  if($uploadOk == 1) {
    registrerBilde();
  }
}
if(isset($_POST["submitVelgBilde"])) {
  velgBilde();
}
if(isset($_POST["submitSlettBilde"])) {
  slettBilde();
}
if(isset($_POST["edit_id"])) {
  velgBildeFraVis();
}
if(isset($_POST["delete_id"])) {
  slettBildeFraVis();
}
?>