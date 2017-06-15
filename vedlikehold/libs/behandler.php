<?php
function visBehandler() {
  include("db.php");
  $sql = "SELECT b.brukernavn, b.behandlernavn, b.bildenr, yrkesgruppe.yrkesgruppenavn, bilde.filnavn
  FROM behandler AS b
  LEFT JOIN yrkesgruppe ON b.yrkesgruppenr = yrkesgruppe.yrkesgruppenr
  LEFT JOIN bilde ON b.bildenr = bilde.bildenr
  ORDER BY yrkesgruppenavn, behandlernavn";
  $result = mysqli_query($conn, $sql);

  if(mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
      echo "<tr>\n";
      echo "<td><img class=\"thumbnail-bilde\" src=\"D:\\Sites\\home.hbv.no\\phptemp\\web-prg11v10/". htmlspecialchars($row['filnavn']) ."\"></td>\n";
      echo "<td>". htmlspecialchars($row['behandlernavn']) ."</td>\n";
      echo "<td>". htmlspecialchars($row['brukernavn']) ."</td>\n";
      echo "<td>". htmlspecialchars($row['yrkesgruppenavn']) ."</td>\n";
      echo "<td>". htmlspecialchars($row['bildenr']) ."</td>\n";
      echo "</tr>\n";
    }
  } else {
    echo "<tr><td>Ingen behandlere funnet</td></tr>\n";
  }

  mysqli_close($conn);
}

function registrerBehandler() {
  include("db.php");
  $brukernavn = mysqli_real_escape_string($conn, $_POST["regBrukernavn"]);
  $navn = mysqli_real_escape_string($conn, $_POST["regNavn"]);
  $yrkesgruppenr = mysqli_real_escape_string($conn, $_POST["regYrkesgruppenr"]);
  $bildenr = mysqli_real_escape_string($conn, $_POST["regBildenr"]);

  // Sjekk at tekstfeltene har input
  if(!empty($brukernavn) && !empty($navn) && !empty($yrkesgruppenr) && !empty($bildenr) &&
  $yrkesgruppenr != NULL && $bildenr != "NULL") {
    // Sjekk om checkbox for databasebruker er på
    if(isset($_POST["checkboxbruker"])) {
      $passord = mysqli_real_escape_string($conn, $_POST["regPassord"]);
      if(isset($passord) && !empty($passord)) {
        $kryptert_passord = password_hash($passord, PASSWORD_DEFAULT);
        $sql = "INSERT INTO bruker (brukernavn, passord)
        VALUES ('$brukernavn', '$kryptert_passord')";
        mysqli_query($conn, $sql) or die("<div class=\"alert alert-danger\">Feil under database forespørsel: " . mysqli_error($conn) . "</div>");
      }
    }

    // Sett inn i databasen
    $sql = "INSERT INTO behandler (brukernavn, behandlernavn, yrkesgruppenr, bildenr)
    VALUES ('$brukernavn', '$navn', '$yrkesgruppenr', '$bildenr')";
    if(mysqli_query($conn, $sql)) {
      echo "<div class=\"alert alert-success\">$navn registrert i behandler databasen.</div>\n";
      echo "<meta http-equiv=\"refresh\" content=\"1\">\n";
    } else {
      echo "<div class=\"alert alert-danger\">Feil under database forespørsel: " . mysqli_error($conn) . "</div>\n";
    }
  }

  mysqli_close($conn);
}

function endreBehandler() {
  include("db.php");
  $brukernavn = mysqli_real_escape_string($conn, $_POST["endringBrukernavn"]);
  $navn = mysqli_real_escape_string($conn, $_POST["endringNavn"]);
  $yrkesgruppenr = mysqli_real_escape_string($conn, $_POST["endringYrkesgruppenr"]);
  $bildenr = mysqli_real_escape_string($conn, $_POST["endringBildenr"]);

  // Sjekk at tekstfeltene har input
  if(!empty($brukernavn) && !empty($navn) && !empty($yrkesgruppenr) && !empty($bildenr)) {
    $sql = "UPDATE behandler SET behandlernavn='$navn', yrkesgruppenr='$yrkesgruppenr', bildenr='$bildenr' WHERE brukernavn='$brukernavn'";

    // Endre i databasen
    if(mysqli_query($conn, $sql)) {
      echo "<div class=\"alert alert-success\" align=\"top\">Databasen oppdatert.</div>\n";
      echo "<meta http-equiv=\"refresh\" content=\"1\">\n";
    } else {
      echo "<div class=\"alert alert-danger\">Feil under database forespørsel: " . mysqli_error($conn) . "</div>\n";
    }
  }

  mysqli_close($conn);
}

function slettBehandler() {
  include("db.php");
  $brukernavn = mysqli_real_escape_string($conn, $_POST["slettBehandler"]);
  if(!empty($brukernavn) && $brukernavn != "NULL") {
    $slettBehandlerOk = 1;

    // Sjekk om timebestillinger er tilknyttet behandler
    $sql = "SELECT timebestillingnr FROM timebestilling WHERE brukernavn='$brukernavn'";
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result) > 0) {
      echo "<div  class=\"alert alert-danger\" align=\"top\">Kan ikke slette behandler når det finnes aktive timebestillinger.</div>\n";
      $slettBehandlerOk = 0;
    }

    // Sjekk om timeinndelinger er tilknyttet behandler
    $sql = "SELECT timeinndelingnr FROM timeinndeling WHERE brukernavn='$brukernavn'";
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result) > 0) {
      echo "<div class=\"alert alert-danger\">Kan ikke slette behandler når det finnes aktive timeinndelinger.</div>\n";
      $slettBehandlerOk = 0;
    }

    // Sjekk om pasienter er tilknyttet behandler
    $sql = "SELECT personnr FROM pasient WHERE brukernavn='$brukernavn'";
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result) > 0) {
      echo "<div class=\"alert alert-danger\">Kan ikke slette behandler når vedkommende står som fastlege for pasient.</div>\n";
      $slettBehandlerOk = 0;
    }

    if($slettBehandlerOk == 1) {
      // Sjekk om checkbox for å slette bilde er på
      if(isset($_POST["checkboxbilde"])) {
        $sql = "SELECT bildenr FROM behandler WHERE brukernavn='$brukernavn'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $bildenr = $row["bildenr"];

        $sql = "SELECT filnavn FROM bilde WHERE bildenr='$bildenr'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $filbane = "/../bilder/" . $row["filnavn"];

        if(is_writable($filbane)) {
          // Slett fil
          if(unlink($filbane)) {
            $slettBildeOk = 1;
            echo "<div class=\"alert alert-success\">Bildefil " . $row['filnavn'] . " slettet.</div>\n";
          } else {
            $slettBildeOk = 0;
            echo "<div class=\"alert alert-danger\">Bildefil kunne ikke slettes automatisk.</div>\n";
          }
        }

        if($slettBildeOk == 1) {
          $sql = "DELETE FROM bilde WHERE bildenr='$bildenr'";
          if(mysqli_query($conn, $sql)) {
            echo "<div class=\"alert alert-success\">Bilde slettet fra database.</div>\n";
          } else {
            echo "<div class=\"alert alert-danger\">Feil under database forespørsel: " . mysqli_error($conn) . "</div>\n";
          }
        }
      }

      // Endre i databasen
      $sql = "DELETE FROM behandler WHERE brukernavn='$brukernavn'";
      if(mysqli_query($conn, $sql)) {
        echo "<div class=\"alert alert-success\">Databasen oppdatert.</div>\n";
        echo "<meta http-equiv=\"refresh\" content=\"1\">\n";
      } else {
        echo "<div class=\"alert alert-danger\">Feil under database forespørsel: ". mysqli_error($conn) ."</div>\n";
      }
    }
  }

  mysqli_close($conn);
}

include("db.php");
if(@$_GET["action"] == "visCheckbox") {
  echo "<label>Passord</label><input type=\"password\" name=\"regPassord\"><br/>\n";
}

if(@$_GET["action"] == "endre") {
  $brukernavn = mysqli_real_escape_string($conn, $_GET["brukernavn"]);
  $sql = "SELECT b.brukernavn, b.behandlernavn, y.yrkesgruppenavn, b.yrkesgruppenr, b.bildenr 
  FROM behandler AS b
  LEFT JOIN yrkesgruppe AS y ON b.yrkesgruppenr = y.yrkesgruppenr
  WHERE brukernavn='$brukernavn'";
  $result = mysqli_query($conn, $sql);

  while($row = mysqli_fetch_assoc($result)) {
    echo "<h3>Endring</h3>\n";
    echo "<form action=\"\" method=\"post\" onsubmit=\"return validerBehandlerEndring()\">\n";
    echo "<label>Brukernavn</label><input type=\"text\" name=\"endringBrukernavn\" value=\"" . htmlspecialchars($row['brukernavn']) . "\" readonly required/><br/>\n";
    echo "<label>Navn</label><input type=\"text\" id=\"endringNavn\" name=\"endringNavn\" value=\"" . htmlspecialchars($row['behandlernavn']) ."\" required/><br/>\n";
    echo "<label>Yrkesgruppe</label><select name=\"endringYrkesgruppenr\">\n";
    $sql2 = "SELECT yrkesgruppenr, yrkesgruppenavn FROM yrkesgruppe ORDER BY yrkesgruppenavn";
    $result2 = mysqli_query($conn, $sql2);

    if(mysqli_num_rows($result2) > 0) {
      while($row2 = mysqli_fetch_assoc($result2)) {
        if($row2["yrkesgruppenr"] === $row["yrkesgruppenr"]) {
          echo "<option value=\"". htmlspecialchars($row2['yrkesgruppenr']) ."\" selected=\"selected\">". htmlspecialchars($row2['yrkesgruppenavn']) ."</option>\n";
        } else {
          echo "<option value=\"". htmlspecialchars($row2['yrkesgruppenr']) ."\">". htmlspecialchars($row2['yrkesgruppenavn']) ."</option>\n";
        }
      }
    } else {
      echo "<option value=\"NULL\">Ingen yrkesgrupper funnet</option>\n";
    }

    echo "</select><br/>\n";
    echo "<label>Bilde</label><select name=\"endringBildenr\">\n";
    $sql3 = "SELECT bildenr, beskrivelse FROM bilde ORDER BY bildenr DESC";
    $result3 = mysqli_query($conn, $sql3);

    if(mysqli_num_rows($result3) > 0) {
      while($row3 = mysqli_fetch_assoc($result3)) {
        if($row3["bildenr"] === $row["bildenr"]) {
          echo "<option value=\"". htmlspecialchars($row3['bildenr']) ."\" selected=\"selected\">". htmlspecialchars($row3['bildenr']) ." - ". htmlspecialchars($row3['beskrivelse']) ."</option>\n";
        } else {
          echo "<option value=\"". htmlspecialchars($row3['bildenr']) ."\">". htmlspecialchars($row3['bildenr']) ." - ". htmlspecialchars($row3['beskrivelse']) ."</option>\n";
        }
      }
    } else {
      echo "<option value=\"NULL\">Ingen bilder funnet</option>\n";
    }

    echo "</select><br/>\n";
    echo "<label>&nbsp;</label><input class=\"btn btn-primary\" type=\"submit\" value=\"Endre\" name=\"submitEndreBehandler\">\n";
    echo "</form>\n";
  }

  mysqli_close($conn);
}
?>