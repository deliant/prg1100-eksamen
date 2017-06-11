<?php
function visPasient() {
  include("db.php");
  $sql = "SELECT p.personnr, p.pasientnavn, b.behandlernavn
  FROM pasient AS p
  LEFT JOIN behandler AS b ON p.brukernavn = b.brukernavn
  ORDER BY pasientnavn";
  $result = mysqli_query($conn, $sql);

  if(mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
      echo "<tr>\n";
      echo "<td>". htmlspecialchars($row['personnr']) ."</td>\n";
      echo "<td>". htmlspecialchars($row['pasientnavn']) ."</td>\n";
      echo "<td>". htmlspecialchars($row['behandlernavn']) ."</td>\n";
      echo "</tr>\n";
    }
  } else {
    echo "<tr><td>Ingen pasienter funnet</td></tr>\n";
  }

  mysqli_close($conn);
}

function registrerPasient() {
  include("db.php");
  $personnr = mysqli_real_escape_string($conn, $_POST["regPersonnr"]);
  $navn = mysqli_real_escape_string($conn, $_POST["regNavn"]);
  $brukernavn = mysqli_real_escape_string($conn, $_POST["velgFastlege"]);

  // Sjekk at tekstfeltene har input
  if(!empty($personnr) && !empty($navn) && !empty($brukernavn)) {
    // Sett inn i databasen
    $sql = "INSERT INTO pasient (personnr, pasientnavn, brukernavn)
    VALUES ('$personnr', '$navn', '$brukernavn')";

    if(mysqli_query($conn, $sql)) {
      echo "<div class=\"alert alert-success\">$navn ($personnr) registrert i pasient databasen.</div>\n";
      echo "<meta http-equiv=\"refresh\" content=\"1\">\n";
    } else {
      echo "<div class=\"alert alert-danger\">Feil under database forespørsel: ". mysqli_error($conn) ."</div>\n";
    }
  }

  mysqli_close($conn);
}

function endrePasient() {
  include("db.php");
  $personnr = mysqli_real_escape_string($conn, $_POST["endringPersonnr"]);
  $navn = mysqli_real_escape_string($conn, $_POST["endringNavn"]);
  @$passord = mysqli_real_escape_string($conn, $_POST["endringPassord"]);
  $brukernavn = mysqli_real_escape_string($conn, $_POST["endringFastlege"]);

  if(!empty($personnr) && !empty($navn) && !empty($brukernavn)) {
    if(isset($passord) && !empty($passord)) {
      $kryptert_passord = password_hash($passord, PASSWORD_DEFAULT);
      $sql = "UPDATE pasient SET pasientnavn='$navn', passord='$kryptert_passord' brukernavn='$brukernavn' WHERE personnr='$personnr'";
    } else {
      $sql = "UPDATE pasient SET pasientnavn='$navn', brukernavn='$brukernavn' WHERE personnr='$personnr'";
    }

    if(mysqli_query($conn, $sql)) {
      echo "<div class=\"alert alert-success\">Databasen oppdatert.</div>\n";
      echo "<meta http-equiv=\"refresh\" content=\"1\">\n";
    } else {
      echo "<div class=\"alert alert-danger\">Feil under database forespørsel: ". mysqli_error($conn) ."</div>\n";
    }
  }

  mysqli_close($conn);
}

function slettPasient() {
  include("db.php");
  $personnr = mysqli_real_escape_string($conn, $_POST["slettPasient"]);

  if(!empty($personnr) && $personnr != "NULL") {
    $slettPasientOk = 1;
    // Slett timebestillinger hvis checkbox er på
    if(isset($_POST["checkboxtimebestilling"])) {
      $sql = "DELETE FROM timebestilling WHERE personnr='$personnr'";
      mysqli_query($conn, $sql) or die("<div class=\"alert alert-danger\">Feil under database forespørsel: ". mysqli_error($conn) ."</div>");
    }

    // Sjekk om pasient har timebestilling
    $sql = "SELECT personnr FROM timebestilling WHERE personnr='$personnr'";
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result) > 0) {
      echo "<div  class=\"alert alert-danger\" align=\"top\">Kan ikke slette pasient når det finnes aktive timebestillinger.</div>\n";
      $slettPasientOk = 0;
    }

    if($slettPasientOk == 1) {
      $sql = "DELETE FROM pasient WHERE personnr='$personnr'";

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
if(@$_GET["action"] == "endre") {
  $personnr = mysqli_real_escape_string($conn, $_GET["personnr"]);
  $sql = "SELECT p.personnr, p.pasientnavn, p.brukernavn, b.behandlernavn
  FROM pasient AS p
  LEFT JOIN behandler AS b ON p.brukernavn = b.brukernavn
  WHERE personnr='$personnr'
  ORDER BY pasientnavn";
  $result = mysqli_query($conn, $sql);

  while($row = mysqli_fetch_assoc($result)) {
    echo "<h3>Endring</h3>\n";
    echo "<form action=\"\" method=\"post\">\n";
    echo "<label>Personnr</label><input type=\"text\" name=\"endringPersonnr\" value=\"" . htmlspecialchars($row['personnr']) . "\" readonly required/><br/>\n";
    echo "<label>Navn</label><input type=\"text\" name=\"endringNavn\" value=\"" . htmlspecialchars($row['pasientnavn']) ."\" required/><br/>\n";
    echo "<label>Passord</label><input type=\"password\" name=\"endringPassord\" /><br/>\n";
    echo "<label>Fastlege</label><select name=\"endringFastlege\">\n";
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

    echo "</select><br/>\n";
    echo "<label>&nbsp;</label><input class=\"btn btn-primary\" type=\"submit\" value=\"Endre\" name=\"submitEndrePasient\">\n";
    echo "</form>\n";
  }

  mysqli_close($conn);
}
?>