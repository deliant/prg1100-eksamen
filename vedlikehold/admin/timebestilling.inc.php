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
          <span class="glyphicon glyphicon-info-sign icon_info" title="Viser eksisterende timebestillinger i databasen"></span>
        </a>
      </h3>
      <div class="table-responsive">
        <table class="table table-striped">
          <tr>
            <th>Dato</th>
            <th>Tidspunkt</th>
            <th>Behandler</th>
            <th>Pasient</th>
          </tr>
          <?php visTimebestilling(); ?>
        </table>
      </div>
    </div>
    <div id="registrer" class="tab-pane fade">
      <h3>
        Registrer timebestilling
        <a data-toggle="tooltip" class="tooltipLink">
          <span class="glyphicon glyphicon-info-sign icon_info" title="Registrer en ny timebestilling"></span>
        </a>
      </h3>
      <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
        <label>Pasient</label>
        <select name="regPasient">
          <option>-Velg pasient-</option>
          <?php listeboksPasient(); ?>
        </select><br/>
        <label>Behandler</label>
        <select id="regBehandler" name="regBehandler">
          <option>-Velg behandler-</option>
          <?php listeboksBehandler(); ?>
        </select><br/>
        <label>Dato</label><input type="text" id="regDato" name="regDato" onchange="listeboksRegTimebestilling(this.value)" required /><br />
        <label>Tidspunkt</label>
        <select id="regTidspunkt" name="regTidspunkt">
          <option>-Velg behandler og dato-</option>
        </select><br/>
        <label>&nbsp;</label><input class="btn btn-success" type="submit" value="Registrer" name="submitRegTimebestilling">
      </form>
    </div>
    <div id="endre" class="tab-pane fade">
      <h3>
        Endre timebestilling
        <a data-toggle="tooltip" class="tooltipLink">
          <span class="glyphicon glyphicon-info-sign icon_info" title="Endre en eksisterende timebestilling"></span>
        </a>
      </h3>
        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
        <label>Pasient</label>
        <select id="velgPasient" name="velgPasient">
          <option>-Velg pasient-</option>
          <?php listeboksPasient(); ?>
        </select><br/>
        <label>Behandler</label>
        <select id="velgBehandler" name="velgBehandler" onchange="listeboksEndreTimebestilling(this.value)">
          <option>-Velg behandler-</option>
          <?php listeboksBehandler(); ?>
        </select><br/>
        <label>Tidspunkt</label>
        <select id="velgTidspunkt" name="velgTidspunkt" onchange="endreTimebestilling(this.value)">
          <option>-Velg pasient og behandler-</option>
        </select><br/>
      <div id="endring"></div>
    </div>
    <div id="slett" class="tab-pane fade">
      <h3>
        Slett timebestilling
        <a data-toggle="tooltip" class="tooltipLink">
          <span class="glyphicon glyphicon-info-sign icon_info" title="Slett en eksisterende timebestilling"></span>
        </a>
      </h3>
      <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" onsubmit="return confirm('Er du sikker?');>
        <label>Pasient</label>
        <select id="slettPasient" name="slettPasient">
          <option>-Velg pasient-</option>
          <?php listeboksPasient(); ?>
        </select><br/>
        <label>Behandler</label>
        <select id="slettBehandler" name="slettBehandler" onchange="listeboksSlettTimebestilling(this.value)">
          <option>-Velg behandler-</option>
          <?php listeboksBehandler(); ?>
        </select><br/>
        <label>Tidspunkt</label>
        <select name="slettTidspunkt">
          <option>-Velg pasient og behandler-</option>
        </select><br/>
        <label>&nbsp;</label><input class="btn btn-danger" type="submit" value="Slett" name="submitSlettTimebestilling">
      </form>
    </div>
  </div>
<?php
if(isset($_POST["submitRegTimebestilling"])) {
  registrerTimebestilling();
}
if(isset($_POST["submitEndreTimebestilling"])) {
  endreTimebestilling();
}
if(isset($_POST["submitSlettTimebestilling"])) {
  slettTimebestilling();
}
?>