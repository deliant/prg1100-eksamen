<?php
function visYrkesgruppe() {
  include("db.php");
  $sql = "SELECT yrkesgruppe FROM yrkesgruppe";
  $result = mysqli_query($conn, $sql);

  if(mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
      echo "<tr>\n";
      echo "<td>". htmlspecialchars($row['yrkesgruppe']) ."</td>\n";
      echo "<td><form action=". $_SERVER['PHP_SELF'] ." method=\"post\">\n";
      echo "<input type=\"hidden\" name=\"delete_id\" value=". htmlspecialchars($row['yrkesgruppe']) ." />\n";
      echo "<button class=\"btn btn-danger btn-xs\" type=\"submit\" title=\"Slett\"><span class=\"glyphicon glyphicon-trash\"></span></button>\n";
      echo "</form></td>\n";
      echo "</tr>\n";
    }
  } else {
    echo "<tr><td>Ingen yrkesgrupper funnet</td><td>&nbsp;</td></tr>\n";
  }
  mysqli_close($conn);
}

function registrerYrkesgruppe() {
  include("db.php");
  $yrkesgruppe = mysqli_real_escape_string($conn, $_POST["regyrkesgruppenavn"]);
  // Sjekk at tekstfeltet har input
  if(!empty($yrkesgruppe)) {
    // Sett inn i databasen
    $sql = "INSERT INTO yrkesgruppe (yrkesgruppe)
    VALUES ('$yrkesgruppe')";

    if(mysqli_query($conn, $sql)) {
      echo "$yrkesgruppe registrert i yrkesgruppe databasen.";
      echo "<meta http-equiv=\"refresh\" content=\"1\">";
    } else {
      echo "Feil under database forespørsel: " . mysqli_error($conn);
    }
  }
  mysqli_close($conn);
}

function velgYrkesgruppe() {
  include("db.php");
  if(isset($_POST["velgYrkesgruppe"])) {
    $yrkesgruppe = mysqli_real_escape_string($conn, $_POST["velgYrkesgruppe"]);
  }
  else if(isset($_POST["edit_id"])) {
    $yrkesgruppe = mysqli_real_escape_string($conn, $_POST["edit_id"]);
  }
  if(!empty($yrkesgruppe)) {
    $sql = "SELECT yrkesgruppe FROM yrkesgruppe WHERE yrkesgruppe='$yrkesgruppe'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);

    // Validering; onsubmit="return validerRegistrerBehandlerdata()"
    echo "<p>\n";
    echo "<form method=\"post\" name=\"updateyrkesgruppe\" action=". $_SERVER['PHP_SELF'] .">\n";
    echo "<label>Yrkesgruppe</label><input type=\"text\" name=\"yrkesgruppe\" value='" . htmlspecialchars($row['yrkesgruppe']) . "' required /><br/>\n";
    echo "<label>&nbsp;</label><input class=\"btn btn-primary\" type=\"submit\" value=\"Endre\" name=\"submitEndreYrkesgruppe\"><br/><br/>\n";
    echo "</form>\n";
    echo "</p>";
  }
  mysqli_close($conn);
}

function endreYrkesgruppe() {
  include("db.php");
  if(isset($_POST["velgYrkesgruppe"])) {
    $yrkesgruppe = mysqli_real_escape_string($conn, $_POST["velgYrkesgruppe"]);
  }
  else if(isset($_POST["edit_id"])) {
    $yrkesgruppe = mysqli_real_escape_string($conn, $_POST["edit_id"]);
  }
  $yrkesgruppe_ny = mysqli_real_escape_string($conn, $_POST["yrkesgruppe"]);
  if(!empty($yrkesgruppe) && !empty($yrkesgruppe_ny)) {
    $sql = "UPDATE yrkesgruppe SET yrkesgruppe='$yrkesgruppe_ny' WHERE yrkesgruppe='$yrkesgruppe'";

    if(mysqli_query($conn, $sql)) {
      echo "Databasen oppdatert.<br/>";
      echo "<meta http-equiv=\"refresh\" content=\"1\">";
    } else {
      echo "Feil under database forespørsel: " . mysqli_error($conn);
    }
  }
  mysqli_close($conn);
}

function slettYrkesgruppe() {
  include("db.php");
  if(isset($_POST["velgYrkesgruppeSlett"])) {
    $yrkesgruppe = mysqli_real_escape_string($conn, $_POST["velgYrkesgruppeSlett"]);
  }
  else if(isset($_POST["delete_id"])) {
    $yrkesgruppe = mysqli_real_escape_string($conn, $_POST["delete_id"]);
  }
  if(!empty($yrkesgruppe)) {
    $sql = "SELECT brukernavn FROM behandler WHERE yrkesgruppe='$yrkesgruppe'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
      echo "Kan ikke slette yrkesgruppen når det finnes behandlere i den.<br />";
    } else {
      $sql = "DELETE FROM yrkesgruppe WHERE yrkesgruppe='$yrkesgruppe'";
      if (mysqli_query($conn, $sql)) {
        echo "Databasen oppdatert.<br/><br />";
        echo "<meta http-equiv=\"refresh\" content=\"1\">";
      } else {
        echo "Feil under database forespørsel: " . mysqli_error($conn);
      }
    }
  }
  mysqli_close($conn);
}
?>