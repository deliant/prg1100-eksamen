<?php
include("libs/behandler.php");
include("libs/listeboks.php");
?>
  <ul class="nav nav-tabs">
    <li class="active"><a data-toggle="tab" href="#vis">Vis</a></li>
    <li><a data-toggle="tab" href="#registrer">Registrer</a></li>
    <li><a data-toggle="tab" href="#slett">Slett</a></li>
  </ul>

  <div class="tab-content">
    <div id="vis" class="tab-pane fade in active">
      <p>
      <h3>
        Eksisterende behandlere
        <a data-toggle="tooltip" class="tooltipLink">
          <span class="glyphicon glyphicon-info-sign icon_info" title="Viser eksisterende behandlere i databasen"></span>
        </a>
      </h3>
      <div class="table-responsive">
        <table class="table-striped" width="90%">
          <tr><th>Brukernavn</th><th>Navn</th><th>Yrkesgruppe</th><th>Bildenr</th><th>Rediger / Slett</th></tr>
          <?php visBehandler(); ?>
        </table>
      </div>
      </p>
    </div>
    <div id="registrer" class="tab-pane fade">
      <p>
      <h3>
        Registrer behandler
        <a data-toggle="tooltip" class="tooltipLink">
          <span class="glyphicon glyphicon-info-sign icon_info" title="Registrer en ny behandler"></span>
        </a>
      </h3>
      <form method="post" name="regbehandler" action="">
        <label>Brukernavn</label><input type="text" name="yrkesgruppe" required /><br />
        <label>Navn</label><input type="text" name="yrkesgruppe" required /><br />
        <label>Yrkesgruppe</label>
        <select name="velgYrkesgruppe">
          <?php listeboksYrkesgruppe(); ?>
        </select><br />
        <label>Bildenr</label>
        <select name="velgBildenr">
          <?php listeboksBilde(); ?>
        </select><br />
        <label>&nbsp;</label><input class="btn btn-default" type="submit" value="Registrer behandler" name="submitRegBehandler">
      </form>
      </p>
    </div>
    <div id="slett" class="tab-pane fade">
      <p>
      <h3>
        Slett behandler
        <a data-toggle="tooltip" class="tooltipLink">
          <span class="glyphicon glyphicon-info-sign icon_info" title="Slett en eksisterende behandler"></span>
        </a>
      </h3>
      <form method="post" name="slettbehandler" action="">
        <label>Behandler</label>
        <select name="velgBehandler">
          <?php listeboksBehandler(); ?>
        </select><br />
        <label>&nbsp;</label><input class="btn btn-default" type="submit" value="Slett behandler" name="submitSlettBehandler">
      </form>
      </p>
    </div>
  </div>
<?php
if(isset($_POST["submitRegBehandler"])) {
  registrerBehandler();
}
if(isset($_POST["submitSlettBehandler"])) {
  slettBehandler();
}
if(isset($_POST["delete_id"])) {
  slettBehandlerFraVis();
}
?>