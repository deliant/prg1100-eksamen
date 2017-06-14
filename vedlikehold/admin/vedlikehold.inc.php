  <ul class="nav nav-tabs">
    <li class="active"><a data-toggle="tab" href="#endre"><span class="glyphicon glyphminiadjust glyphicon-lock"></span>Endre passord</a></li>
    <li><a data-toggle="tab" href="#registrer"><span class="glyphicon glyphminiadjust glyphicon-user"></span>Registrer superbruker</a></li>
  </ul>

  <div id="validering"></div>
  <div class="tab-content">
    <div id="endre" class="tab-pane fade in active">
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
    <div id="registrer" class="tab-pane fade">
      <h3>
        Registrer superbruker
        <a data-toggle="tooltip" class="tooltipLink">
          <span class="glyphicon glyphicon-info-sign icon_info" title="Registrer ny administrator superbruker (høyeste administrator nivå)"></span>
        </a>
      </h3>
      <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" onsubmit="return validerBrukerRegistrering()">
        <label>Brukernavn</label><input type="text" id="regBrukernavn" name="regBrukernavn" required /><br />
        <label>Passord</label><input type="password" name="regPassord" required /><br />
        <label>&nbsp;</label><input class="btn btn-success" type="submit" value="Registrer" name="submitRegBruker"><br /><br />
      </form>
    </div>
  </div>

<?php
include("libs/vedlikehold.php");
if(isset($_POST["submitRegBruker"])) {
  registrerBruker();
}
if(isset($_POST["submitEndrePassord"])) {
  endrePassord();
}
?>