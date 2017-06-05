<?php
include("libs/bilde.php");
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
        Vis bilder
        <a data-toggle="tooltip" class="tooltipLink">
          <span class="glyphicon glyphicon-info-sign icon_info" title="Viser eksisterende yrkesgrupper i databasen"></span>
        </a>
      </h3>
      <div class="table-responsive">
        <table class="table-striped" width="60%">
          <tr><th>Yrkesgruppe</th><th>Slett</th></tr>
          <?php visYrkesgruppe(); ?>
        </table>
      </div>
      </p>
    </div>
    <div id="registrer" class="tab-pane fade">
      <p>
      <h3>
        Registrer bilder
        <a data-toggle="tooltip" class="tooltipLink">
          <span class="glyphicon glyphicon-info-sign icon_info" title="Registrer en ny yrkesgruppe"></span>
        </a>
      </h3>
      <form method="post" name="regbilde" action="<?php echo $_SERVER['PHP_SELF'] ?>">
        <label></label><input type="text" name="yrkesgruppe" required /><br />
        <label>&nbsp;</label><input class="btn btn-default" type="submit" value="Registrer" name="submitRegYrkesgruppe">
      </form>
      </p>
    </div>
    <div id="slett" class="tab-pane fade">
      <p>
      <h3>
        Slett bilde
        <a data-toggle="tooltip" class="tooltipLink">
          <span class="glyphicon glyphicon-info-sign icon_info" title="Slett en eksisterende yrkesgruppe"></span>
        </a>
      </h3>
      <form method="post" name="slettbilde" action="<?php echo $_SERVER['PHP_SELF'] ?>">
        <label>Bildenr</label>
        <select name="velgBildenr">
          <?php listeboksBilde(); ?>
        </select><br/>
        <label>&nbsp;</label><input class="btn btn-default" type="submit" value="Slett" name="submitSlettBilde">
      </form>
      </p>
    </div>
  </div>

<?php
if(isset($_POST["submitRegYrkesgruppe"])) {
  registrerYrkesgruppe();
}
if(isset($_POST["submitSlettYrkesgruppe"])) {
  slettYrkesgruppe();
}
if(isset($_POST["delete_id"])) {
  slettYrkesgruppeFraVis();
}
?>