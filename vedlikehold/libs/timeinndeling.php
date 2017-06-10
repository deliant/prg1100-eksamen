<?php
function visTimeinndeling() {
  include("db.php");
  $sql = "SELECT t.ukedag, t.tidspunkt, b.behandlernavn
  FROM timeinndeling AS t
  LEFT JOIN behandler AS b ON t.brukernavn = b.brukernavn
  ORDER BY behandlernavn";
  $result = mysqli_query($conn, $sql);

  if(mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
      echo "<tr>\n";
      echo "<td>". htmlspecialchars($row['behandlernavn']) ."</td>\n";
      echo "<td>". htmlspecialchars($row['ukedag']) ."</td>\n";
      echo "<td>". htmlspecialchars($row['tidspunkt']) ."</td>\n";
      echo "</tr>\n";
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