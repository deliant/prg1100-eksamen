<?php
function listeboksBehandler() {
  include("db.php");
  $sql = "SELECT brukernavn, behandlernavn FROM behandler";
  $result = mysqli_query($conn, $sql);

  if(mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
      echo "<option value=". $row['brukernavn'] .">". $row['brukernavn'] ." - ". $row['behandlernavn'] ."</option>\n";
    }
  } else {
    echo "<option value='Ingen'>Ingen behandlere funnet</option>\n";
  }
  mysqli_close($conn);
}

function listeboksBilde() {
  include("db.php");
  $sql = "SELECT bildenr FROM bilde";
  $result = mysqli_query($conn, $sql);

  if(mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
      echo "<option value=". $row['bildenr'] .">". $row['bildenr'] ."</option>\n";
    }
  } else {
    echo "<option value='Ingen'>Ingen bilder funnet</option>\n";
  }
  mysqli_close($conn);
}

function listeboksYrkesgruppe() {
  include("db.php");
  $sql = "SELECT yrkesgruppe FROM yrkesgruppe";
  $result = mysqli_query($conn, $sql);

  if(mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
      echo "<option value=". $row['yrkesgruppe'] .">". $row['yrkesgruppe'] ."</option>\n";
    }
  } else {
    echo "<option value='Ingen'>Ingen yrkesgrupper funnet</option>\n";
  }
  mysqli_close($conn);
}
?>