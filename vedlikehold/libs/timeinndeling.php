<?php
function visTimeinndeling() {
  include("db.php");
  $sql = "SELECT * FROM timeinndeling";
  $result = mysqli_query($conn, $sql);

  if(mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
      echo "<tr>";
      echo "<td>". $row['brukernavn'] ."</td>";
      echo "<td>". $row['ukedag'] ."</td>";
      echo "<td>". $row['tidspunkt'] ."</td>";
      /*
      echo "<td><form action=". $_SERVER['PHP_SELF'] ." method=\"post\">\n";
      echo "<input type=\"hidden\" name=\"edit_id\" value=". $row['brukernavn'] ." />\n";
      echo "<button class=\"btn btn-primary btn-xs\" type=\"submit\" title=\"Endre\"><span class=\"glyphicon glyphicon-edit\"></span></button>\n";
      echo "</form></td>\n";w
      echo "<td><form action=". $_SERVER['PHP_SELF'] ." method=\"post\">\n";
      echo "<input type=\"hidden\" name=\"delete_id\" value=". $row['brukernavn'] ." />\n";
      echo "<button class=\"btn btn-danger btn-xs\" type=\"submit\" title=\"Slett\"><span class=\"glyphicon glyphicon-trash\"></span></button>\n";
      echo "</form></td>\n";
      */
      echo "</tr>";
    }
  } else {
    echo "<tr><td>Ingen timeinndelinger funnet</td></tr>\n";
  }
  mysqli_close($conn);
}

function registrerTimeinndeling() {
  include("db.php");
  $brukernavn = mysqli_real_escape_string($conn, $_POST["velgBrukernavn"]);
  $ukedag = mysqli_real_escape_string($conn, $_POST["velgUkedag"]);
  $fratidspunkt = mysqli_real_escape_string($conn, $_POST["fratidspunkt"]);
  $tiltidspunkt = mysqli_real_escape_string($conn, $_POST["tiltidspunkt"]);
  $tidspunkt = $fratidspunkt . "-" . $tiltidspunkt;
  // Sjekk at tekstfeltene har input
  if(!empty($brukernavn) && !empty($ukedag) && !empty($fratidspunkt) && !empty($tiltidspunkt)) {
    // Sett inn i databasen
    $sql = "INSERT INTO timeinndeling (brukernavn, ukedag, tidspunkt)
    VALUES ('$brukernavn', '$ukedag', '$tidspunkt')";

    if(mysqli_query($conn, $sql)) {
      echo "$brukernavn registrert som åpen for å ta imot pasienter $ukedag kl. $tidspunkt i timeinndeling databasen.";
      echo "<meta http-equiv=\"refresh\" content=\"1\">";
    } else {
      echo "Feil under database forespørsel: " . mysqli_error($conn);
    }
    mysqli_close($conn);
  }
}

function slettTimeinndeling() {
  include("db.php");
  $brukernavn = mysqli_real_escape_string($conn, $_POST["velgTimeinndelingBehandler"]);
  $ukedag = mysqli_real_escape_string($conn, $_POST["velgTimeinndelingUkedag"]);
  $tidspunkt = mysqli_real_escape_string($conn, $_POST["velgTimeinndelingTidspunkt"]);
  // Sjekk at tekstfeltene har input
  if(!empty($brukernavn) && !empty($ukedag) && !empty($tidspunkt)) {
    // Slett fra databasen
    $sql = "DELETE FROM timeinndeling WHERE brukernavn='$brukernavn' AND ukedag='$ukedag' AND tidspunkt='$tidspunkt'";
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