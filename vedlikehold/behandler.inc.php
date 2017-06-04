<?php
include("libs/behandler.php");
include("libs/listeboks.php");
?>
  <p>
  <h3>
    Eksisterende behandlere
    <a data-toggle="tooltip" class="tooltipLink">
      <span class="glyphicon glyphicon-info-sign icon_info" title="Eksisterende behandlere i databasen"></span>
    </a>
  </h3>
  <table>
    <tr><th>Brukernavn</th><th>Navn</th><th>Yrkesgruppe</th><th>Bildenr</th></tr>
    <?php visBehandler(); ?>
  </table><br /><br />
  </p>
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
    <label>&nbsp;</label><input class="btn btn-default" type="submit" value="Registrer behandler" name="submitRegBehandler"><br /><br />
  </form>
  </p>
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
    <label>&nbsp;</label><input class="btn btn-default" type="submit" value="Slett behandler" name="submitSlettBehandler"><br /><br />
  </form>
  </p>
<?php
if(isset($_POST['submitRegBehandler'])) {
  registrerYrkesgruppe();
}
if(isset($_POST['submitSlettBehandler'])) {
  slettYrkesgruppe();
}
?>