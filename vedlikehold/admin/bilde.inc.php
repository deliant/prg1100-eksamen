<?php
include("libs/bilde.php");
include("libs/listeboks.php");
?>
  <ul class="nav nav-tabs">
    <li class="active"><a data-toggle="tab" href="#vis"><span class="glyphicon glyphminiadjust glyphicon-folder-open"></span>Vis</a></li>
    <li><a data-toggle="tab" href="#registrer"><span class="glyphicon glyphminiadjust glyphicon-file"></span>Registrer</a></li>
    <li><a data-toggle="tab" href="#endre"><span class="glyphicon glyphminiadjust glyphicon-list-alt"></span>Endre</a></li>
    <li><a data-toggle="tab" href="#slett"><span class="glyphicon glyphminiadjust glyphicon-trash"></span>Slett</a></li>
  </ul>

  <div class="tab-content">
    <div id="vis" class="tab-pane fade in active">
      <h3>
        Vis bilder
        <a data-toggle="tooltip" class="tooltipLink">
          <span class="glyphicon glyphicon-info-sign icon_info" title="Viser eksisterende bilder i databasen"></span>
        </a>
      </h3>
      <div class="table-responsive">
        <table class="table table-striped">
          <tr>
            <th>Bilde</th>
            <th>Bildenr</th>
            <th>Beskrivelse</th>
            <th>Opplastingsdato</th>
            <th>Filnavn</th>
          </tr>
          <?php visBilde(); ?>
        </table>
      </div>
    </div>
    <div id="registrer" class="tab-pane fade">
      <h3>
        Registrer bilder
        <a data-toggle="tooltip" class="tooltipLink">
          <span class="glyphicon glyphicon-info-sign icon_info" title="Registrer et ny bilde"></span>
        </a>
      </h3>
      <form action="<?php echo $_SERVER['PHP_SELF'] ?>" enctype="multipart/form-data" method="post"">
        <label>Fil</label><input type="file" name="regFilnavn" required /><br/>
        <label>Beskrivelse</label><input type="text" name="regBeskrivelse" required /><br/>
        <label>&nbsp;</label><input class="btn btn-success" type="submit" value="Registrer" name="submitRegBilde">
      </form>
    </div>
    <div id="endre" class="tab-pane fade">
      <h3>
        Endre bilde
        <a data-toggle="tooltip" class="tooltipLink">
          <span class="glyphicon glyphicon-info-sign icon_info" title="Endre et eksisterende bilde"></span>
        </a>
      </h3>
      <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
        <label>Bilde</label>
        <select name="velgBildenr" onchange="endreBilde(this.value)">
          <option>-Velg bilde-</option>
          <?php listeboksBilde(); ?>
        </select><br/>
      </form>
      <div id="endring"></div>
    </div>
    <div id="slett" class="tab-pane fade">
      <p>
      <h3>
        Slett bilde
        <a data-toggle="tooltip" class="tooltipLink">
          <span class="glyphicon glyphicon-info-sign icon_info" title="Slett et eksisterende bilde"></span>
        </a>
      </h3>
      <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" onsubmit="return confirm('Er du sikker?');>
        <label>Bilde</label>
        <select name="slettBildenr">
          <option value="NULL">-Velg bilde-</option>
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
if(isset($_POST["submitEndreBilde"])) {
  endreBilde();
}
if(isset($_POST["submitSlettBilde"])) {
  slettBilde();
}
?>