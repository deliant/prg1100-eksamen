<?php
include("libs/vedlikehold.php");
include("libs/listeboks.php");
?>
  <ul class="nav nav-tabs">
    <li class="active"><a data-toggle="tab" href="#endrepassord"><span class="glyphicon glyphminiadjust glyphicon-lock"></span>Endre passord</a></li>
    <li><a data-toggle="tab" href="#vis"><span class="glyphicon glyphminiadjust glyphicon-folder-open"></span>Vis</a></li>
    <li><a data-toggle="tab" href="#registrer"><span class="glyphicon glyphminiadjust glyphicon-file"></span>Registrer</a></li>
    <li><a data-toggle="tab" href="#endre"><span class="glyphicon glyphminiadjust glyphicon-list-alt"></span>Endre</a></li>
    <li><a data-toggle="tab" href="#slett"><span class="glyphicon glyphminiadjust glyphicon-trash"></span>Slett</a></li>
  </ul>

  <div id="validering"></div>
  <div class="tab-content">
    <div id="endrepassord" class="tab-pane fade in active">
      <h3>
        Endre passord
        <a data-toggle="tooltip" class="tooltipLink">
          <span class="glyphicon glyphicon-info-sign icon_info" title="Endre passord på din nåværende bruker"></span>
        </a>
      </h3>
      <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
        <label>Passord</label><input type="password" name="endrePassord" required /><br />
        <label>&nbsp;</label><input class="btn btn-primary" type="submit" value="Endre" name="submitEndrePassord"><br /><br />
      </form>
    </div>
    <div id="vis" class="tab-pane fade">
      <h3>
        Vis brukere
        <a data-toggle="tooltip" class="tooltipLink">
          <span class="glyphicon glyphicon-info-sign icon_info" title="Viser eksisterende brukere i databasen"></span>
        </a>
      </h3>
      <div class="table-responsive">
        <table class="table table-striped">
          <tr>
            <th>Brukernavn</th>
          </tr>
          <?php visBruker(); ?>
        </table>
      </div>
    </div>
    <div id="registrer" class="tab-pane fade">
      <h3>
        Registrer bruker
        <a data-toggle="tooltip" class="tooltipLink">
          <span class="glyphicon glyphicon-info-sign icon_info" title="Registrer ny web bruker"></span>
        </a>
      </h3>
      <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" onsubmit="return validerBrukerRegistrering()">
        <label>Brukernavn</label><input type="text" id="regBrukernavn" name="regBrukernavn" required /><br />
        <label>Passord</label><input type="password" name="regPassord" required /><br />
        <label>&nbsp;</label><input class="btn btn-success" type="submit" value="Registrer" name="submitRegBruker"><br /><br />
      </form>
    </div>
    <div id="endre" class="tab-pane fade">
      <h3>
        Endre bruker
        <a data-toggle="tooltip" class="tooltipLink">
          <span class="glyphicon glyphicon-info-sign icon_info" title="Endre en eksisterende bruker"></span>
        </a>
      </h3>
      <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" onsubmit="return validerBrukerEndring()">
        <label>Bruker</label>
        <select name="velgBruker" id="velgBruker" onchange="endreBruker(this.value)">
          <option value="NULL">-Velg bruker-</option>
          <?php listeboksBruker(); ?>
        </select><br/>
      </form>
      <div id="endring"></div>
    </div>
    <div id="slett" class="tab-pane fade">
      <h3>
        Slett bruker
        <a data-toggle="tooltip" class="tooltipLink">
          <span class="glyphicon glyphicon-info-sign icon_info" title="Slett en eksisterende bruker"></span>
        </a>
      </h3>
      <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" onsubmit="return slett_confirm()">
        <label>Bruker</label>
        <select name="slettBruker">
          <option value="NULL">-Velg bruker-</option>
          <?php listeboksBruker(); ?>
        </select><br/>
        <label>&nbsp;</label><input class="btn btn-danger" type="submit" value="Slett" name="submitSlettBruker">
      </form>
    </div>
  </div>

<?php
include("libs/vedlikehold.php");
if(isset($_POST["submitEndrePassord"])) {
  $brukernavn = mysqli_real_escape_string($conn, $_SESSION["brukernavn"]);
  $passord = mysqli_real_escape_string($conn, $_POST["endrePassord"]);
  endrePassord($brukernavn, $passord);
}
if(isset($_POST["submitRegBruker"])) {
  registrerBruker();
}
if(isset($_POST["submitEndreBruker"])) {
  $brukernavn = mysqli_real_escape_string($conn, $_POST["endringBrukernavn"]);
  $passord = mysqli_real_escape_string($conn, $_POST["endringPassord"]);
  endrePassord($brukernavn, $passord);
}
if(isset($_POST["submitSlettBruker"])) {
  slettBruker();
}
?>