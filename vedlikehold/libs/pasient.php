<?php
function visPasient() {
  include("db.php");
  $sql = "SELECT personnr, pasientnavn, fastlege FROM pasient";
  $result = mysqli_query($conn, $sql);

  if(mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
      echo "<tr>\n";
      echo "<td>". htmlspecialchars($row['personnr']) ."</td>\n";
      echo "<td>". htmlspecialchars($row['pasientnavn']) ."</td>\n";
      echo "<td>". htmlspecialchars($row['fastlege']) ."</td>\n";
      echo "<td><form action=". $_SERVER['PHP_SELF'] ." method=\"post\">\n";
      echo "<input type=\"hidden\" name=\"edit_id\" value=". htmlspecialchars($row['personnr']) ." />\n";
      echo "<button class=\"btn btn-primary btn-xs\" type=\"submit\" title=\"Endre\"><span class=\"glyphicon glyphicon-edit\"></span></button>\n";
      echo "</form></td>\n";
      echo "<td><form action=". $_SERVER['PHP_SELF'] ." method=\"post\">\n";
      echo "<input type=\"hidden\" name=\"delete_id\" value=". htmlspecialchars($row['personnr']) ." />\n";
      echo "<button class=\"btn btn-danger btn-xs\" type=\"submit\" title=\"Slett\"><span class=\"glyphicon glyphicon-trash\"></span></button>\n";
      echo "</form></td>\n";
      echo "</tr>\n";
    }
  } else {
    echo "<tr><td>Ingen pasienter funnet</td></tr>\n";
  }
  mysqli_close($conn);
}

function registrerPasient() {
  include("db.php");
  $personnr = mysqli_real_escape_string($conn, $_POST["regpersonnr"]);
  $navn = mysqli_real_escape_string($conn, $_POST["regnavn"]);
  $fastlege = mysqli_real_escape_string($conn, $_POST["velgFastlege"]);
  // Sjekk at tekstfeltene har input
  if(!empty($personnr) && !empty($navn) && !empty($fastlege)) {
    // Sett inn i databasen
    $sql = "INSERT INTO pasient (personnr, pasientnavn, fastlege)
    VALUES ('$personnr', '$navn', '$fastlege')";

    if(mysqli_query($conn, $sql)) {
      echo "$navn ($personnr) registrert i pasient databasen.";
      echo "<meta http-equiv=\"refresh\" content=\"1\">";
    } else {
      echo "Feil under database forespørsel: " . mysqli_error($conn);
    }
    mysqli_close($conn);
  }
}

function velgPasient() {
  include("db.php");
  if(isset($_POST["velgPasient"])) {
    $personnr = mysqli_real_escape_string($conn, $_POST["velgPasient"]);
  }
  else if(isset($_POST["edit_id"])) {
    $personnr = mysqli_real_escape_string($conn, $_POST["edit_id"]);
  }
  $sql = "SELECT * FROM pasient WHERE personnr='$personnr'";
  $result = mysqli_query($conn, $sql);
  $row = mysqli_fetch_assoc($result);
  // Validering; onsubmit="return validerRegistrerBehandlerdata()"
  echo "<p>\n";
  echo "<form method=\"post\" name=\"updatepasient\" action=". $_SERVER['PHP_SELF'] .">\n";
  echo "<label>Personnr</label><input type=\"text\" name=\"personnr\" value='" . htmlspecialchars($row['personnr']) . "' readonly required /><br/>\n";
  echo "<label>Navn</label><input type=\"text\" name=\"navn\" value='" . htmlspecialchars($row['pasientnavn']) . "' required /><br/>\n";
  echo "<label>Passord</label><input type=\"password\" name=\"passord\" value='" . htmlspecialchars($row['passord']) . "'><br/>\n";
  echo "<label>Fastlege</label><select name=\"fastlege\">";
  $sql2 = "SELECT brukernavn FROM behandler";
  $result2 = mysqli_query($conn, $sql2);

  if(mysqli_num_rows($result2) > 0) {
    while($row2 = mysqli_fetch_assoc($result2)) {
      if($row2['brukernavn'] === $row['fastlege']) {
        echo "<option value=". htmlspecialchars($row2['brukernavn']) ." selected=\"selected\">". htmlspecialchars($row2['brukernavn']) ."</option>\n";
      } else {
        echo "<option value=". htmlspecialchars($row2['brukernavn']) .">". htmlspecialchars($row2['brukernavn']) ."</option>\n";
      }
    }
  } else {
    echo "<option value=\"NULL\">Ingen behandlere funnet</option>\n";
  }
  echo "</select><br/>\n";
  echo "<label>&nbsp;</label><input class=\"btn btn-primary\" type=\"submit\" value=\"Endre\" name=\"submitEndrePasient\"><br/><br/>\n";
  echo "</form>\n";
  echo "</p>\n";
  mysqli_close($conn);
}

function endrePasient() {
  include("db.php");
  $personnr = mysqli_real_escape_string($conn, $_POST["personnr"]);
  $navn = mysqli_real_escape_string($conn, $_POST["navn"]);
  $passord = mysqli_real_escape_string($conn, $_POST["passord"]);
  $fastlege = mysqli_real_escape_string($conn, $_POST["fastlege"]);
  if(!empty($personnr) && !empty($navn) && !empty($fastlege)) {
    $sql = "UPDATE pasient SET pasientnavn='$navn', fastlege='$fastlege' WHERE personnr='$personnr'";

    if(mysqli_query($conn, $sql)) {
      echo "Databasen oppdatert.<br/>";
      echo "<meta http-equiv=\"refresh\" content=\"1\">";
    } else {
      echo "Feil under database forespørsel: " . mysqli_error($conn);
    }
  }
  mysqli_close($conn);
}

function slettPasient() {
  include("db.php");
  if(isset($_POST["velgPasientSlett"])) {
    $personnr = mysqli_real_escape_string($conn, $_POST["velgPasientSlett"]);
  }
  else if(isset($_POST["delete_id"])) {
    $personnr = mysqli_real_escape_string($conn, $_POST["delete_id"]);
  }
  /* Kan ikke slette om pasient har booket time?
  $sql = "SELECT bildenr FROM behandler WHERE brukernavn='$behandler'";
  $result = mysqli_query($conn, $sql);

  if(mysqli_num_rows($result) > 0) {
    echo "Kan ikke slette behandler når bilde er valgt.<br />";
  } else {
  */
  if(!empty($personnr)) {
    $sql = "DELETE FROM pasient WHERE personnr='$personnr'";

    if (mysqli_query($conn, $sql)) {
      echo "Databasen oppdatert.<br/><br />";
      echo "<meta http-equiv=\"refresh\" content=\"1\">";
    } else {
      echo "Feil under database forespørsel: " . mysqli_error($conn);
    }
  }
  mysqli_close($conn);
}
?>