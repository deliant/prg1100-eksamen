<?php
function getTimebestillingnr() {
  include("db.php");
  @$dato = mysqli_real_escape_string($conn, $_POST["dato"]);
  @$tidspunkt = mysqli_real_escape_string($conn, $_POST["tidspunkt"]);
  @$brukernavn = mysqli_real_escape_string($conn, $_POST["behandler"]);
  @$personnr = mysqli_real_escape_string($conn, $_POST["pasient"]);
  $sql = "SELECT timebestillingnr FROM timebestilling WHERE dato='$dato' AND tidspunkt='$tidspunkt' AND brukernavn='$brukernavn' AND personnr='$personnr'";
  $result = mysqli_query($conn, $sql);

  if(mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    return $row['timebestillingnr'];
  }
}

function visTimebestilling() {
  include("db.php");
  $sql = "SELECT * FROM timebestilling";
  $result = mysqli_query($conn, $sql);

  if(mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
      echo "<tr>\n";
      echo "<td>". htmlspecialchars($row['dato']) ."</td>\n";
      echo "<td>". htmlspecialchars($row['tidspunkt']) ."</td>\n";
      echo "<td>". htmlspecialchars($row['brukernavn']) ."</td>\n";
      echo "<td>". htmlspecialchars($row['personnr']) ."</td>\n";
      echo "<td><form>\n";
      echo "<button class=\"btn btn-primary btn-xs\" type=\"submit\" onclick=\"endreTimebestilling(". htmlspecialchars($row['timebestillingnr']) .") title=\"Endre\"><span class=\"glyphicon glyphicon-edit\"></span></button>\n";
      echo "</form></td>\n";
      echo "<td><form action=". $_SERVER['PHP_SELF'] ." method=\"post\">\n";
      echo "<input type=\"hidden\" name=\"delete_id\" value=". htmlspecialchars($row['timebestillingnr']) ." />\n";
      echo "<button class=\"btn btn-danger btn-xs\" type=\"submit\" title=\"Slett\"><span class=\"glyphicon glyphicon-trash\"></span></button>\n";
      echo "</form></td>\n";
      echo "</tr>\n";
    }
  } else {
    echo "<tr><td>Ingen timebestillinger funnet</td></tr>\n";
  }
  mysqli_close($conn);
}

function registrerTimebestilling() {
  include("db.php");
  $brukernavn = mysqli_real_escape_string($conn, $_POST["velgBehandler"]);
  $personnr = mysqli_real_escape_string($conn, $_POST["velgPasient"]);
  $dato = mysqli_real_escape_string($conn, $_POST["regdato"]);
  $tidspunkt = mysqli_real_escape_string($conn, $_POST["regtidspunkt"]);
  // Sjekk at tekstfeltene har input
  if(!empty($brukernavn) && !empty($personnr) && !empty($dato) && !empty($tidspunkt)) {
    // Sett inn i databasen
    $sql = "INSERT INTO timebestilling (dato, tidspunkt, brukernavn, personnr)
    VALUES ('$dato', '$tidspunkt', '$brukernavn', '$personnr')";

    if(mysqli_query($conn, $sql)) {
      echo "$personnr registrert til time $dato kl. $tidspunkt i timebestilling databasen.";
      echo "<meta http-equiv=\"refresh\" content=\"1\">";
    } else {
      echo "Feil under database forespørsel: " . mysqli_error($conn);
    }
    mysqli_close($conn);
  }
}

function endreTimebestilling() {
  include("db.php");
  if(isset($_POST["timebestillingnr"])) {
    $timebestillingnr = mysqli_real_escape_string($conn, $_POST["timebestillingnr"]);
  }
  else if(isset($_POST["edit_id"])) {
    $timebestillingnr = mysqli_real_escape_string($conn, $_POST["edit_id"]);
  }
  $dato = mysqli_real_escape_string($conn, $_POST["dato"]);
  $tidspunkt = mysqli_real_escape_string($conn, $_POST["tidspunkt"]);
  $brukernavn = mysqli_real_escape_string($conn, $_POST["behandler"]);
  $personnr = mysqli_real_escape_string($conn, $_POST["pasient"]);
  if(!empty($timebestillingnr) && !empty($dato) && !empty($tidspunkt) && !empty($brukernavn) && !empty($personnr)) {
    $sql = "UPDATE timebestilling SET dato='$dato', tidspunkt='$tidspunkt', brukernavn='$brukernavn', personnr='$personnr' WHERE timebestillingnr='$timebestillingnr'";

    if(mysqli_query($conn, $sql)) {
      echo "Databasen oppdatert.<br/>";
      echo "<meta http-equiv=\"refresh\" content=\"1\">";
    } else {
      echo "Feil under database forespørsel: " . mysqli_error($conn);
    }
  }
  mysqli_close($conn);
}

function slettTimebestilling() {
  include("db.php");
  if(isset($_POST["timebestillingnr"])) {
    $timebestillingnr = mysqli_real_escape_string($conn, $_POST["timebestillingnr"]);
  }
  else if(isset($_POST["edit_id"])) {
    $timebestillingnr = mysqli_real_escape_string($conn, $_POST["edit_id"]);
  }
  /* Kan ikke slette om pasient har booket time?
  $sql = "SELECT bildenr FROM behandler WHERE brukernavn='$behandler'";
  $result = mysqli_query($conn, $sql);

  if(mysqli_num_rows($result) > 0) {
    echo "Kan ikke slette behandler når bilde er valgt.<br />";
  } else {
  */
  if(!empty($timebestillingnr)) {
    $sql = "DELETE FROM timebestilling WHERE timebestillingnr='$timebestillingnr'";

    if (mysqli_query($conn, $sql)) {
      echo "Databasen oppdatert.<br/><br />";
      echo "<meta http-equiv=\"refresh\" content=\"1\">";
    } else {
      echo "Feil under database forespørsel: " . mysqli_error($conn);
    }
  }
  mysqli_close($conn);
}

include("db.php");
if(@$_GET["action"] == "listeboks") {
  $personnr = mysqli_real_escape_string($conn, $_GET["pasient"]);
  $brukernavn = mysqli_real_escape_string($conn, $_GET["behandler"]);
  $sql = "SELECT * FROM timebestilling WHERE brukernavn='$brukernavn' AND personnr='$personnr'";
  $result = mysqli_query($conn, $sql);

  if(mysqli_num_rows($result) > 0) {
    echo "<option selected=\"selected\">-Velg tidspunkt-</option>";
    while($row = mysqli_fetch_assoc($result)) {
      echo "<option value=" . htmlspecialchars($row['timebestillingnr']) . ">". htmlspecialchars($row['dato']) ." kl.". htmlspecialchars($row['tidspunkt']) ."</option>\n";
    }
  } else {
    echo "<option value=\"NULL\">Ingen timebestillinger funnet</option>\n";
  }
}

if(@$_GET["action"] == "endre") {
  $timebestillingnr = mysqli_real_escape_string($conn, $_GET["timebestillingnr"]);
  $sql = "SELECT t.timebestillingnr, t.dato, t.tidspunkt, t.brukernavn, b.behandlernavn, t.personnr, p.pasientnavn
  FROM timebestilling AS t
  LEFT JOIN behandler AS b ON t.brukernavn = b.brukernavn
  LEFT JOIN pasient AS p ON t.personnr = p.personnr
  ORDER BY t.dato";
  $result = mysqli_query($conn, $sql);

  while($row = mysqli_fetch_array($result)) {
    echo "<h3>Endring</h3>\n";
    echo "<form method=\"post\" name=\"updatetimebestilling\" action=". $_SERVER['PHP_SELF'] .">\n";
    echo "<label>Pasient</label><select name=\"pasient\">\n";
    $sql2 = "SELECT personnr, pasientnavn FROM pasient ORDER BY pasientnavn";
    $result2 = mysqli_query($conn, $sql2);

    if(mysqli_num_rows($result2) > 0) {
      while($row2 = mysqli_fetch_assoc($result2)) {
        if($row2['personnr'] === $row['personnr']) {
          echo "<option value=". htmlspecialchars($row2['personnr']) ." selected=\"selected\">". htmlspecialchars($row2['personnr']) ." - ". htmlspecialchars($row2['pasientnavn']) ."</option>\n";
        } else {
          echo "<option value=". htmlspecialchars($row2['personnr']) .">". htmlspecialchars($row2['personnr']) ." - ". htmlspecialchars($row2['pasientnavn']) ."</option>\n";
        }
      }
    } else {
      echo "<option value=\"NULL\">Ingen pasienter funnet</option>\n";
    }
    echo "</select><br/>\n";
    echo "<label>Behandler</label><select name=\"behandler\">\n";
    $sql3 = "SELECT brukernavn, behandlernavn, yrkesgruppe FROM behandler";
    $result3 = mysqli_query($conn, $sql3);

    if(mysqli_num_rows($result3) > 0) {
      while($row3 = mysqli_fetch_assoc($result3)) {
        if($row3['brukernavn'] === $row['brukernavn']) {
          echo "<option value=". htmlspecialchars($row3['brukernavn']) ." selected=\"selected\">". htmlspecialchars($row3['behandlernavn']) ." - ". htmlspecialchars($row3['yrkesgruppe']) ."</option>\n";
        } else {
          echo "<option value=". htmlspecialchars($row3['brukernavn']) .">". htmlspecialchars($row3['behandlernavn']) ." - ". htmlspecialchars($row3['yrkesgruppe']) ."</option>\n";
        }
      }
    } else {
      echo "<option value=\"NULL\">Ingen behandlere funnet</option>\n";
    }
    echo "</select><br/>\n";
    echo "<label>Dato</label><input type=\"text\" id=\"dato\"  name=\"dato\" value=". $row['dato'] ." required/><br/>\n";
    echo "<label>Tidspunkt</label><input type=\"text\" name=\"tidspunkt\"  value=". $row['tidspunkt'] ." required/><br/>\n";
    echo "<label>&nbsp;</label><input class=\"btn btn-primary\" type=\"submit\" value=\"Endre\" name=\"submitEndreTimebestilling\"><br/><br/>\n";
    echo "</form>\n";
  }
  mysqli_close($conn);
}
?>