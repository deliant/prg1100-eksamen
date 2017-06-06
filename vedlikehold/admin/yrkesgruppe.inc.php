<?php
include("libs/yrkesgruppe.php");
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
        Vis yrkesgrupper
        <a data-toggle="tooltip" class="tooltipLink">
          <span class="glyphicon glyphicon-info-sign icon_info" title="Viser eksisterende yrkesgrupper i databasen"></span>
        </a>
      </h3>
      <p>
      <div class="table-responsive">
        <table class="table table-striped">
          <tr>
            <th>Yrkesgruppe</th>
            <th>Slett</th>
          </tr>
          <?php visYrkesgruppe(); ?>
        </table>
      </div>
      </p>
    </div>
    <div id="registrer" class="tab-pane fade">
      <h3>
        Registrer yrkesgruppe
        <a data-toggle="tooltip" class="tooltipLink">
          <span class="glyphicon glyphicon-info-sign icon_info" title="Registrer en ny yrkesgruppe"></span>
        </a>
      </h3>
      <p>
      <form method="post" name="regyrkesgruppe" action="<?php echo $_SERVER['PHP_SELF'] ?>">
        <label>Yrkesgruppe</label><input type="text" name="regyrkesgruppenavn" required /><br />
        <label>&nbsp;</label><input class="btn btn-success" type="submit" value="Registrer" name="submitRegYrkesgruppe">
      </form>
      </p>
    </div>
    <div id="endre" class="tab-pane fade">
      <h3>
        Endre yrkesgruppe
        <a data-toggle="tooltip" class="tooltipLink">
          <span class="glyphicon glyphicon-info-sign icon_info" title="Endre en eksisterende yrkesgruppe"></span>
        </a>
      </h3>
      <p>
      <form method="post" name="endreyrkesgruppe" action="<?php echo $_SERVER['PHP_SELF'] ?>">
        <label>Yrkesgruppe</label>
        <select name="velgYrkesgruppe">
          <?php listeboksYrkesgruppe(); ?>
        </select><br/>
        <label>&nbsp;</label><input class="btn btn-primary" type="submit" value="Velg" name="submitVelgYrkesgruppe">
      </form>
      </p>
    </div>
    <div id="slett" class="tab-pane fade">
      <h3>
        Slett yrkesgruppe
        <a data-toggle="tooltip" class="tooltipLink">
          <span class="glyphicon glyphicon-info-sign icon_info" title="Slett en eksisterende yrkesgruppe"></span>
        </a>
      </h3>
      <p>
      <form method="post" name="slettyrkesgruppe" action="<?php echo $_SERVER['PHP_SELF'] ?>">
        <label>Yrkesgruppe</label>
        <select name="velgYrkesgruppeSlett">
          <?php listeboksYrkesgruppe(); ?>
        </select><br/>
        <label>&nbsp;</label><input class="btn btn-danger" type="submit" value="Slett" name="submitSlettYrkesgruppe">
      </form>
      </p>
    </div>
  </div>
<?php
if(isset($_POST["submitRegYrkesgruppe"])) {
  registrerYrkesgruppe();
}
if(isset($_POST["submitVelgYrkesgruppe"]) || isset($_POST["edit_id"])) {
  velgYrkesgruppe();
}
if(isset($_POST["submitEndreYrkesgruppe"])) {
  endreYrkesgruppe();
}
if(isset($_POST["submitSlettYrkesgruppe"]) || isset($_POST["delete_id"])) {
  slettYrkesgruppe();
}
?>