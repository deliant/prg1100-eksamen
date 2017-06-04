<?php
function visBehandler() {
  include("db.php");
  $sql = "SELECT brukernavn, behandlernavn, yrkesgruppe, bildenr FROM behandler";
  $result = mysqli_query($conn, $sql);

  if(mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
      echo "<tr><td>". $row['brukernavn'] ."</td><td>". $row['behandlernavn'] ."</td><td>". $row['yrkesgruppe'] ."</td><td>". $row['bildenr'] ."</td></tr>\n";
    }
  } else {
    echo "<tr><td>Ingen behandlere funnet</td></tr>\n";
  }
  mysqli_close($conn);
}

function registrerBehandler() {
  include("db.php");
  $brukernavn = trim($_POST["brukernavn"]);
  $navn = trim($_POST["navn"]);
  $yrkesgruppe = trim($_POST["velgYrkesgruppe"]);
  $bildenr = trim($_POST["velgBildenr"]);
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
  $behandler = $_POST["velgBehandler"];
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
?>