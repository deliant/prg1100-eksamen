<?php
function visYrkesgruppe() {
  include("db.php");
  $sql = "SELECT yrkesgruppenavn FROM yrkesgruppe";
  $result = mysqli_query($conn, $sql);

  if(mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
      echo "<tr>\n";
      echo "<td>". htmlspecialchars($row['yrkesgruppenavn']) ."</td>\n";
      echo "</tr>\n";
    }
  } else {
    echo "<tr><td>Ingen yrkesgrupper funnet</td><td>&nbsp;</td></tr>\n";
  }
  mysqli_close($conn);
}

function registrerYrkesgruppe() {
  include("db.php");
  $yrkesgruppenavn = mysqli_real_escape_string($conn, $_POST["regYrkesgruppe"]);
  // Sjekk at tekstfeltet har input
  if(!empty($yrkesgruppenavn)) {
    // Sett inn i databasen
    $sql = "INSERT INTO yrkesgruppe (yrkesgruppenavn)
    VALUES ('$yrkesgruppenavn')";

    if(mysqli_query($conn, $sql)) {
      echo "$yrkesgruppe registrert i yrkesgruppe databasen.";
      echo "<meta http-equiv=\"refresh\" content=\"1\">";
    } else {
      echo "Feil under database forespørsel: " . mysqli_error($conn);
    }
  }
  mysqli_close($conn);
}

function endreYrkesgruppe() {
  include("db.php");
  $yrkesgruppenr = mysqli_real_escape_string($conn, $_POST["velgYrkesgruppe"]);
  $yrkesgruppenavn = mysqli_real_escape_string($conn, $_POST["endringYrkesgruppe"]);
  if(!empty($yrkesgruppenr) && !empty($yrkesgruppenavn)) {
    $sql = "UPDATE yrkesgruppe SET yrkesgruppenavn='$yrkesgruppenavn' WHERE yrkesgruppenr='$yrkesgruppenr'";

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
  $yrkesgruppenr = mysqli_real_escape_string($conn, $_POST["slettYrkesgruppe"]);
  if(!empty($yrkesgruppenr)) {
    $sql = "SELECT brukernavn FROM behandler WHERE yrkesgruppenr='$yrkesgruppenr'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
      echo "Kan ikke slette yrkesgruppen når det finnes behandlere i den.<br />";
    } else {
      $sql = "DELETE FROM yrkesgruppe WHERE yrkesgruppenr='$yrkesgruppenr'";
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

include("db.php");
if(@$_GET["action"] == "endre") {
  $yrkesgruppenr = mysqli_real_escape_string($conn, $_GET["yrkesgruppenr"]);
  $sql = "SELECT yrkesgruppenavn FROM yrkesgruppe WHERE yrkesgruppenr='$yrkesgruppenr'";
  $result = mysqli_query($conn, $sql);

  while($row = mysqli_fetch_array($result)) {
    echo "<h3>Endring</h3>\n";
    echo "<form action=\"\" method=\"post\">\n";
    echo "<label>Yrkesgruppe</label><input type=\"text\" name=\"endringYrkesgruppe\"  value=". htmlspecialchars($row['yrkesgruppenavn']) ." required/><br/>\n";
    echo "<label>&nbsp;</label><input class=\"btn btn-primary\" type=\"submit\" value=\"Endre\" name=\"submitEndreYrkesgruppe\"><br/><br/>\n";
    echo "</form>\n";
  }
  mysqli_close($conn);
}
?>