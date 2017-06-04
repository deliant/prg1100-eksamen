<?php
function visYrkesgruppe() {
  include("db.php");
  $sql = "SELECT yrkesgruppe FROM yrkesgruppe";
  $result = mysqli_query($conn, $sql);

  if(mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
      echo "<tr><td>". $row['yrkesgruppe'] ."</td></tr>\n";
    }
  } else {
    echo "<tr><td>Ingen yrkesgrupper funnet</td></tr>\n";
  }
  mysqli_close($conn);
}

function registrerYrkesgruppe() {
  include("db.php");
  $yrkesgruppe = trim($_POST["yrkesgruppe"]);
  // Sjekk at tekstfeltene har input
  if(!empty($yrkesgruppe)) {
    // Sett inn i databasen
    $sql = "INSERT INTO yrkesgruppe (yrkesgruppe)
    VALUES ('$yrkesgruppe')";

    if(mysqli_query($conn, $sql)) {
      echo "$yrkesgruppe registrert i yrkesgruppe databasen.";
      echo '<meta http-equiv="refresh" content="1">';
    } else {
      echo "Feil under database forespørsel: " . mysqli_error($conn);
    }
    mysqli_close($conn);
  }
}

function slettYrkesgruppe(){
  include("db.php");
  $yrkesgruppe = $_POST["velgYrkesgruppe"];
  $sql = "SELECT brukernavn FROM behandler WHERE yrkesgruppe='$yrkesgruppe'";
  $result = mysqli_query($conn, $sql);

  if(mysqli_num_rows($result) > 0) {
    echo "Kan ikke slette yrkesgruppen når det finnes behandlere i den.<br />";
  } else {
    $sql = "DELETE FROM yrkesgruppe WHERE yrkesgruppe='$yrkesgruppe'";
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