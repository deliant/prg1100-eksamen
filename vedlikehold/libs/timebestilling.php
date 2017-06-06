<?php
function visTimebestilling() {
  include("db.php");
  $sql = "SELECT * FROM timebestilling";
  $result = mysqli_query($conn, $sql);

  if(mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
      echo "<tr>";
      echo "<td>". $row['dato'] ."</td>";
      echo "<td>". $row['tidspunkt'] ."</td>";
      echo "<td>". $row['brukernavn'] ."</td>";
      echo "<td>". $row['personnr'] ."</td>";
      echo "<td><form action=". $_SERVER['PHP_SELF'] ." method=\"post\">\n";
      echo "<input type=\"hidden\" name=\"edit_id\" value=". $row['timebestillingnr'] ." />\n";
      echo "<button class=\"btn btn-primary btn-xs\" type=\"submit\" title=\"Endre\"><span class=\"glyphicon glyphicon-edit\"></span></button>\n";
      echo "</form></td>\n";
      echo "<td><form action=". $_SERVER['PHP_SELF'] ." method=\"post\">\n";
      echo "<input type=\"hidden\" name=\"delete_id\" value=". $row['timebestillingnr'] ." />\n";
      echo "<button class=\"btn btn-danger btn-xs\" type=\"submit\" title=\"Slett\"><span class=\"glyphicon glyphicon-trash\"></span></button>\n";
      echo "</form></td>\n";
      echo "</tr>";
    }
  } else {
    echo "<tr><td>Ingen timebestillinger funnet</td></tr>\n";
  }
  mysqli_close($conn);
}

function registrerTimebestilling() {
  include("db.php");
  $dato = mysqli_real_escape_string($conn, $_POST["regdato"]);
  $tidspunkt = mysqli_real_escape_string($conn, $_POST["regtidspunkt"]);
  $brukernavn = mysqli_real_escape_string($conn, $_POST["velgBehandler"]);
  $personnr = mysqli_real_escape_string($conn, $_POST["velgPasient"]);
  // Sjekk at tekstfeltene har input
  if(!empty($dato) && !empty($tidspunkt) && !empty($brukernavn) && !empty($personnr)) {
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

function velgTimebestilling() {
  include("db.php");
  if(isset($_POST["velgTimebestilling"])) {
    $timebestillingnr = mysqli_real_escape_string($conn, $_POST["velgTimebestilling"]);
  }
  else if(isset($_POST["edit_id"])) {
    $timebestillingnr = mysqli_real_escape_string($conn, $_POST["edit_id"]);
  }
  $sql = "SELECT * FROM timebestilling WHERE timebestillingnr='$timebestillingnr'";
  $result = mysqli_query($conn, $sql);
  $row = mysqli_fetch_assoc($result);
  // Validering; onsubmit="return validerRegistrerBehandlerdata()"
  echo "<form method=\"post\" name=\"updatetimebestilling\" action=". $_SERVER['PHP_SELF'] .">\n";
  echo "<label>Dato</label><input type=\"text\" id=\"dato\" name=\"dato\" value='" . $row['dato'] . "' required /><br/>\n";
  echo "<label>Tidspunkt</label><input type=\"text\" name=\"tidspunkt\" value='" . $row['tidspunkt'] . "' required /><br/>\n";
  echo "<label>Behandler</label><select name=\"behandler\">";
  $sql2 = "SELECT brukernavn FROM behandler";
  $result2 = mysqli_query($conn, $sql2);

  if(mysqli_num_rows($result2) > 0) {
    while($row2 = mysqli_fetch_assoc($result2)) {
      if($row2['brukernavn'] === $row['brukernavn']) {
        echo "<option value=". $row2['brukernavn'] ." selected=\"selected\">". $row2['brukernavn'] ."</option>\n";
      } else {
        echo "<option value=". $row2['brukernavn'] .">". $row2['brukernavn'] ."</option>\n";
      }
    }
  } else {
    echo "<option value=\"NULL\">Ingen behandlere funnet</option>\n";
  }
  echo "</select><br/>\n";
  echo "<label>Pasient</label><select name=\"pasient\">";
  $sql3 = "SELECT personnr FROM pasient";
  $result3 = mysqli_query($conn, $sql3);

  if(mysqli_num_rows($result3) > 0) {
    while($row3 = mysqli_fetch_assoc($result3)) {
      if($row3['personnr'] === $row['personnr']) {
        echo "<option value=". $row3['brukernavn'] ." selected=\"selected\">". $row3['brukernavn'] ."</option>\n";
      } else {
        echo "<option value=". $row3['brukernavn'] .">". $row3['brukernavn'] ."</option>\n";
      }
    }
  } else {
    echo "<option value=\"NULL\">Ingen pasienter funnet</option>\n";
  }
  echo "</select><br/>\n";
  echo "<label>&nbsp;</label><input class=\"btn btn-primary\" type=\"submit\" value=\"Endre\" name=\"submitEndreTimebestilling\"><br/><br/>\n";
  echo "</form>\n";
  echo "</p>";
  mysqli_close($conn);
}

function endreTimebestilling() {
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

function slettTimebestilling() {
  include("db.php");
  if(isset($_POST["velgTimebestillingSlett"])) {
    $personnr = mysqli_real_escape_string($conn, $_POST["velgTimebestillingSlett"]);
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
    $sql = "DELETE FROM timebestilling WHERE personnr='$personnr'";

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