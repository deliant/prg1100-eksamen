<?php
function registrerBruker() {
  include("db.php");
  $personnr = mysqli_real_escape_string($conn, $_POST["regPersonnr"]);
  $navn = mysqli_real_escape_string($conn, $_POST["regNavn"]);
  $behandler = mysqli_real_escape_string($conn, $_POST["regBehandler"]);
  $passord = mysqli_real_escape_string($conn, $_POST["regPassord"]);

  // Sjekk at tekstfeltene har input
  if(!empty($personnr) && !empty($navn) && !empty($behandler) && !empty($passord)) {
    $sql = "SELECT * FROM pasient WHERE personnr='$personnr'";
    $result = mysqli_query($conn, $sql) or die("Kan ikke hente data fra databasen." . mysqli_error($conn));

    // Sjekk om brukeren finnes fra før
    if(mysqli_num_rows($result) != 0) {
      $row = mysqli_fetch_assoc($result);
      // Sjekk om brukeren har passord
      if($row["passord"] == NULL) {
        $kryptert_passord = password_hash($passord, PASSWORD_DEFAULT);
        $sql = "UPDATE pasient SET passord='$kryptert_passord' WHERE personnr='$personnr'";
        mysqli_query($conn, $sql) or die("Kan ikke registrere data i databasen." . mysqli_error($conn));
        echo "<div class=\"alert alert-success\">Brukeren med personnr " . $personnr . " er nå registrert.<br/>\n";
      } else {
        echo "<div class=\"alert alert-danger\">Personnummeret er registrert med passord fra før i databasen.</div>\n";
      }
    } else {
      $kryptert_passord = password_hash($passord, PASSWORD_DEFAULT);
      $sql = "INSERT INTO pasient VALUES('$personnr', '$navn', '$kryptert_passord', '$behandler')";
      mysqli_query($conn, $sql) or die("Kan ikke registrere data i databasen." . mysqli_error($conn));
      echo "<div class=\"alert alert-success\">Brukeren med personnr " . $personnr . " er nå registrert.<br/>\n";
    }
  }

  mysqli_close($conn);
}

function endrePassord() {
  include("db.php");
  $personnr = mysqli_real_escape_string($conn, $_SESSION["personnr"]);
  $passord = mysqli_real_escape_string($conn, $_POST["endrePassord"]);

  // Sjekk at tekstfeltene har input
  if(!empty($personnr) && !empty($passord)) {
    $sql = "SELECT * FROM pasient WHERE personnr='$personnr'";
    $result = mysqli_query($conn, $sql) or die("Kan ikke hente data fra databasen." . mysqli_error($conn));

    if(mysqli_num_rows($result) > 0) {
      $kryptert_passord = mysqli_real_escape_string($conn, password_hash($passord, PASSWORD_DEFAULT));
      $sql = "UPDATE pasient SET passord='$kryptert_passord' WHERE personnr='$personnr'";
      mysqli_query($conn, $sql) or die("Kan ikke registrere data i databasen." . mysqli_error($conn));
      echo "<div class=\"alert alert-success\">Passord for ". $personnr ." er oppdatert.</div>\n";
      echo "<meta http-equiv=\"refresh\" content=\"1\">\n";
    } else {
      echo "<div class=\"alert alert-danger\">Feil under database forespørsel: " . mysqli_error($conn) . "</div>\n";
    }
  }

  mysqli_close($conn);
}

function sjekkLogin($personnr, $passord) {
  include("db.php");
  $validUser = true;

  if(!$personnr || !$passord) {
    $validUser = false;
  }

  $sql = "SELECT * FROM pasient WHERE personnr='$personnr'";
  $result = mysqli_query($conn, $sql);
  if(!$result){
    $validUser = false;
  } else {
    $row = mysqli_fetch_assoc($result);
    $lagretPersonnr = mysqli_real_escape_string($conn, $row["personnr"]);
    $lagretPassord = mysqli_real_escape_string($conn, $row["passord"]);

    if($personnr != $lagretPersonnr || !password_verify($passord, $lagretPassord)){
      $validUser = false;
    }
  }

  mysqli_close($conn);

  return $validUser;
}

function endreTimebestilling() {
  include("db.php");
  $timebestillingnr = mysqli_real_escape_string($conn, $_POST["velgTidspunkt"]);
  $dato = mysqli_real_escape_string($conn, $_POST["endringDato"]);
  $tidspunkt = mysqli_real_escape_string($conn, $_POST["endringTidspunkt"]);
  $brukernavn = mysqli_real_escape_string($conn, $_POST["endringBehandler"]);
  $personnr = mysqli_real_escape_string($conn, $_SESSION["personnr"]);
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

function visTimebestilling() {
  include("db.php");
  if(!isset($_SESSION["personnr"])) {
    session_start();
  }
  $innloggetBruker = $_SESSION["personnr"];
  if(!$innloggetBruker) {
    echo "Ingen bruker funnet. Logg inn på nytt";
  } else {
    $sql = "SELECT t.dato, t.tidspunkt, b.behandlernavn, p.pasientnavn
    FROM timebestilling AS t
    LEFT JOIN behandler AS b ON t.brukernavn = b.brukernavn
    LEFT JOIN pasient AS p ON t.personnr = p.personnr
    WHERE t.personnr='$innloggetBruker'
    ORDER BY dato";
    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) > 0) {
      while($row = mysqli_fetch_assoc($result)) {
        echo "<tr>\n";
        echo "<td>" . htmlspecialchars($row['pasientnavn']) . "</td>\n";
        echo "<td>" . htmlspecialchars($row['dato']) . "</td>\n";
        echo "<td>" . htmlspecialchars($row['tidspunkt']) . "</td>\n";
        echo "<td>" . htmlspecialchars($row['behandlernavn']) . "</td>\n";
        echo "</tr>\n";
      }
    }
    else {
      echo "<tr><td>Ingen timebestillinger funnet</td></tr>\n";
    }
  }

  mysqli_close($conn);
}

include("db.php");
if(@$_GET["action"] == "loggut") {
  session_destroy();
  echo "<meta http-equiv=\"refresh\" content=\"0;URL=index.php\">";
}

if(@$_GET["action"] == "registrerbruker") {
  include("listeboks.php");
  echo "<div class=\"form-group\">\n";
  echo "<h2>Registrering</h2>\n";
  echo "<form method=\"post\" action=\"\">\n";
  echo "<div class=\"row\">\n";
  echo "<div class=\"col-md-3\"><label>Personnr</label></div><div class=\"col-md-5\"><input type=\"text\" class=\"form-control\" name=\"regPersonnr\" required /></div>\n";
  echo "</div><div class=\"row\">\n";
  echo "<div class=\"col-md-3\"><label>Navn</label></div><div class=\"col-md-5\"><input type=\"text\" class=\"form-control\" name=\"regNavn\" required /></div>\n";
  echo "</div><div class=\"row\">\n";
  echo "<div class=\"col-md-3\"><label>Ønsket fastlege</label></div><div class=\"col-md-5\">\n";
  echo "<select class=\"form-control\" id=\"regBehandler\" name=\"regBehandler\">\n";
  echo "<option>Hvem ønsker du som fastlege?</option>\n";
  listeboksBehandler();
  echo "</select></div>\n";
  echo "</div><div class=\"row\">\n";
  echo "<div class=\"col-md-3\"><label>Passord</label></div><div class=\"col-md-5\"><input type=\"password\" class=\"form-control\" name=\"regPassord\" required /></div>\n";
  echo "</div><div class=\"row\">\n";
  echo "<div class=\"col-md-3\"><label>&nbsp;</label></div><div class=\"col-md-5\"><input class=\"btn btn-default btn-lg\" type=\"submit\" value=\"Registrer\" name=\"submitRegBruker\"></div>\n";
  echo "</div>\n";
  echo "</div>\n";
  echo "</form>\n";
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
    $sql = "SELECT tidspunkt
    FROM timeinndeling
    WHERE tidspunkt NOT IN ( 
    SELECT DISTINCT tidspunkt 
      FROM timebestilling
      WHERE dato='$dato' )";
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
  if(!isset($_SESSION["personnr"])) {
    session_start();
  }
  $personnr = mysqli_real_escape_string($conn, $_SESSION["personnr"]);
  $sql = "SELECT * FROM timebestilling WHERE personnr='$personnr'";
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
  if(!isset($_SESSION["personnr"])) {
    session_start();
  }
  $timebestillingnr = mysqli_real_escape_string($conn, $_GET["velgTidspunkt"]);
  $sql = "SELECT t.timebestillingnr, t.dato, t.tidspunkt, t.brukernavn, b.behandlernavn, p.pasientnavn
  FROM timebestilling AS t
  LEFT JOIN behandler AS b ON t.brukernavn = b.brukernavn
  LEFT JOIN pasient AS p ON t.personnr = p.personnr
  WHERE timebestillingnr='$timebestillingnr'";
  $result = mysqli_query($conn, $sql);

  while($row = mysqli_fetch_assoc($result)) {
    echo "<hr/>\n";
    echo "<div class=\"row\">\n";
    echo "<div class=\"col-md-3\">Behandler</div>\n";
    echo "<div class=\"col-md-5\"><select class=\"form-control\" id=\"endringBehandler\" name=\"endringBehandler\" onchange=\"listeboksVisLedigTimebestillingBehandler(this.value)\">\n";
    $sql2 = "SELECT brukernavn, behandlernavn, yrkesgruppenavn FROM behandler
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

    echo "</select></div>\n";
    echo "</div>\n";
    echo "<div class=\"row\">\n";
    echo "<div class=\"col-md-3\">Dato</div>\n";
    echo "<div class=\"col-md-5\"><input type=\"text\" class=\"form-control\" id=\"endringDato\" name=\"endringDato\" onkeyup=\"listeboksVisLedigTimebestillingDato(this.value)\" value=\"". htmlspecialchars($row['dato']) ."\" required/></div>\n";
    echo "</div>\n";
    echo "<div class=\"row\">\n";
    echo "<div class=\"col-md-3\">Tidspunkt</div>\n";
    echo "<div class=\"col-md-5\"><select class=\"form-control\" id=\"endringTidspunkt\" name=\"endringTidspunkt\">\n";
    echo "<option>-Velg behandler og dato-</option>\n";
    echo "</select></div>\n";
    echo "</div>\n";
    echo "<div class=\"row\">\n";
    echo "<div class=\"col-md-3\">&nbsp;</div>\n";
    echo "<div class=\"col-md-5\"><input class=\"btn btn-primary btn-lg\" type=\"submit\" name=\"submitEndreTimebestilling\" value=\"Endre &raquo;\"></div>\n";
    echo "</div>\n";
    echo "</form>\n";
    echo "</div>\n";
  }

  mysqli_close($conn);
}
?>