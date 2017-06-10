<?php
function visBilde() {
  include("db.php");
  $sql = "SELECT * FROM bilde";
  $result = mysqli_query($conn, $sql);

  if(mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
      echo "<tr>\n";
      echo "<td><img class=\"thumbnail\" src=\"../bilder/". htmlspecialchars($row['filnavn']) ."\"></td>\n";
      echo "<td>". htmlspecialchars($row['bildenr']) ."</td>\n";
      echo "<td>". htmlspecialchars($row['opplastingsdato']) ."</td>\n";
      echo "<td>". htmlspecialchars($row['filnavn']) ."</td>\n";
      echo "<td>". htmlspecialchars($row['beskrivelse']) ."</td>\n";
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
      echo "$beskrivelse registrert i bilde databasen.";
      echo "<meta http-equiv=\"refresh\" content=\"1\">";
    } else {
      echo "Feil under database forespørsel: " . mysqli_error($conn);
    }
    mysqli_close($conn);
  }
}

function endreBilde() {
  include("db.php");
  $bildenr = mysqli_real_escape_string($conn, $_POST["endringBildenr"]);
  $beskrivelse = mysqli_real_escape_string($conn, $_POST["endringBeskrivelse"]);
  if(!empty($bildenr) && !empty($beskrivelse)) {
    $sql = "UPDATE bilde SET beskrivelse='$beskrivelse' WHERE bildenr='$bildenr'";

    if(mysqli_query($conn, $sql)) {
      echo "Databasen oppdatert.<br/>";
      echo "<meta http-equiv=\"refresh\" content=\"1\">";
    } else {
      echo "Feil under database forespørsel: " . mysqli_error($conn);
    }
  }
  mysqli_close($conn);
}

function slettBilde() {
  include("db.php");
  $bildenr = mysqli_real_escape_string($conn, $_POST["slettBildenr"]);
  if(!empty($bildenr)) {
    // Sjekk at bildet ikke brukes
    $sql = "SELECT brukernavn FROM behandler WHERE bildenr='$bildenr'";
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result) > 0) {
      echo "Kan ikke slette bilde når det brukes av behandler.<br/>";
    } else {
      $sql = "SELECT filnavn FROM bilde WHERE bildenr='$bildenr'";
      $result = mysqli_query($conn, $sql);
      $row = mysqli_fetch_assoc($result);
      $filbane = "../bilder/" . $row['filnavn'];

      if(is_writable($filbane)) {
        if(unlink($filbane)) {
          $slettOk = 1;
          echo "Bildefil " . $row['filnavn'] . " slettet.<br/>";
        } else {
          $slettOk = 0;
          echo "Bildefil kunne ikke slettes automatisk.<br/>";
        }
      }
      if($slettOk == 1) {
        $sql = "DELETE FROM bilde WHERE bildenr='$bildenr'";
        if(mysqli_query($conn, $sql)) {
          echo "Databasen oppdatert.<br />";
          echo "<meta http-equiv=\"refresh\" content=\"1\">";
        } else {
          echo "Feil under database forespørsel: " . mysqli_error($conn);
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

  while($row = mysqli_fetch_array($result)) {
    echo "<h3>Endring</h3>\n";
    echo "<form action=\"\" method=\"post\">\n";
    echo "<label>Bildenr</label><input type=\"text\" name=\"endringBildenr\"  value=\"". htmlspecialchars($row['bildenr']) ."\" readonly required/><br/>\n";
    echo "<label>Beskrivelse</label><input type=\"text\" name=\"endringBeskrivelse\"  value=\"". htmlspecialchars($row['beskrivelse']) ."\" required/><br/>\n";
    echo "<label>&nbsp;</label><input class=\"btn btn-primary\" type=\"submit\" value=\"Endre\" name=\"submitEndreBilde\"><br/><br/>\n";
    echo "</form>\n";
  }
  mysqli_close($conn);
}
?>