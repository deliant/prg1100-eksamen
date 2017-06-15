<?php
function visYrkesgruppe() {
  include("db.php");
  $sql = "SELECT yrkesgruppenavn FROM yrkesgruppe";
  $result = mysqli_query($conn, $sql);

  if(mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
      echo "<tr>\n";
      echo "<td>". htmlspecialchars($row['yrkesgruppenavn']) ."</td>\n";
      echo "</tr>\n";
    }
  } else {
    echo "<tr><td>Ingen yrkesgrupper funnet</td><td>&nbsp;</td></tr>\n";
  }

  mysqli_close($conn);
}

function registrerYrkesgruppe() {
  include("db.php");
  $yrkesgruppenavn = mysqli_real_escape_string($conn, $_POST["regYrkesgruppe"]);
  // Sjekk at tekstfeltet har input
  if(!empty($yrkesgruppenavn)) {
    // Sett inn i databasen
    $sql = "INSERT INTO yrkesgruppe (yrkesgruppenavn)
    VALUES ('$yrkesgruppenavn')";

    if(mysqli_query($conn, $sql)) {
      echo "<div class=\"alert alert-success\" align=\"top\">$yrkesgruppenavn registrert i yrkesgruppe databasen.</div>\n";
      echo "<meta http-equiv=\"refresh\" content=\"0\">\n";
    } else {
      echo "<div  class=\"alert alert-danger\" align=\"top\">Feil under database forespørsel: ". mysqli_error($conn) ."</div>\n";
    }
  } else {
    echo "<div class=\"alert alert-danger\" align=\"top\">Fyll ut alle felt. Registrering ikke godkjent</div>\n";
  }

  mysqli_close($conn);
}

function endreYrkesgruppe() {
  include("db.php");
  $yrkesgruppenr = mysqli_real_escape_string($conn, $_POST["velgYrkesgruppe"]);
  $yrkesgruppenavn = mysqli_real_escape_string($conn, $_POST["endringYrkesgruppe"]);

  if(!empty($yrkesgruppenr) && !empty($yrkesgruppenavn) && $yrkesgruppenr != "NULL") {
    $sql = "UPDATE yrkesgruppe SET yrkesgruppenavn='$yrkesgruppenavn' WHERE yrkesgruppenr='$yrkesgruppenr'";

    if(mysqli_query($conn, $sql)) {
      echo "<div class=\"alert alert-success\" align=\"top\">Databasen oppdatert.</div>\n";
      echo "<meta http-equiv=\"refresh\" content=\"0\">\n";
    } else {
      echo "<div class=\"alert alert-danger\" align=\"top\">Feil under database forespørsel: ". mysqli_error($conn) ."</div>\n";
    }
  } else {
    echo "<div class=\"alert alert-danger\" align=\"top\">Fyll ut alle felt. Endring ikke godkjent</div>\n";
  }

  mysqli_close($conn);
}

function slettYrkesgruppe() {
  include("db.php");
  $yrkesgruppenr = mysqli_real_escape_string($conn, $_POST["slettYrkesgruppe"]);

  if(!empty($yrkesgruppenr)) {
    $slettYrkesgruppeOk = 1;

    // Sjekk om yrkesgruppe er tilknyttet behandler
    $sql = "SELECT yrkesgruppenr FROM behandler WHERE yrkesgruppenr='$yrkesgruppenr'";
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result) > 0) {
      echo "<div class=\"alert alert-danger\" align=\"top\">Kan ikke slette yrkesgruppe når det finnes tilknyttede behandlere.</div>\n";
      $slettYrkesgruppeOk = 0;
    }

    if($slettYrkesgruppeOk == 1) {
      $sql = "DELETE FROM yrkesgruppe WHERE yrkesgruppenr='$yrkesgruppenr'";
      if (mysqli_query($conn, $sql)) {
        echo "<div class=\"alert alert-success\" align=\"top\">Databasen oppdatert.</div>\n";
        echo "<meta http-equiv=\"refresh\" content=\"0\">\n";
      } else {
        echo "<div class=\"alert alert-danger\" align=\"top\">Feil under database forespørsel: ". mysqli_error($conn) ."</div>\n";
      }
    }
  }

  mysqli_close($conn);
}

include("db.php");
if(@$_GET["action"] == "endre") {
  $yrkesgruppenr = mysqli_real_escape_string($conn, $_GET["yrkesgruppenr"]);
  $sql = "SELECT yrkesgruppenavn FROM yrkesgruppe WHERE yrkesgruppenr='$yrkesgruppenr'";
  $result = mysqli_query($conn, $sql);

  while($row = mysqli_fetch_assoc($result)) {
    echo "<h3>Endring</h3>\n";
    echo "<label>Yrkesgruppe</label><input type=\"text\" name=\"endringYrkesgruppe\"  value=\"". htmlspecialchars($row['yrkesgruppenavn']) ."\" required/><br/>\n";
    echo "<label>&nbsp;</label><input class=\"btn btn-primary\" type=\"submit\" value=\"Endre\" name=\"submitEndreYrkesgruppe\">\n";
    echo "</form>\n";
  }
  mysqli_close($conn);
}
?>