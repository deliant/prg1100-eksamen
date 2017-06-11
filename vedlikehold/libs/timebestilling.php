<?php
function visTimebestilling() {
  include("db.php");
  $sql = "SELECT t.dato, t.tidspunkt, t.brukernavn, b.behandlernavn, t.personnr, p.pasientnavn
  FROM timebestilling AS t
  LEFT JOIN behandler AS b ON t.brukernavn = b.brukernavn
  LEFT JOIN pasient AS p ON t.personnr = p.personnr
  ORDER BY dato";
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
  setlocale(LC_TIME, "nb_NO.UTF-8");
  $year = substr($dato, 0, 4);
  $month = substr($dato, 5, 2);
  $day = substr($dato, 8, 2);
  $ukedag = strftime("%A", mktime(0, 0, 0, $month, $day, $year));

  // Sjekk at tekstfeltene har input
  if(!empty($brukernavn) && !empty($personnr) && !empty($dato) && !empty($tidspunkt)) {
    $regTimebestillingOk = 1;
    // Sjekk om tidspunkt for timebestilling er i timeinndeling
    $sql = "SELECT timeinndelingnr FROM timeinndeling
    WHERE brukernavn='$brukernavn' AND ukedag='$ukedag' AND tidspunkt='$tidspunkt'";
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result) == 0) {
      echo "<div  class=\"alert alert-danger\" align=\"top\">Timebestilling er utenfor timeinndeling.</div>\n";
      $regTimebestillingOk = 0;
    }

    // Sjekk om timebestilling allerede eksisterer
    $sql = "SELECT timebestillingnr FROM timebestilling
    WHERE brukernavn='$brukernavn' AND dato='$dato' AND tidspunkt='$tidspunkt'";
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result) > 0) {
      echo "<div  class=\"alert alert-danger\" align=\"top\">Timebestilling for aktuelt tidspunkt eksisterer allerede.</div>\n";
      $regTimebestillingOk = 0;
    }

    if($regTimebestillingOk == 1) {
      // Sett inn i databasen
      $sql = "INSERT INTO timebestilling (dato, tidspunkt, brukernavn, personnr)
    VALUES ('$dato', '$tidspunkt', '$brukernavn', '$personnr')";

      if(mysqli_query($conn, $sql)) {
        $sql = "SELECT pasientnavn FROM pasient WHERE personnr='$personnr'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        echo "<div class=\"alert alert-success\" align=\"top\">". $row['pasientnavn'] ." registrert til time $dato kl. $tidspunkt i timebestilling databasen.</div>\n";
        echo "<meta http-equiv=\"refresh\" content=\"1\">\n";
      } else {
        echo "<div class=\"alert alert-danger\" align=\"top\">Feil under database forespørsel: ". mysqli_error($conn) ."</div>\n";
      }
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
  setlocale(LC_TIME, "nb_NO.UTF-8");
  $year = substr($dato, 0, 4);
  $month = substr($dato, 5, 2);
  $day = substr($dato, 8, 2);
  $ukedag = strftime("%A", mktime(0, 0, 0, $month, $day, $year));

  if(!empty($timebestillingnr) && !empty($dato) && !empty($tidspunkt) && !empty($brukernavn) && !empty($personnr)) {
    $regTimebestillingOk = 1;
    // Sjekk om tidspunkt for timebestilling er i timeinndeling
    $sql = "SELECT timeinndelingnr FROM timeinndeling
    WHERE brukernavn='$brukernavn' AND ukedag='$ukedag' AND tidspunkt='$tidspunkt'";
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result) == 0) {
      echo "<div  class=\"alert alert-danger\" align=\"top\">Timebestilling er utenfor timeinndeling.</div>\n";
      $regTimebestillingOk = 0;
    }

    // Sjekk om timebestilling allerede eksisterer
    $sql = "SELECT timebestillingnr FROM timebestilling
    WHERE brukernavn='$brukernavn' AND dato='$dato' AND tidspunkt='$tidspunkt'";
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result) > 0) {
      echo "<div  class=\"alert alert-danger\" align=\"top\">Timebestilling for aktuelt tidspunkt eksisterer allerede.</div>\n";
      $regTimebestillingOk = 0;
    }

    if($regTimebestillingOk == 1) {
      $sql = "UPDATE timebestilling SET dato='$dato', tidspunkt='$tidspunkt', brukernavn='$brukernavn', personnr='$personnr'
    WHERE timebestillingnr='$timebestillingnr'";

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

function slettTimebestilling() {
  include("db.php");
  $timebestillingnr = mysqli_real_escape_string($conn, $_POST["slettTidspunkt"]);

  if(!empty($timebestillingnr && $timebestillingnr != "NULL")) {
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
if(@$_GET["action"] == "listeboksReg") {
  $brukernavn = mysqli_real_escape_string($conn, $_GET["regBehandler"]);
  $dato = mysqli_real_escape_string($conn, $_GET["regDato"]);
  setlocale(LC_TIME, "nb_NO.UTF-8");
  $year = substr($dato, 0, 4);
  $month = substr($dato, 5, 2);
  $day = substr($dato, 8, 2);
  $ukedag = strftime("%A", mktime(0, 0, 0, $month, $day, $year));

  // Sjekk om det finnes timebestillinger for dato
  $sql = "SELECT timebestillingnr FROM timebestilling
  WHERE brukernavn='$brukernavn' AND dato='$dato'";
  $result = mysqli_query($conn, $sql);
  if(mysqli_num_rows($result) == 0) {
    // Sjekk om det finnes timeinndeling for ukedag
    $sql = "SELECT timeinndelingnr FROM timeinndeling
    WHERE brukernavn='$brukernavn' AND ukedag='$ukedag'";
    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) == 0) {
      echo "<option value=\"NULL\">Ingen timeinndeling for denne ukedagen</option>\n";
    } else {
      // List select options fra timeinndeling hvis ingen timebestillinger
      $sql = "SELECT timeinndelingnr, tidspunkt FROM timeinndeling
      WHERE brukernavn='$brukernavn' AND ukedag='$ukedag'";
      $result = mysqli_query($conn, $sql);
      echo "<option selected=\"selected\">-Velg tidspunkt-</option>";
      while ($row = mysqli_fetch_assoc($result)) {
        echo "<option value=\"" . htmlspecialchars($row['tidspunkt']) . "\">" . htmlspecialchars($row['tidspunkt']) . "</option>\n";
      }
    }

  } else {
    $sql = "SELECT dato, ti.tidspunkt, ti.brukernavn
    FROM timebestilling AS tb
    LEFT JOIN timeinndeling AS ti ON ti.brukernavn = tb.brukernavn AND ti.tidspunkt != tb.tidspunkt
    WHERE tb.brukernavn='$brukernavn' AND dato='$dato'
    ORDER BY tidspunkt";
    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) > 0) {
      echo "<option selected=\"selected\">-Velg tidspunkt-</option>";
      while($row = mysqli_fetch_assoc($result)) {
        echo "<option value=\"" . htmlspecialchars($row['tidspunkt']) . "\">". htmlspecialchars($row['tidspunkt']) ."</option>\n";
      }
    } else {
      echo "<option value=\"NULL\">Ingen ledige timebestillinger</option>\n";
    }
  }
}

if(@$_GET["action"] == "listeboksEndre") {
  $brukernavn = mysqli_real_escape_string($conn, $_GET["velgBehandler"]);
  $personnr = mysqli_real_escape_string($conn, $_GET["velgPasient"]);
  $sql = "SELECT * FROM timebestilling WHERE brukernavn='$brukernavn' AND personnr='$personnr'";
  $result = mysqli_query($conn, $sql);

  if(mysqli_num_rows($result) > 0) {
    echo "<option selected=\"selected\">-Velg tidspunkt-</option>";
    while($row = mysqli_fetch_assoc($result)) {
      echo "<option value=\"" . htmlspecialchars($row['timebestillingnr']) . "\">". htmlspecialchars($row['dato']) ." (". htmlspecialchars($row['tidspunkt']) .")</option>\n";
    }
  } else {
    echo "<option value=\"NULL\">Ingen timebestillinger funnet</option>\n";
  }
}

if(@$_GET["action"] == "listeboksVisLedig") {
  $brukernavn = mysqli_real_escape_string($conn, $_GET["endringBehandler"]);
  $dato = mysqli_real_escape_string($conn, $_GET["endringDato"]);
  setlocale(LC_TIME, "nb_NO.UTF-8");
  $year = substr($dato, 0, 4);
  $month = substr($dato, 5, 2);
  $day = substr($dato, 8, 2);
  $ukedag = strftime("%A", mktime(0, 0, 0, $month, $day, $year));

  // Sjekk om det finnes timebestillinger for dato
  $sql = "SELECT timebestillingnr FROM timebestilling
  WHERE brukernavn='$brukernavn' AND dato='$dato'";
  $result = mysqli_query($conn, $sql);
  if(mysqli_num_rows($result) == 0) {
    // Sjekk om det finnes timeinndeling for ukedag
    $sql = "SELECT timeinndelingnr FROM timeinndeling
    WHERE brukernavn='$brukernavn' AND ukedag='$ukedag'";
    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) == 0) {
      echo "<option value=\"NULL\">Ingen timeinndeling for denne ukedagen</option>\n";
    } else {
      // List select options fra timeinndeling hvis ingen timebestillinger
      $sql = "SELECT timeinndelingnr, tidspunkt FROM timeinndeling
      WHERE brukernavn='$brukernavn' AND ukedag='$ukedag'";
      $result = mysqli_query($conn, $sql);
      echo "<option selected=\"selected\">-Velg tidspunkt-</option>";
      while ($row = mysqli_fetch_assoc($result)) {
        echo "<option value=\"" . htmlspecialchars($row['tidspunkt']) . "\">" . htmlspecialchars($row['tidspunkt']) . "</option>\n";
      }
    }

  } else {
    $sql = "SELECT dato, ti.tidspunkt, ti.brukernavn
    FROM timebestilling AS tb
    LEFT JOIN timeinndeling AS ti ON ti.brukernavn = tb.brukernavn AND ti.tidspunkt != tb.tidspunkt
    WHERE tb.brukernavn='$brukernavn' AND dato='$dato'
    ORDER BY tidspunkt";
    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) > 0) {
      echo "<option selected=\"selected\">-Velg tidspunkt-</option>";
      while($row = mysqli_fetch_assoc($result)) {
        echo "<option value=\"" . htmlspecialchars($row['tidspunkt']) . "\">". htmlspecialchars($row['tidspunkt']) ."</option>\n";
      }
    } else {
      echo "<option value=\"NULL\">Ingen ledige timebestillinger</option>\n";
    }
  }
}

if(@$_GET["action"] == "listeboksSlett") {
  $brukernavn = mysqli_real_escape_string($conn, $_GET["slettBehandler"]);
  $personnr = mysqli_real_escape_string($conn, $_GET["slettPasient"]);
  $sql = "SELECT * FROM timebestilling WHERE brukernavn='$brukernavn' AND personnr='$personnr'";
  $result = mysqli_query($conn, $sql);

  if(mysqli_num_rows($result) > 0) {
    echo "<option selected=\"selected\">-Velg tidspunkt-</option>";
    while($row = mysqli_fetch_assoc($result)) {
      echo "<option value=\"" . htmlspecialchars($row['timebestillingnr']) . "\">". htmlspecialchars($row['dato']) ." (". htmlspecialchars($row['tidspunkt']) .")</option>\n";
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
    echo "<label>Behandler</label><select id=\"endringBehandler\" name=\"endringBehandler\">\n";
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
    echo "<label>Dato</label><input type=\"text\" id=\"endringDato\"  name=\"endringDato\" onkeyup=\"listeboksVisLedigTimebestilling(this.value)\" value=\"". htmlspecialchars($row['dato']) ."\" required/><br/>\n";
    echo "<label>Tidspunkt</label>";
    echo "<select id=\"endringTidspunkt\" name=\"endringTidspunkt\">\n";
    echo "<option>-Velg behandler og dato-</option>\n";
    echo "</select><br/>\n";
    echo "<label>&nbsp;</label><input class=\"btn btn-primary\" type=\"submit\" value=\"Endre\" name=\"submitEndreTimebestilling\">\n";
    echo "</form>\n";
  }

  mysqli_close($conn);
}
?>