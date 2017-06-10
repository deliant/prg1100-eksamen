<?php
function visBehandler() {
  include("db.php");
  $sql = "SELECT b.brukernavn, b.behandlernavn, yrkesgruppe.yrkesgruppenavn, bilde.filnavn
  FROM behandler AS b
  LEFT JOIN yrkesgruppe ON b.yrkesgruppenr = yrkesgruppe.yrkesgruppenr
  LEFT JOIN bilde ON b.bildenr = bilde.bildenr
  ORDER BY behandlernavn";
  $result = mysqli_query($conn, $sql);

  if(mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
      echo "<tr>\n";
      echo "<td>". htmlspecialchars($row['brukernavn']) ."</td>\n";
      echo "<td><img class=\"thumbnail\" src=\"../bilder/". htmlspecialchars($row['filnavn']) ."\"></td>\n";
      echo "<td>". htmlspecialchars($row['behandlernavn']) ."</td>\n";
      echo "<td>". htmlspecialchars($row['yrkesgruppenavn']) ."</td>\n";
      echo "</tr>\n";
    }
  } else {
    echo "<tr><td>Ingen behandlere funnet</td></tr>\n";
  }
  mysqli_close($conn);
}

function registrerBehandler() {
  include("db.php");
  $brukernavn = mysqli_real_escape_string($conn, $_POST["regBrukernavn"]);
  $navn = mysqli_real_escape_string($conn, $_POST["regNavn"]);
  $yrkesgruppenr = mysqli_real_escape_string($conn, $_POST["regYrkesgruppenr"]);
  $bildenr = mysqli_real_escape_string($conn, $_POST["regBildenr"]);
  // Sjekk at tekstfeltene har input
  if(!empty($brukernavn) && !empty($navn) && !empty($yrkesgruppenr) && !empty($bildenr)) {
    // Sett inn i databasen
    $sql = "INSERT INTO behandler (brukernavn, behandlernavn, yrkesgruppenr, bildenr)
    VALUES ('$brukernavn', '$navn', '$yrkesgruppenr', '$bildenr')";

    if(mysqli_query($conn, $sql)) {
      echo "$navn registrert i behandler databasen.";
      echo "<meta http-equiv=\"refresh\" content=\"1\">";
    } else {
      echo "Feil under database forespørsel: " . mysqli_error($conn);
    }
    mysqli_close($conn);
  }
}

function endreBehandler() {
  include("db.php");
  $brukernavn = mysqli_real_escape_string($conn, $_POST["endringBrukernavn"]);
  $navn = mysqli_real_escape_string($conn, $_POST["endringNavn"]);
  $yrkesgruppenr = mysqli_real_escape_string($conn, $_POST["endringYrkesgruppenr"]);
  $bildenr = mysqli_real_escape_string($conn, $_POST["endringBildenr"]);
  if(!empty($brukernavn) && !empty($navn) && !empty($yrkesgruppenr) && !empty($bildenr)) {
    $sql = "UPDATE behandler SET behandlernavn='$navn', yrkesgruppenr='$yrkesgruppenr', bildenr='$bildenr' WHERE brukernavn='$brukernavn'";

    if(mysqli_query($conn, $sql)) {
      echo "Databasen oppdatert.<br/>";
      echo "<meta http-equiv=\"refresh\" content=\"1\">";
    } else {
      echo "Feil under database forespørsel: " . mysqli_error($conn);
    }
  }
  mysqli_close($conn);
}

function slettBehandler() {
  include("db.php");
  $brukernavn = mysqli_real_escape_string($conn, $_POST["slettBehandler"]);
  /* Kan ikke slette om lege har booket time med pasient?
  $sql = "SELECT bildenr FROM behandler WHERE brukernavn='$behandler'";
  $result = mysqli_query($conn, $sql);

  if(mysqli_num_rows($result) > 0) {
    echo "Kan ikke slette behandler når bilde er valgt.<br />";
  } else {
  */
  if(!empty($brukernavn)) {
    $sql = "DELETE FROM behandler WHERE brukernavn='$brukernavn'";

    if (mysqli_query($conn, $sql)) {
      echo "Databasen oppdatert.<br/><br />";
      echo "<meta http-equiv=\"refresh\" content=\"1\">";
    } else {
      echo "Feil under database forespørsel: " . mysqli_error($conn);
    }
  }
  mysqli_close($conn);
  //}
}

include("db.php");
if(@$_GET["action"] == "endre") {
  $brukernavn = mysqli_real_escape_string($conn, $_GET["brukernavn"]);
  $sql = "SELECT b.brukernavn, b.behandlernavn, y.yrkesgruppenavn, b.yrkesgruppenr, b.bildenr 
  FROM behandler AS b
  LEFT JOIN yrkesgruppe AS y ON b.yrkesgruppenr = y.yrkesgruppenr
  WHERE brukernavn='$brukernavn'
  ORDER BY behandlernavn";
  $result = mysqli_query($conn, $sql);

  while($row = mysqli_fetch_array($result)) {
    echo "<h3>Endring</h3>\n";
    echo "<form action=\"\" method=\"post\">\n";
    echo "<label>Brukernavn</label><input type=\"text\" name=\"endringBrukernavn\" value=\"" . htmlspecialchars($row['brukernavn']) . "\" readonly required/><br/>\n";
    echo "<label>Navn</label><input type=\"text\" name=\"endringNavn\" value=\"" . htmlspecialchars($row['behandlernavn']) ."\" required/><br/>\n";
    echo "<label>Yrkesgruppe</label><select name=\"endringYrkesgruppenr\">\n";
    $sql2 = "SELECT yrkesgruppenr, yrkesgruppenavn FROM yrkesgruppe ORDER BY yrkesgruppenavn";
    $result2 = mysqli_query($conn, $sql2);

    if(mysqli_num_rows($result2) > 0) {
      while($row2 = mysqli_fetch_assoc($result2)) {
        if($row2["yrkesgruppenr"] === $row["yrkesgruppenr"]) {
          echo "<option value=\"". htmlspecialchars($row2['yrkesgruppenr']) ."\" selected=\"selected\">". htmlspecialchars($row2['yrkesgruppenavn']) ."</option>\n";
        } else {
          echo "<option value=\"". htmlspecialchars($row2['yrkesgruppenr']) ."\">". htmlspecialchars($row2['yrkesgruppenavn']) ."</option>\n";
        }
      }
    } else {
      echo "<option value=\"NULL\">Ingen yrkesgrupper funnet</option>\n";
    }
    echo "</select><br/>\n";
    echo "<label>Bilde</label><select name=\"endringBildenr\">\n";
    $sql3 = "SELECT bildenr, beskrivelse FROM bilde ORDER BY beskrivelse";
    $result3 = mysqli_query($conn, $sql3);

    if(mysqli_num_rows($result3) > 0) {
      while($row3 = mysqli_fetch_assoc($result3)) {
        if($row3["bildenr"] === $row["bildenr"]) {
          echo "<option value=\"". htmlspecialchars($row3['bildenr']) ."\" selected=\"selected\">". htmlspecialchars($row3['beskrivelse']) ."</option>\n";
        } else {
          echo "<option value=\"". htmlspecialchars($row3['bildenr']) ."\">". htmlspecialchars($row3['beskrivelse']) ."</option>\n";
        }
      }
    } else {
      echo "<option value=\"NULL\">Ingen bilder funnet</option>\n";
    }
    echo "</select><br/>\n";
    echo "<label>&nbsp;</label><input class=\"btn btn-primary\" type=\"submit\" value=\"Endre\" name=\"submitEndreBehandler\"><br/><br/>\n";
    echo "</form>\n";
  }
  mysqli_close($conn);
}
?>