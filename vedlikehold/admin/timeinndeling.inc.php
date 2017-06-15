<?php
include("libs/timeinndeling.php");
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
            <th>Behandler</th>
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
      <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" onsubmit="return validerTimeinndelingRegistrering()">
        <label>Brukernavn</label>
        <select name="regBrukernavn">
          <?php listeboksBehandler(); ?>
        </select><br/>
        <label>Ukedag</label>
        <select name="regUkedag">
          <option value="NULL">-Velg ukedag-</option>
          <option value="Mandag">Mandag</option>
          <option value="Tirsdag">Tirsdag</option>
          <option value="Onsdag">Onsdag</option>
          <option value="Torsdag">Torsdag</option>
          <option value="Fredag">Fredag</option>
        </select><br/>
        <label>Tidspunkt</label><input type="time" id="regFraTidspunkt" name="regFraTidspunkt" required />
        <input type="time" id="regTilTidspunkt" name="regTilTidspunkt" required /><br/>
        <label>Registrer i bulk <a><span class="glyphicon glyphicon-info-sign icon_info" title="Registrer timeinndeling i bulk, registrerer kun valg av time i tidspunkt (f.ex fra 8-12)"></span></a>
        </label><input type="checkbox" name="checkboxbulk" onchange="visCheckboxTimeinndeling()" /><br/>
        <div id="regskjult"></div>
        <label>&nbsp;</label><input class="btn btn-success" type="submit" value="Registrer" name="submitRegTimeinndeling">
      </form>
    </div>
    <div id="endre" class="tab-pane fade">
      <h3>
        Endre timeinndeling
        <a data-toggle="tooltip" class="tooltipLink">
          <span class="glyphicon glyphicon-info-sign icon_info" title="Endre en eksisterende timeinndeling"></span>
        </a>
      </h3>
      <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
        <label>Behandler</label>
        <select id="velgBehandler" name="velgBehandler">
          <option>-Velg behandler-</option>
          <?php listeboksBehandler(); ?>
        </select><br/>
        <label>Ukedag</label>
        <select id="velgUkedag" name="velgUkedag" onchange="listeboksEndreTimeinndeling(this.value)">
          <option>-Velg ukedag-</option>
          <option value="Mandag">Mandag</option>
          <option value="Tirsdag">Tirsdag</option>
          <option value="Onsdag">Onsdag</option>
          <option value="Torsdag">Torsdag</option>
          <option value="Fredag">Fredag</option>
        </select><br/>
        <label>Tidspunkt</label>
        <select id="velgTidspunkt" name="velgTidspunkt" onchange="endreTimeinndeling(this.value)">
          <option>-Velg behandler og ukedag-</option>
        </select><br/>
      <div id="endring"></div>
    </div>
    <div id="slett" class="tab-pane fade">
      <h3>
        Slett timeinndeling
        <a data-toggle="tooltip" class="tooltipLink">
          <span class="glyphicon glyphicon-info-sign icon_info" title="Slett en eksisterende timeinndeling"></span>
        </a>
      </h3>
      <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" onsubmit="return slett_confirm()">
        <label>Behandler</label>
        <select id="slettBehandler" name="slettBehandler">
          <option value="NULL">-Velg behandler-</option>
          <?php listeboksBehandler(); ?>
        </select><br/>
        <label>Ukedag</label>
        <select id="slettUkedag" name="slettUkedag" onchange="listeboksSlettTimeinndeling(this.value)">
          <option value="NULL">-Velg ukedag-</option>
          <option value="Mandag">Mandag</option>
          <option value="Tirsdag">Tirsdag</option>
          <option value="Onsdag">Onsdag</option>
          <option value="Torsdag">Torsdag</option>
          <option value="Fredag">Fredag</option>
        </select><br/>
        <label>Tidspunkt</label>
        <select id="slettTidspunkt" name="slettTidspunkt">
          <option>-Velg behandler og ukedag-</option>
        </select><br/>
        <label>Slett i bulk <a><span class="glyphicon glyphicon-info-sign icon_info" title="Slett timeinndeling i bulk per dag, velg behandler og ukedag"></span></a>
        </label><input type="checkbox" name="checkboxslettbulk" /><br/>
        <label>&nbsp;</label><input class="btn btn-danger" type="submit" value="Slett" name="submitSlettTimeinndeling">
      </form>
    </div>
  </div>
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