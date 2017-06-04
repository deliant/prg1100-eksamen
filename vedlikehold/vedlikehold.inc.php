<p>
<h3>
  Registrer bruker
  <a data-toggle="tooltip" class="tooltipLink">
    <span class="glyphicon glyphicon-info-sign icon_info" title="Registrer ny administrator bruker"></span>
  </a>
</h3>
<form method="post" name="regbruker" action="">
  <label>Brukernavn</label><input type="text" name="brukernavn" required /><br />
  <label>Passord</label><input type="password" name="passord" required /><br />
  <label>&nbsp;</label><input class="btn btn-default" type="submit" value="Registrer bruker" name="submitRegBruker"><br /><br />
</form>
</p>
<p>
<h3>
  Endre passord
  <a data-toggle="tooltip" class="tooltipLink">
    <span class="glyphicon glyphicon-info-sign icon_info" title="Endre passord på din nåværende bruker"></span>
  </a>
</h3>
<form method="post" name="endrebruker" action="">
  <label>Passord</label><input type="password" name="passord" required /><br />
  <label>&nbsp;</label><input class="btn btn-default" type="submit" value="Endre passord" name="submitEndreBruker"><br /><br />
</form>
</p>
<?php
include("libs/bruker.php");
if(isset($_POST['submitRegBruker'])) {
  registrerBruker();
}
?>