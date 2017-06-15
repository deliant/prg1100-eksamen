<?php
function visBilde() {
  include("db.php");
  $sql = "SELECT * FROM bilde";
  $result = mysqli_query($conn, $sql);

  if(mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
      echo "<tr>\n";
      echo "<td><img class=\"thumbnail-bilde\" src=\"http://home.hbv.no/phptemp/web-prg11v10/". htmlspecialchars($row['filnavn']) ."\"></td>\n";
      echo "<td>". htmlspecialchars($row['bildenr']) ."</td>\n";
      echo "<td>". htmlspecialchars($row['beskrivelse']) ."</td>\n";
      echo "<td>". htmlspecialchars($row['opplastingsdato']) ."</td>\n";
      echo "<td>". htmlspecialchars($row['filnavn']) ."</td>\n";
      echo "</tr>\n";
    }
  } else {
    echo "<tr><td>Ingen bilder funnet</td><td>&nbsp;</td></tr>\n";
  }

  mysqli_close($conn);
}

function registrerBilde() {
  include("db.php");
  $filnavn = basename($_FILES["regFilnavn"]["name"]);
  $beskrivelse = mysqli_real_escape_string($conn, $_POST["regBeskrivelse"]);
  $dato = date("Y-m-d");

  // Sjekk at tekstfeltene har input
  if(!empty($filnavn) && !empty($beskrivelse)) {
    // Sett inn i databasen
    $sql = "INSERT INTO bilde (opplastingsdato, filnavn, beskrivelse)
    VALUES ('$dato', '$filnavn', '$beskrivelse')";

    if(mysqli_query($conn, $sql)) {
      echo "<div class=\"alert alert-success\">$beskrivelse registrert i bilde databasen.</div>\n";
      echo "<meta http-equiv=\"refresh\" content=\"0\">\n";
    } else {
      echo "<div class=\"alert alert-danger\">Feil under database forespørsel: ". mysqli_error($conn) ."</div>\n";
    }
  } else {
    echo "<div class=\"alert alert-danger\" align=\"top\">Fyll ut alle felt. Registrering ikke godkjent</div>\n";
  }

  mysqli_close($conn);
}

function endreBilde() {
  include("db.php");
  $bildenr = mysqli_real_escape_string($conn, $_POST["endringBildenr"]);
  $beskrivelse = mysqli_real_escape_string($conn, $_POST["endringBeskrivelse"]);

  if(!empty($bildenr) && !empty($beskrivelse)) {
    $sql = "UPDATE bilde SET beskrivelse='$beskrivelse' WHERE bildenr='$bildenr'";

    if(mysqli_query($conn, $sql)) {
      echo "<div class=\"alert alert-success\">Databasen oppdatert.</div>\n";
      echo "<meta http-equiv=\"refresh\" content=\"0\"\n>";
    } else {
      echo "<div class=\"alert alert-danger\">Feil under database forespørsel: ". mysqli_error($conn) ."</div>\n";
    }
  } else {
    echo "<div class=\"alert alert-danger\" align=\"top\">Fyll ut alle felt. Endring ikke godkjent</div>\n";
  }

  mysqli_close($conn);
}

function slettBilde() {
  include("db.php");
  $bildenr = mysqli_real_escape_string($conn, $_POST["slettBildenr"]);

  if(!empty($bildenr) && $bildenr != "NULL") {
    // Sjekk at bildet ikke brukes
    $sql = "SELECT brukernavn FROM behandler WHERE bildenr='$bildenr'";
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result) > 0) {
      echo "<div class=\"alert alert-danger\">Kan ikke slette bilde når det brukes av behandler.</div>\n";
    } else {
      $sql = "SELECT filnavn FROM bilde WHERE bildenr='$bildenr'";
      $result = mysqli_query($conn, $sql);
      $row = mysqli_fetch_assoc($result);
      $filbane = "D:\\Sites\\home.hbv.no\\phptemp\\web-prg11v10/" . $row["filnavn"];

      if(is_writable($filbane)) {
        if(unlink($filbane)) {
          $slettBildeOk = 1;
          echo "<div class=\"alert alert-sucess\">Bildefil " . $row['filnavn'] . " slettet.</div>\n";
        } else {
          $slettBildeOk = 0;
          echo "<div class=\"alert alert-danger\">Bildefil kunne ikke slettes automatisk.</div>\n";
        }
      }

      if($slettBildeOk == 1) {
        $sql = "DELETE FROM bilde WHERE bildenr='$bildenr'";
        if(mysqli_query($conn, $sql)) {
          echo "<div class=\"alert alert-success\">Databasen oppdatert.</div>\n";
          echo "<meta http-equiv=\"refresh\" content=\"0\">\n";
        } else {
          echo "<div class=\"alert alert-danger\">Feil under database forespørsel: ". mysqli_error($conn) ."</div>\n";
        }
      }
    }
  }

  mysqli_close($conn);
}

include("db.php");
if(@$_GET["action"] == "endre") {
  $bildenr = mysqli_real_escape_string($conn, $_GET["bildenr"]);
  $sql = "SELECT bildenr, beskrivelse FROM bilde WHERE bildenr='$bildenr'";
  $result = mysqli_query($conn, $sql);

  while($row = mysqli_fetch_assoc($result)) {
    echo "<h3>Endring</h3>\n";
    echo "<form action=\"\" method=\"post\" onsubmit=\"return validerBildeEndring()\">\n";
    echo "<label>Bildenr</label><input type=\"text\" name=\"endringBildenr\"  value=\"". htmlspecialchars($row['bildenr']) ."\" readonly required/><br/>\n";
    echo "<label>Beskrivelse</label><input type=\"text\" id=\"endringBeskrivelse\" name=\"endringBeskrivelse\"  value=\"". htmlspecialchars($row['beskrivelse']) ."\" required/><br/>\n";
    echo "<label>&nbsp;</label><input class=\"btn btn-primary\" type=\"submit\" value=\"Endre\" name=\"submitEndreBilde\">\n";
    echo "</form>\n";
  }
  mysqli_close($conn);
}
?>