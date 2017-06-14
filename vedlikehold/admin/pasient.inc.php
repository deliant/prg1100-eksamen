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

  <div id="validering"></div>
  <div class="tab-content">
    <div id="vis" class="tab-pane fade in active">
      <h3>
        Vis pasienter
        <a data-toggle="tooltip" class="tooltipLink">
          <span class="glyphicon glyphicon-info-sign icon_info" title="Viser eksisterende pasienter i databasen"></span>
        </a>
      </h3>
      <div class="table-responsive">
        <table class="table table-striped">
          <tr>
            <th>Personnr</th>
            <th>Navn</th>
            <th>Fastlege</th>
          </tr>
          <?php visPasient(); ?>
        </table>
      </div>
    </div>
    <div id="registrer" class="tab-pane fade">
      <h3>
        Registrer pasient
        <a data-toggle="tooltip" class="tooltipLink">
          <span class="glyphicon glyphicon-info-sign icon_info" title="Registrer en ny pasient"></span>
        </a>
      </h3>
      <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" onsubmit="return validerPasientRegistrering()">
        <label>Personnr</label><input type="text" id="regPersonnr" name="regPersonnr" required /><br />
        <label>Navn</label><input type="text" id="regNavn" name="regNavn" required /><br />
        <label>Fastlege</label>
        <select name="velgFastlege">
          <?php listeboksBehandler(); ?>
        </select><br/>
        <label>&nbsp;</label><input class="btn btn-success" type="submit" value="Registrer" name="submitRegPasient">
      </form>
    </div>
    <div id="endre" class="tab-pane fade">
      <h3>
        Endre pasient
        <a data-toggle="tooltip" class="tooltipLink">
          <span class="glyphicon glyphicon-info-sign icon_info" title="Endre en eksisterende pasient"></span>
        </a>
      </h3>
      <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
        <label>Pasient</label>
        <select name="velgPasient" onchange="endrePasient(this.value)">
          <option>-Velg pasient-</option>
          <?php listeboksPasient(); ?>
        </select><br/>
      </form>
      <div id="endring"></div>
    </div>
    <div id="slett" class="tab-pane fade">
      <h3>
        Slett pasient
        <a data-toggle="tooltip" class="tooltipLink">
          <span class="glyphicon glyphicon-info-sign icon_info" title="Slett en eksisterende pasient"></span>
        </a>
      </h3>
      <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" onsubmit="return confirm('Er du sikker?');>
        <label>Pasient</label>
        <select name="slettPasient">
          <option value="NULL">-Velg pasient-</option>
          <?php listeboksPasient(); ?>
        </select><br/>
        <label>Slett timebestillinger tilknyttet</label><input type="checkbox" name="checkboxtimebestilling" /><br/>
        <label>&nbsp;</label><input class="btn btn-danger" type="submit" value="Slett" name="submitSlettPasient">
      </form>
    </div>
  </div>
<?php
if(isset($_POST["submitRegPasient"])) {
  registrerPasient();
}
if(isset($_POST["submitEndrePasient"])) {
  endrePasient();
}
if(isset($_POST["submitSlettPasient"])) {
  slettPasient();
}
?>