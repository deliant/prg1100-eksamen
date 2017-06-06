<?php
include("libs/timebestilling.php");
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
        Vis timebestillinger
        <a data-toggle="tooltip" class="tooltipLink">
          <span class="glyphicon glyphicon-info-sign icon_info" title="Viser eksisterende behandlere i databasen"></span>
        </a>
      </h3>
      <p>
      <div class="table-responsive">
        <table class="table table-striped">
          <tr>
            <th>Dato</th>
            <th>Tidspunkt</th>
            <th>Behandler</th>
            <th>Pasient</th>
            <th>Endre</th>
            <th>Slett</th>
          </tr>
          <?php visTimebestilling(); ?>
        </table>
      </div>
      </p>
    </div>
    <div id="registrer" class="tab-pane fade">
      <h3>
        Registrer timebestilling
        <a data-toggle="tooltip" class="tooltipLink">
          <span class="glyphicon glyphicon-info-sign icon_info" title="Registrer en ny timebestilling"></span>
        </a>
      </h3>
      <p>
      <form method="post" name="regtimebestilling" action="<?php echo $_SERVER['PHP_SELF'] ?>">
        <label>Dato</label><input type="text" id="regdato" name="regdato" required /><br />
        <label>Tidspunkt</label><input type="text" name="regtidspunkt" required /><br />
        <label>Behandler</label>
        <select name="velgBehandler">
          <?php listeboksBehandler(); ?>
        </select><br/>
        <label>Pasient</label>
        <select name="velgPasient">
          <?php listeboksPasient(); ?>
        </select><br/>
        <label>&nbsp;</label><input class="btn btn-success" type="submit" value="Registrer" name="submitRegTimebestilling">
      </form>
      </p>
    </div>
    <div id="endre" class="tab-pane fade">
      <h3>
        Endre timebestilling
        <a data-toggle="tooltip" class="tooltipLink">
          <span class="glyphicon glyphicon-info-sign icon_info" title="Endre en eksisterende timebestilling"></span>
        </a>
      </h3>
      <p>
      <form method="post" name="endretimebestilling" action="<?php echo $_SERVER['PHP_SELF'] ?>">
        <label>Personnr</label>
        <select name="velgPasient">
          <?php listeboksTimebestilling(); ?>
        </select><br/>
        <label>&nbsp;</label><input class="btn btn-primary" type="submit" value="Velg" name="submitVelgTimebestilling">
      </form>
      </p>
    </div>
    <div id="slett" class="tab-pane fade">
      <h3>
        Slett timebestilling
        <a data-toggle="tooltip" class="tooltipLink">
          <span class="glyphicon glyphicon-info-sign icon_info" title="Slett en eksisterende timebestilling"></span>
        </a>
      </h3>
      <p>
      <form method="post" name="sletttimebestiling" action="<?php echo $_SERVER['PHP_SELF'] ?>">
        <label>Personnr</label>
        <select name="velgTimebestillingSlett">
          <?php listeboksTimebestilling(); ?>
        </select><br/>
        <label>&nbsp;</label><input class="btn btn-danger" type="submit" value="Slett" name="submitSlettTimebestilling">
      </form>
      </p>
    </div>
  </div>
<?php
if(isset($_POST["submitRegTimebestilling"])) {
  registrerTimebestilling();
}
if(isset($_POST["submitVelgTimebestilling"]) || isset($_POST["edit_id"])) {
  velgTimebestilling();
}
if(isset($_POST["submitEndreTimebestilling"])) {
  endreTimebestilling();
}
if(isset($_POST["submitSlettTimebestilling"]) || isset($_POST["delete_id"])) {
  slettTimebestilling();
}
?>