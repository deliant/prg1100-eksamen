<?php
include("libs/yrkesgruppe.php");
?>
  <p>
  <h3>
    Eksisterende yrkesgrupper
    <a data-toggle="tooltip" class="tooltipLink">
      <span class="glyphicon glyphicon-info-sign icon_info" title="Eksisterende yrkesgrupper i databasen"></span>
    </a>
  </h3>
  <table>
    <?php visYrkesgruppe(); ?>
  </table>
  </p>
<p>
<h3>
  Registrer yrkesgruppe
  <a data-toggle="tooltip" class="tooltipLink">
    <span class="glyphicon glyphicon-info-sign icon_info" title="Registrer en ny yrkesgruppe"></span>
  </a>
</h3>
<form method="post" name="regyrkesgruppe" action="">
  <label>Yrkesgruppe</label><input type="text" name="yrkesgruppe" required /><br />
  <label>&nbsp;</label><input class="btn btn-default" type="submit" value="Registrer yrkesgruppe" name="submitRegYrkesgruppe"><br /><br />
</form>
</p>
<p>
<h3>
  Slett yrkesgruppe
  <a data-toggle="tooltip" class="tooltipLink">
    <span class="glyphicon glyphicon-info-sign icon_info" title="Slett en eksisterende yrkesgruppe"></span>
  </a>
</h3>
<form method="post" name="slettyrkesgruppe" action="">
  <label>Yrkesgruppe</label><select name="velgYrkesgruppe">
  <?php listeboksYrkesgruppe(); ?>
  </select><br />
  <label>&nbsp;</label><input class="btn btn-default" type="submit" value="Slett yrkesgruppe" name="submitSlettYrkesgruppe"><br /><br />
</form>
</p>
<?php
if(isset($_POST['submitRegYrkesgruppe'])) {
  registrerYrkesgruppe();
}
if(isset($_POST['submitSlettYrkesgruppe'])) {
  slettYrkesgruppe();
}
?>