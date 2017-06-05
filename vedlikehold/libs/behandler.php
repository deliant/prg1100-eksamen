<?php
function visBehandler() {
  include("db.php");
  $sql = "SELECT brukernavn, behandlernavn, yrkesgruppe, bildenr FROM behandler";
  $result = mysqli_query($conn, $sql);

  if(mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
      echo "<tr>";
      echo "<td>". $row['brukernavn'] ."</td>";
      echo "<td>". $row['behandlernavn'] ."</td>";
      echo "<td>". $row['yrkesgruppe'] ."</td>";
      echo "<td>". $row['bildenr'] ."</td>\n";
      echo "<td><form action=". $_SERVER['PHP_SELF'] ." method=\"post\">\n";
      echo "<input type=\"hidden\" name=\"edit_id\" value=". $row['brukernavn'] ." />\n";
      echo "<button type=\"submit\" title=\"Slett\"><span class=\"glyphicon glyphicon-edit\"></span></button>\n";
      echo "</form></td>\n";
      echo "<td><form action=". $_SERVER['PHP_SELF'] ." method=\"post\">\n";
      echo "<input type=\"hidden\" name=\"delete_id\" value=". $row['brukernavn'] ." />\n";
      echo "<button type=\"submit\" title=\"Slett\"><span class=\"glyphicon glyphicon-trash\"></span></button>\n";
      echo "</form></td>\n";
      echo "</tr>";
    }
  } else {
    echo "<tr><td>Ingen behandlere funnet</td></tr>\n";
  }
  mysqli_close($conn);
}

function registrerBehandler() {
  include("db.php");
  $brukernavn = mysqli_real_escape_string($conn, $_POST["brukernavn"]);
  $navn = mysqli_real_escape_string($conn, $_POST["navn"]);
  $yrkesgruppe = mysqli_real_escape_string($conn, $_POST["velgYrkesgruppe"]);
  $bildenr = mysqli_real_escape_string($conn, $_POST["velgBildenr"]);
  // Sjekk at tekstfeltene har input
  if(!empty($brukernavn) && !empty($navn) && !empty($yrkesgruppe) && !empty($bildenr)) {
    // Sett inn i databasen
    $sql = "INSERT INTO behandler (brukernavn, behandlernavn, yrkesgruppe, bildenr)
    VALUES ('$brukernavn', '$navn', '$yrkesgruppe', '$bildenr')";

    if(mysqli_query($conn, $sql)) {
      echo "$navn registrert i behandler databasen.";
      echo '<meta http-equiv="refresh" content="1">';
    } else {
      echo "Feil under database forespørsel: " . mysqli_error($conn);
    }
    mysqli_close($conn);
  }
}

function slettBehandler(){
  include("db.php");
  $behandler = mysqli_real_escape_string($conn, $_POST["velgBehandler"]);
  $sql = "SELECT bildenr FROM behandler WHERE brukernavn='$behandler'";
  $result = mysqli_query($conn, $sql);

  if(mysqli_num_rows($result) > 0) {
    echo "Kan ikke slette behandler når bilde er valgt.<br />";
  } else {
    $sql = "DELETE FROM behandler WHERE brukernavn='$behandler'";
    if(mysqli_query($conn, $sql)) {
      echo "Databasen oppdatert.<br/><br />";
      echo '<meta http-equiv="refresh" content="1">';
    } else {
      echo "Feil under database forespørsel: " . mysqli_error($conn);
    }
  }
  mysqli_close($conn);
}

function slettBehandlerFraVis() {
  include("db.php");
  $brukernavn = mysqli_real_escape_string($conn, $_POST["delete_id"]);
  if(!empty($brukernavn)) {
    $sql = "DELETE FROM behandler WHERE brukernavn='$brukernavn'";

    if(mysqli_query($conn, $sql)) {
      echo "Databasen oppdatert.<br/><br />";
      echo "<meta http-equiv=\"refresh\" content=\"1\">";
    } else {
      echo "Feil under database forespørsel: " . mysqli_error($conn);
    }
    mysqli_close($conn);
  }
}
?>