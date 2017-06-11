<?php
function visTimeinndeling() {
  include("db.php");
  $sql = "SELECT t.ukedag, t.tidspunkt, b.behandlernavn
  FROM timeinndeling AS t
  LEFT JOIN behandler AS b ON t.brukernavn = b.brukernavn
  ORDER BY behandlernavn";
  $result = mysqli_query($conn, $sql);

  if(mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
      echo "<tr>\n";
      echo "<td>". htmlspecialchars($row['behandlernavn']) ."</td>\n";
      echo "<td>". htmlspecialchars($row['ukedag']) ."</td>\n";
      echo "<td>". htmlspecialchars($row['tidspunkt']) ."</td>\n";
      echo "</tr>\n";
    }
  } else {
    echo "<tr><td>Ingen timeinndelinger funnet</td></tr>\n";
  }

  mysqli_close($conn);
}

function registrerTimeinndeling() {
  include("db.php");
  $brukernavn = mysqli_real_escape_string($conn, $_POST["regBrukernavn"]);
  $ukedag = mysqli_real_escape_string($conn, $_POST["regUkedag"]);
  $fratidspunkt = mysqli_real_escape_string($conn, $_POST["regFraTidspunkt"]);
  $tiltidspunkt = mysqli_real_escape_string($conn, $_POST["regTilTidspunkt"]);
  $tidspunkt = $fratidspunkt . "-" . $tiltidspunkt;

  // Sjekk at tekstfeltene har input
  if(!empty($brukernavn) && !empty($ukedag) && !empty($fratidspunkt) && !empty($tiltidspunkt)) {
    $regTimeinndelingOk = 1;
    // Sjekk at verdiene for fratidspunkt og tiltidspunkt ikke er like
    if($fratidspunkt == $tiltidspunkt) {
      echo "<div  class=\"alert alert-danger\" align=\"top\">Kan ikke registrere timeinndeling med samme fra og til verdi.</div>\n";
      $regTimeinndelingOk = 0;
    }

    // Sjekk om timeinndeling allerede eksisterer
    $sql = "SELECT timeinndelingnr FROM timeinndeling WHERE brukernavn='$brukernavn' AND ukedag='$ukedag' AND tidspunkt='$tidspunkt'";
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result) > 0) {
      echo "<div  class=\"alert alert-danger\" align=\"top\">Timeinndeling eksisterer allerede.</div>\n";
      $regTimeinndelingOk = 0;
    }

    if($regTimeinndelingOk == 1) {
      // Sett inn i databasen
      $sql = "INSERT INTO timeinndeling (brukernavn, ukedag, tidspunkt)
      VALUES ('$brukernavn', '$ukedag', '$tidspunkt')";

      if(mysqli_query($conn, $sql)) {
        echo "<div class=\"alert alert-success\" align=\"top\">$brukernavn registrert som åpen for å ta imot pasienter $ukedag kl. $tidspunkt i timeinndeling databasen.</div>\n";
        echo "<meta http-equiv=\"refresh\" content=\"1\">\n";
      } else {
        echo "<div class=\"alert alert-danger\" align=\"top\">Feil under database forespørsel: ". mysqli_error($conn) ."</div>\n";
      }
    }
  }

  mysqli_close($conn);
}

function endreTimeinndeling() {
  include("db.php");
  $timeinndelingnr = mysqli_real_escape_string($conn, $_POST["velgTidspunkt"]);
  $brukernavn = mysqli_real_escape_string($conn, $_POST["endringBehandler"]);
  $ukedag = mysqli_real_escape_string($conn, $_POST["endringUkedag"]);
  $fratidspunkt = mysqli_real_escape_string($conn, $_POST["endringFraTidspunkt"]);
  $tiltidspunkt = mysqli_real_escape_string($conn, $_POST["endringTilTidspunkt"]);
  $tidspunkt = $fratidspunkt . "-" . $tiltidspunkt;

  // Sjekk at tekstfeltene har input
  if(!empty($timeinndelingnr) && !empty($brukernavn) && !empty($ukedag) && !empty($fratidspunkt) && !empty($tiltidspunkt)) {
    $regTimeinndelingOk = 1;
    // Sjekk at verdiene for fratidspunkt og tiltidspunkt ikke er like
    if($fratidspunkt == $tiltidspunkt) {
      echo "<div  class=\"alert alert-danger\" align=\"top\">Kan ikke registrere timeinndeling med samme fra og til verdi.</div>\n";
      $regTimeinndelingOk = 0;
    }

    // Sjekk om timeinndeling allerede eksisterer
    $sql = "SELECT timeinndelingnr FROM timeinndeling WHERE brukernavn='$brukernavn' AND ukedag='$ukedag' AND tidspunkt='$tidspunkt'";
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result) > 0) {
      echo "<div  class=\"alert alert-danger\" align=\"top\">Timeinndeling eksisterer allerede.</div>\n";
      $regTimeinndelingOk = 0;
    }

    if($regTimeinndelingOk == 1) {
      // Sett inn i databasen
      $sql = "UPDATE timeinndeling SET brukernavn='$brukernavn', ukedag='$ukedag', tidspunkt='$tidspunkt'
      WHERE timeinndelingnr='$timeinndelingnr'";

      if(mysqli_query($conn, $sql)) {
        echo "<div class=\"alert alert-success\" align=\"top\">Databasen oppdatert.</div>\n";
        echo "<meta http-equiv=\"refresh\" content=\"1\">\n";
      } else {
        echo "<div class=\"alert alert-danger\" align=\"top\">Feil under database forespørsel: ". mysqli_error($conn) ."</div>\n";
      }
    }
  }

  mysqli_close($conn);
}

function slettTimeinndeling() {
  include("db.php");
  $timeinndelingnr = mysqli_real_escape_string($conn, $_POST["slettTidspunkt"]);

  // Sjekk at tekstfeltene har input
  if(!empty($timeinndelingnr) && $timeinndelingnr != "NULL") {
    // Slett fra databasen
    $sql = "DELETE FROM timeinndeling WHERE timeinndelingnr='$timeinndelingnr'";
    if(mysqli_query($conn, $sql)) {
      echo "<div class=\"alert alert-success\" align=\"top\">Databasen oppdatert.</div>\n";
      echo "<meta http-equiv=\"refresh\" content=\"1\">\n";
    } else {
      echo "<div class=\"alert alert-danger\" align=\"top\">Feil under database forespørsel: ". mysqli_error($conn) ."</div>\n";
    }
  }

  mysqli_close($conn);
}

include("db.php");
if(@$_GET["action"] == "listeboksEndre") {
  $brukernavn = mysqli_real_escape_string($conn, $_GET["velgBehandler"]);
  $ukedag = mysqli_real_escape_string($conn, $_GET["velgUkedag"]);
  $sql = "SELECT * FROM timeinndeling WHERE brukernavn='$brukernavn' AND ukedag='$ukedag'";
  $result = mysqli_query($conn, $sql);

  if(mysqli_num_rows($result) > 0) {
    echo "<option selected=\"selected\">-Velg tidspunkt-</option>";
    while($row = mysqli_fetch_assoc($result)) {
      echo "<option value=\"" . htmlspecialchars($row['timeinndelingnr']) . "\">". htmlspecialchars($row['tidspunkt']) ."</option>\n";
    }
  } else {
    echo "<option value=\"NULL\">Ingen timebestillinger funnet</option>\n";
  }
}

if(@$_GET["action"] == "listeboksSlett") {
  $brukernavn = mysqli_real_escape_string($conn, $_GET["slettBehandler"]);
  $ukedag = mysqli_real_escape_string($conn, $_GET["slettUkedag"]);
  $sql = "SELECT * FROM timeinndeling WHERE brukernavn='$brukernavn' AND ukedag='$ukedag'";
  $result = mysqli_query($conn, $sql);

  if(mysqli_num_rows($result) > 0) {
    echo "<option selected=\"selected\">-Velg tidspunkt-</option>";
    while($row = mysqli_fetch_assoc($result)) {
      echo "<option value=\"" . htmlspecialchars($row['timeinndelingnr']) . "\">". htmlspecialchars($row['tidspunkt']) ."</option>\n";
    }
  } else {
    echo "<option value=\"NULL\">Ingen timebestillinger funnet</option>\n";
  }
}

if(@$_GET["action"] == "endre") {
  $timeinndelingnr = mysqli_real_escape_string($conn, $_GET["velgTidspunkt"]);
  $sql = "SELECT t.timeinndelingnr, t.ukedag, t.tidspunkt, t.brukernavn, b.behandlernavn
  FROM timeinndeling AS t
  LEFT JOIN behandler AS b ON t.brukernavn = b.brukernavn
  WHERE timeinndelingnr='$timeinndelingnr'";
  $result = mysqli_query($conn, $sql);

  while($row = mysqli_fetch_assoc($result)) {
    $fratidspunkt = substr($row["tidspunkt"], 0,5);
    $tiltidspunkt = substr($row["tidspunkt"], 6,5);
    echo "<h3>Endring</h3>\n";
    echo "<label>Behandler</label><select name=\"endringBehandler\">\n";
    $sql2 = "SELECT brukernavn, behandlernavn, yrkesgruppe.yrkesgruppenavn FROM behandler
    LEFT JOIN yrkesgruppe ON behandler.yrkesgruppenr = yrkesgruppe.yrkesgruppenr
    ORDER BY behandlernavn";
    $result2 = mysqli_query($conn, $sql2);

    if(mysqli_num_rows($result2) > 0) {
      while($row2 = mysqli_fetch_assoc($result2)) {
        if($row2["brukernavn"] === $row["brukernavn"]) {
          echo "<option value=\"". htmlspecialchars($row2['brukernavn']) ."\" selected=\"selected\">". htmlspecialchars($row2['behandlernavn']) ." - ". htmlspecialchars($row2['yrkesgruppenavn']) ."</option>\n";
        } else {
          echo "<option value=\"". htmlspecialchars($row2['brukernavn']) ."\">". htmlspecialchars($row2['behandlernavn']) ." - ". htmlspecialchars($row2['yrkesgruppenavn']) ."</option>\n";
        }
      }
    } else {
      echo "<option value=\"NULL\">Ingen behandlere funnet</option>\n";
    }

    echo "</select><br/>\n";
    echo "<label>Ukedag</label><select name=\"endringUkedag\">\n";
    echo "<option>-Velg ukedag-</option>\n";
    echo "<option value=\"Mandag\"";
    if($row["ukedag"] == "Mandag") { print " selected=\"selected\""; }
    echo ">Mandag</option>\n";
    echo "<option value=\"Tirsdag\"";
    if($row["ukedag"] == "Tirsdag") { print " selected=\"selected\""; }
    echo ">Tirsdag</option>\n";
    echo "<option value=\"Onsdag\"";
    if($row["ukedag"] == "Onsdag") { print " selected=\"selected\""; }
    echo ">Onsdag</option>\n";
    echo "<option value=\"Torsdag\"";
    if($row["ukedag"] == "Torsdag") { print " selected=\"selected\""; }
    echo ">Torsdag</option>\n";
    echo "<option value=\"Fredag\"";
    if($row["ukedag"] == "Fredag") { print " selected=\"selected\""; }
    echo ">Fredag</option>\n";
    echo "</select><br/>\n";
    echo "<label>Tidspunkt</label><input type=\"time\" id=\"endringFraTidspunkt\" name=\"endringFraTidspunkt\" value=\"". htmlspecialchars($fratidspunkt) ."\" required />\n";
    echo "<input type=\"time\" id=\"endringTilTidspunkt\" name=\"endringTilTidspunkt\" value=\"". htmlspecialchars($tiltidspunkt) ."\" required /><br/>\n";
    echo "<label>&nbsp;</label><input class=\"btn btn-primary\" type=\"submit\" value=\"Endre\" name=\"submitEndreTimeinndeling\">\n";
    echo "</form>\n";
  }
  mysqli_close($conn);
}
?>