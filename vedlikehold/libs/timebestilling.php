<?php
function visTimebestilling() {
  include("db.php");
  $sql = "SELECT t.dato, t.tidspunkt, t.brukernavn, b.behandlernavn, t.personnr, p.pasientnavn
  FROM timebestilling AS t
  LEFT JOIN behandler AS b ON t.brukernavn = b.brukernavn
  LEFT JOIN pasient AS p ON t.personnr = p.personnr
  ORDER BY t.dato";
  $result = mysqli_query($conn, $sql);

  if(mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
      echo "<tr>\n";
      echo "<td>". htmlspecialchars($row['dato']) ."</td>\n";
      echo "<td>". htmlspecialchars($row['tidspunkt']) ."</td>\n";
      echo "<td>". htmlspecialchars($row['behandlernavn']) ."</td>\n";
      echo "<td>". htmlspecialchars($row['pasientnavn']) ."</td>\n";
      echo "</tr>\n";
    }
  } else {
    echo "<tr><td>Ingen timebestillinger funnet</td></tr>\n";
  }
  mysqli_close($conn);
}

function registrerTimebestilling() {
  include("db.php");
  $brukernavn = mysqli_real_escape_string($conn, $_POST["regBehandler"]);
  $personnr = mysqli_real_escape_string($conn, $_POST["regPasient"]);
  $dato = mysqli_real_escape_string($conn, $_POST["regDato"]);
  $tidspunkt = mysqli_real_escape_string($conn, $_POST["regTidspunkt"]);
  // Sjekk at tekstfeltene har input
  if(!empty($brukernavn) && !empty($personnr) && !empty($dato) && !empty($tidspunkt)) {
    // Sett inn i databasen
    $sql = "INSERT INTO timebestilling (dato, tidspunkt, brukernavn, personnr)
    VALUES ('$dato', '$tidspunkt', '$brukernavn', '$personnr')";

    if(mysqli_query($conn, $sql)) {
      echo "<div class=\"alert alert-success\" align=\"top\">$personnr registrert til time $dato kl. $tidspunkt i timebestilling databasen.</div>\n";
      echo "<meta http-equiv=\"refresh\" content=\"1\">\n";
    } else {
      echo "<div class=\"alert alert-danger\" align=\"top\">Feil under database forespørsel: ". mysqli_error($conn) ."</div>\n";
    }
  }
  mysqli_close($conn);
}

function endreTimebestilling() {
  include("db.php");
  $timebestillingnr = mysqli_real_escape_string($conn, $_POST["velgTidspunkt"]);
  $dato = mysqli_real_escape_string($conn, $_POST["endringDato"]);
  $tidspunkt = mysqli_real_escape_string($conn, $_POST["endringTidspunkt"]);
  $brukernavn = mysqli_real_escape_string($conn, $_POST["endringBehandler"]);
  $personnr = mysqli_real_escape_string($conn, $_POST["endringPasient"]);
  if(!empty($timebestillingnr) && !empty($dato) && !empty($tidspunkt) && !empty($brukernavn) && !empty($personnr)) {
    $sql = "UPDATE timebestilling SET dato='$dato', tidspunkt='$tidspunkt', brukernavn='$brukernavn', personnr='$personnr' WHERE timebestillingnr='$timebestillingnr'";

    if(mysqli_query($conn, $sql)) {
      echo "<div class=\"alert alert-success\" align=\"top\">Databasen oppdatert.</div>\n";
      echo "<meta http-equiv=\"refresh\" content=\"1\">\n";
    } else {
      echo "<div class=\"alert alert-danger\" align=\"top\">Feil under database forespørsel: ". mysqli_error($conn) ."</div>\n";
    }
  }
  mysqli_close($conn);
}

function slettTimebestilling() {
  include("db.php");
  $timebestillingnr = mysqli_real_escape_string($conn, $_POST["slettTidspunkt"]);

  if(!empty($timebestillingnr)) {
    $sql = "DELETE FROM timebestilling WHERE timebestillingnr='$timebestillingnr'";

    if (mysqli_query($conn, $sql)) {
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
  $personnr = mysqli_real_escape_string($conn, $_GET["velgPasient"]);
  $brukernavn = mysqli_real_escape_string($conn, $_GET["velgBehandler"]);
  $sql = "SELECT * FROM timebestilling WHERE brukernavn='$brukernavn' AND personnr='$personnr'";
  $result = mysqli_query($conn, $sql);

  if(mysqli_num_rows($result) > 0) {
    echo "<option selected=\"selected\">-Velg tidspunkt-</option>";
    while($row = mysqli_fetch_assoc($result)) {
      echo "<option value=\"" . htmlspecialchars($row['timebestillingnr']) . "\">". htmlspecialchars($row['dato']) ." kl.". htmlspecialchars($row['tidspunkt']) ."</option>\n";
    }
  } else {
    echo "<option value=\"NULL\">Ingen timebestillinger funnet</option>\n";
  }
}

if(@$_GET["action"] == "listeboksSlett") {
  $personnr = mysqli_real_escape_string($conn, $_GET["slettPasient"]);
  $brukernavn = mysqli_real_escape_string($conn, $_GET["slettBehandler"]);
  $sql = "SELECT * FROM timebestilling WHERE brukernavn='$brukernavn' AND personnr='$personnr'";
  $result = mysqli_query($conn, $sql);

  if(mysqli_num_rows($result) > 0) {
    echo "<option selected=\"selected\">-Velg tidspunkt-</option>";
    while($row = mysqli_fetch_assoc($result)) {
      echo "<option value=\"" . htmlspecialchars($row['timebestillingnr']) . "\">". htmlspecialchars($row['dato']) ." kl.". htmlspecialchars($row['tidspunkt']) ."</option>\n";
    }
  } else {
    echo "<option value=\"NULL\">Ingen timebestillinger funnet</option>\n";
  }
}

if(@$_GET["action"] == "endre") {
  $timebestillingnr = mysqli_real_escape_string($conn, $_GET["velgTidspunkt"]);
  $sql = "SELECT t.timebestillingnr, t.dato, t.tidspunkt, t.brukernavn, b.behandlernavn, t.personnr, p.pasientnavn
  FROM timebestilling AS t
  LEFT JOIN behandler AS b ON t.brukernavn = b.brukernavn
  LEFT JOIN pasient AS p ON t.personnr = p.personnr
  WHERE timebestillingnr='$timebestillingnr'";
  $result = mysqli_query($conn, $sql);

  while($row = mysqli_fetch_assoc($result)) {
    echo "<h3>Endring</h3>\n";
    echo "<form action=\"\" method=\"post\">\n";
    echo "<label>Pasient</label><select name=\"endringPasient\">\n";
    $sql2 = "SELECT personnr, pasientnavn FROM pasient ORDER BY pasientnavn";
    $result2 = mysqli_query($conn, $sql2);

    if(mysqli_num_rows($result2) > 0) {
      while($row2 = mysqli_fetch_assoc($result2)) {
        if($row2["personnr"] === $row["personnr"]) {
          echo "<option value=\"". htmlspecialchars($row2['personnr']) ."\" selected=\"selected\">". htmlspecialchars($row2['personnr']) ." - ". htmlspecialchars($row2['pasientnavn']) ."</option>\n";
        } else {
          echo "<option value=\"". htmlspecialchars($row2['personnr']) ."\">". htmlspecialchars($row2['personnr']) ." - ". htmlspecialchars($row2['pasientnavn']) ."</option>\n";
        }
      }
    } else {
      echo "<option value=\"NULL\">Ingen pasienter funnet</option>\n";
    }
    echo "</select><br/>\n";
    echo "<label>Behandler</label><select name=\"endringBehandler\">\n";
    $sql3 = "SELECT brukernavn, behandlernavn, yrkesgruppenavn FROM behandler
    LEFT JOIN yrkesgruppe ON behandler.yrkesgruppenr = yrkesgruppe.yrkesgruppenr
    ORDER BY behandlernavn";
    $result3 = mysqli_query($conn, $sql3);

    if(mysqli_num_rows($result3) > 0) {
      while($row3 = mysqli_fetch_assoc($result3)) {
        if($row3["brukernavn"] === $row["brukernavn"]) {
          echo "<option value=\"". htmlspecialchars($row3['brukernavn']) ."\" selected=\"selected\">". htmlspecialchars($row3['behandlernavn']) ." - ". htmlspecialchars($row3['yrkesgruppenavn']) ."</option>\n";
        } else {
          echo "<option value=\"". htmlspecialchars($row3['brukernavn']) ."\">". htmlspecialchars($row3['behandlernavn']) ." - ". htmlspecialchars($row3['yrkesgruppenavn']) ."</option>\n";
        }
      }
    } else {
      echo "<option value=\"NULL\">Ingen behandlere funnet</option>\n";
    }
    echo "</select><br/>\n";
    echo "<label>Dato</label><input type=\"text\" id=\"endringDato\"  name=\"endringDato\" value=\"". htmlspecialchars($row['dato']) ."\" required/><br/>\n";
    echo "<label>Tidspunkt</label><input type=\"text\" name=\"endringTidspunkt\"  value=\"". htmlspecialchars($row['tidspunkt']) ."\" required/><br/>\n";
    echo "<label>&nbsp;</label><input class=\"btn btn-primary\" type=\"submit\" value=\"Endre\" name=\"submitEndreTimebestilling\">\n";
    echo "</form>\n";
  }
  mysqli_close($conn);
}
?>