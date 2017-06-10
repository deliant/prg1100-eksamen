<?php
include("libs/behandler.php");
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
      <p id="alert"></p>
      <h3>
        Vis behandlere
        <a data-toggle="tooltip" class="tooltipLink">
          <span class="glyphicon glyphicon-info-sign icon_info" title="Viser eksisterende behandlere i databasen"></span>
        </a>
      </h3>
      <div class="table-responsive">
        <table class="table table-striped">
          <tr>
            <th>Brukernavn</th>
            <th>Bilde</th>
            <th>Navn</th>
            <th>Yrkesgruppe</th>
          </tr>
          <?php visBehandler(); ?>
        </table>
      </div>
    </div>
    <div id="registrer" class="tab-pane fade">
      <h3>
        Registrer behandler
        <a data-toggle="tooltip" class="tooltipLink">
          <span class="glyphicon glyphicon-info-sign icon_info" title="Registrer en ny behandler"></span>
        </a>
      </h3>
      <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
        <label>Brukernavn</label><input type="text" name="regBrukernavn" required /><br />
        <label>Navn</label><input type="text" name="regNavn" required /><br />
        <label>Yrkesgruppe</label>
        <select name="regYrkesgruppenr">
          <option>-Velg yrkesgruppe-</option>
          <?php listeboksYrkesgruppe(); ?>
        </select><br/>
        <label>Bildenr</label>
        <select name="regBildenr">
          <option>-Velg bilde-</option>
          <?php listeboksBilde(); ?>
        </select><br/>
        <label>&nbsp;</label><input class="btn btn-success" type="submit" value="Registrer" name="submitRegBehandler">
      </form>
    </div>
    <div id="endre" class="tab-pane fade">
      <h3>
        Endre behandler
        <a data-toggle="tooltip" class="tooltipLink">
          <span class="glyphicon glyphicon-info-sign icon_info" title="Endre en eksisterende behandler"></span>
        </a>
      </h3>
      <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
        <label>Behandler</label>
        <select name="velgBehandler" id="velgBehandler" onchange="endreBehandler(this.value)">
          <option>-Velg behandler-</option>
          <?php listeboksBehandler(); ?>
        </select><br/>
      </form>
      <div id="endring"></div>
    </div>
    <div id="slett" class="tab-pane fade">
      <h3>
        Slett behandler
        <a data-toggle="tooltip" class="tooltipLink">
          <span class="glyphicon glyphicon-info-sign icon_info" title="Slett en eksisterende behandler"></span>
        </a>
      </h3>
      <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
        <label>Behandler</label>
        <select name="slettBehandler">
          <option>-Velg behandler-</option>
          <?php listeboksBehandler(); ?>
        </select><br/>
        <label>&nbsp;</label><input class="btn btn-danger" type="submit" value="Slett" name="submitSlettBehandler">
      </form>
    </div>
  </div>
<?php
if(isset($_POST["submitRegBehandler"])) {
  registrerBehandler();
}
if(isset($_POST["submitEndreBehandler"])) {
  endreBehandler();
}
if(isset($_POST["submitSlettBehandler"])) {
  slettBehandler();
}
?>