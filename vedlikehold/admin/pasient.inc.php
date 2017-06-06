<?php
include("libs/pasient.php");
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
        Vis pasienter
        <a data-toggle="tooltip" class="tooltipLink">
          <span class="glyphicon glyphicon-info-sign icon_info" title="Viser eksisterende pasienter i databasen"></span>
        </a>
      </h3>
      <p>
      <div class="table-responsive">
        <table class="table table-striped">
          <tr>
            <th>Personnr</th>
            <th>Navn</th>
            <th>Fastlege</th>
            <th>Endre</th>
            <th>Slett</th>
          </tr>
          <?php visPasient(); ?>
        </table>
      </div>
      </p>
    </div>
    <div id="registrer" class="tab-pane fade">
      <h3>
        Registrer pasient
        <a data-toggle="tooltip" class="tooltipLink">
          <span class="glyphicon glyphicon-info-sign icon_info" title="Registrer en ny pasient"></span>
        </a>
      </h3>
      <p>
      <form method="post" name="regpasient" action="<?php echo $_SERVER['PHP_SELF'] ?>">
        <label>Personnr</label><input type="text" name="regpersonnr" required /><br />
        <label>Navn</label><input type="text" name="regnavn" required /><br />
        <label>Fastlege</label>
        <select name="velgFastlege">
          <?php listeboksBehandler(); ?>
        </select><br/>
        <label>&nbsp;</label><input class="btn btn-success" type="submit" value="Registrer" name="submitRegPasient">
      </form>
      </p>
    </div>
    <div id="endre" class="tab-pane fade">
      <h3>
        Endre pasient
        <a data-toggle="tooltip" class="tooltipLink">
          <span class="glyphicon glyphicon-info-sign icon_info" title="Endre en eksisterende pasient"></span>
        </a>
      </h3>
      <p>
      <form method="post" name="endrepasient" action="<?php echo $_SERVER['PHP_SELF'] ?>">
        <label>Personnr</label>
        <select name="velgPasient">
          <?php listeboksPasient(); ?>
        </select><br/>
        <label>&nbsp;</label><input class="btn btn-primary" type="submit" value="Velg" name="submitVelgPasient">
      </form>
      </p>
    </div>
    <div id="slett" class="tab-pane fade">
      <h3>
        Slett pasient
        <a data-toggle="tooltip" class="tooltipLink">
          <span class="glyphicon glyphicon-info-sign icon_info" title="Slett en eksisterende pasient"></span>
        </a>
      </h3>
      <p>
      <form method="post" name="slettpasient" action="<?php echo $_SERVER['PHP_SELF'] ?>">
        <label>Personnr</label>
        <select name="velgPasientSlett">
          <?php listeboksPasient(); ?>
        </select><br/>
        <label>&nbsp;</label><input class="btn btn-danger" type="submit" value="Slett" name="submitSlettPasient">
      </form>
      </p>
    </div>
  </div>
<?php
if(isset($_POST["submitRegPasient"])) {
  registrerPasient();
}
if(isset($_POST["submitVelgPasient"]) || isset($_POST["edit_id"])) {
  velgPasient();
}
if(isset($_POST["submitEndrePasient"])) {
  endrePasient();
}
if(isset($_POST["submitSlettPasient"]) || isset($_POST["delete_id"])) {
  slettPasient();
}
?>