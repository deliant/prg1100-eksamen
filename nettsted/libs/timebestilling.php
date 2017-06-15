<?php
function registrerTimebestilling() {
  include("db.php");
  if(!isset($_SESSION["personnr"])) {
    echo "<div class=\"alert alert-danger\" align=\"top\">Vennligst <a href=\"minside.php\">logg inn</a> for å bestille time</div>\n";
  } else {
    $brukernavn = mysqli_real_escape_string($conn, $_POST["regBehandler"]);
    $personnr = mysqli_real_escape_string($conn, $_SESSION["personnr"]);
    $dato = mysqli_real_escape_string($conn, $_POST["regDato"]);
    $tidspunkt = mysqli_real_escape_string($conn, $_POST["regTidspunkt"]);
    setlocale(LC_TIME, "no");
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
          echo "<div class=\"alert alert-success\" align=\"top\">" . $row['pasientnavn'] . " registrert til time $dato kl. $tidspunkt i timebestilling databasen.</div>\n";
          echo "<meta http-equiv=\"refresh\" content=\"1\">\n";
        }
        else {
          echo "<div class=\"alert alert-danger\" align=\"top\">Feil under database forespørsel: " . mysqli_error($conn) . "</div>\n";
        }
      }
    }

    mysqli_close($conn);
  }
}

if(@$_GET["action"] == "listeboksReg") {
  include("db.php");
  $brukernavn = mysqli_real_escape_string($conn, $_GET["regBehandler"]);
  $dato = mysqli_real_escape_string($conn, $_GET["regDato"]);
  setlocale(LC_TIME, "no");
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
      WHERE dato='$dato')
    AND brukernavn='$brukernavn'
    AND ukedag='$ukedag'
    GROUP BY tidspunkt";

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
?>