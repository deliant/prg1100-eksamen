<?php
include("libs/timeinndeling.php");
include("libs/listeboks.php");
?>
  <ul class="nav nav-tabs">
    <li class="active"><a data-toggle="tab" href="#vis"><span class="glyphicon glyphminiadjust glyphicon-folder-open"></span>Vis</a></li>
    <li><a data-toggle="tab" href="#registrer"><span class="glyphicon glyphminiadjust glyphicon-file"></span>Registrer</a></li>
    <li><a data-toggle="tab" href="#slett"><span class="glyphicon glyphminiadjust glyphicon-trash"></span>Slett</a></li>
  </ul>

  <div class="tab-content">
    <div id="vis" class="tab-pane fade in active">
      <p id="alert"></p>
      <h3>
        Vis timeinndelinger
        <a data-toggle="tooltip" class="tooltipLink">
          <span class="glyphicon glyphicon-info-sign icon_info" title="Viser eksisterende timeinndelinger i databasen"></span>
        </a>
      </h3>
      <div class="table-responsive">
        <table class="table table-striped">
          <tr>
            <th>Brukernavn</th>
            <th>Ukedag</th>
            <th>Tidspunkt</th>
          </tr>
          <?php visTimeinndeling(); ?>
        </table>
      </div>
    </div>
    <div id="registrer" class="tab-pane fade">
      <h3>
        Registrer timeinndeling
        <a data-toggle="tooltip" class="tooltipLink">
          <span class="glyphicon glyphicon-info-sign icon_info" title="Registrer en ny timeinndeling"></span>
        </a>
      </h3>
      <form method="post" name="regtimeinndeling" action="<?php echo $_SERVER['PHP_SELF'] ?>">
        <label>Brukernavn</label>
        <select name="velgBrukernavn">
          <?php listeboksBehandler(); ?>
        </select><br/>
        <label>Ukedag</label>
        <select name="velgUkedag">
          <option value="Mandag">Mandag</option>
          <option value="Tirsdag">Tirsdag</option>
          <option value="Onsdag">Onsdag</option>
          <option value="Torsdag">Torsdag</option>
          <option value="Fredag">Fredag</option>
        </select><br/>
        <label>Tidspunkt</label><input type="time" id="fratidspunkt" name="fratidspunkt" required />
        <input type="time" id="tiltidspunkt" name="tiltidspunkt" required /><br/>
        <label>&nbsp;</label><input class="btn btn-success" type="submit" value="Registrer" name="submitRegTimeinndeling">
      </form>
    </div>
    <div id="slett" class="tab-pane fade">
      <h3>
        Slett timeinndeling
        <a data-toggle="tooltip" class="tooltipLink">
          <span class="glyphicon glyphicon-info-sign icon_info" title="Slett en eksisterende timeinndeling"></span>
        </a>
      </h3>
      <p>
      <form method="post" name="slettTimeinndeling" action="<?php echo $_SERVER['PHP_SELF'] ?>">
        <label>Behandler</label>
        <select name="velgTimeinndelingBehandler">
          <?php listeboksBehandler(); ?>
        </select><br/>
        <label>Ukedag</label>
        <select name="velgTimeinndelingUkedag">
          <option value="Mandag">Mandag</option>
          <option value="Tirsdag">Tirsdag</option>
          <option value="Onsdag">Onsdag</option>
          <option value="Torsdag">Torsdag</option>
          <option value="Fredag">Fredag</option>
        </select><br/>
        <label>Tidspunkt</label><select name="velgTimeinndelingTidspunkt" id="velgTimeinndelingTidspunkt">
          <?php listeboksTimeinndeling(); ?>
        </select><br/>
        <label>&nbsp;</label><input class="btn btn-default" type="submit" value="Søk" name="submitSokTimeinndeling"><input class="btn btn-danger" type="submit" value="Slett" name="submitSlettTimeinndeling">
      </form>
      </p>
    </div>
  </div>
  <div id="endring"></div>
<?php
if(isset($_POST["submitRegTimeinndeling"])) {
  registrerTimeinndeling();
}
if(isset($_POST["submitEndreTimeinndeling"])) {
  endreTimeinndeling();
}
if(isset($_POST["submitSlettTimeinndeling"])) {
  slettTimeinndeling();
}
?>