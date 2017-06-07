<?php
function visBilde() {
  include("db.php");
  $sql = "SELECT * FROM bilde";
  $result = mysqli_query($conn, $sql);

  if(mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
      echo "<tr>\n";
      echo "<td>". htmlspecialchars($row['bildenr']) ."</td>\n";
      echo "<td>". htmlspecialchars($row['opplastingsdato']) ."</td>\n";
      echo "<td>". htmlspecialchars($row['filnavn']) ."</td>\n";
      echo "<td>". htmlspecialchars($row['beskrivelse']) ."</td>\n";
      echo "<td><form action=". $_SERVER['PHP_SELF'] ." method=\"post\">\n";
      echo "<input type=\"hidden\" name=\"edit_id\" value=". htmlspecialchars($row['bildenr']) ." />\n";
      echo "<button class=\"btn btn-primary btn-xs\" type=\"submit\" title=\"Endre\"><span class=\"glyphicon glyphicon-edit\"></span></button>\n";
      echo "</form></td>\n";
      echo "<td><form action=". $_SERVER['PHP_SELF'] ." method=\"post\">\n";
      echo "<input type=\"hidden\" name=\"delete_id\" value=". htmlspecialchars($row['bildenr']) ." />\n";
      echo "<button class=\"btn btn-danger btn-xs\" type=\"submit\" title=\"Slett\"><span class=\"glyphicon glyphicon-trash\"></span></button>\n";
      echo "</form></td>\n";
      echo "</tr>\n";
    }
  } else {
    echo "<tr><td>Ingen bilder funnet</td><td>&nbsp;</td></tr>\n";
  }
  mysqli_close($conn);
}

function registrerBilde() {
  include("db.php");
  $filnavn = basename($_FILES["filnavn"]["name"]);
  $beskrivelse = mysqli_real_escape_string($conn, $_POST["beskrivelse"]);
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

function velgBilde() {
  include("db.php");
  if(isset($_POST["velgBildenr"])) {
    $bildenr = mysqli_real_escape_string($conn, $_POST["velgBildenr"]);
  }
  else if(isset($_POST["edit_id"])) {
    $bildenr = mysqli_real_escape_string($conn, $_POST["edit_id"]);
  }
  $sql = "SELECT * FROM bilde WHERE bildenr='$bildenr'";
  $result = mysqli_query($conn, $sql);
  $row = mysqli_fetch_assoc($result);
  // Validering; onsubmit="return validerRegistrerBehandlerdata()"
  echo "<p>\n";
  echo "<form method=\"post\" name=\"updatebilde\" action=". $_SERVER['PHP_SELF'] .">\n";
  echo "<label>Bildenr</label><input type=\"text\" name=\"bildenr\" value='" . htmlspecialchars($row['bildenr']) . "' readonly required /><br/>\n";
  echo "<label>Beskrivelse</label><input type=\"text\" name=\"beskrivelse\" value='" . htmlspecialchars($row['beskrivelse']) . "' required /><br/>\n";
  echo "<label>&nbsp;</label><input class=\"btn btn-primary\" type=\"submit\" value=\"Endre\" name=\"submitEndreBilde\"><br/><br/>\n";
  echo "</form>\n";
  echo "</p>\n";
  mysqli_close($conn);
}

function endreBilde() {
  include("db.php");
  $bildenr = mysqli_real_escape_string($conn, $_POST["bildenr"]);
  $beskrivelse = mysqli_real_escape_string($conn, $_POST["beskrivelse"]);
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
  if(isset($_POST["velgBildenrSlett"])) {
    $bildenr = mysqli_real_escape_string($conn, $_POST["velgBildenrSlett"]);
  }
  else if(isset($_POST["delete_id"])) {
    $bildenr = mysqli_real_escape_string($conn, $_POST["delete_id"]);
  }
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
?>