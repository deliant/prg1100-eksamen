<?php
function listeboksBehandler() {
  include("db.php");
  $sql = "SELECT brukernavn, behandlernavn, yrkesgruppenavn FROM behandler
  LEFT JOIN yrkesgruppe ON behandler.yrkesgruppenr = yrkesgruppe.yrkesgruppenr
  ORDER BY behandlernavn";
  $result = mysqli_query($conn, $sql);

  if(mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
      echo "<option value=\"". htmlspecialchars($row['brukernavn']) ."\">". htmlspecialchars($row['behandlernavn']) ." - ". htmlspecialchars($row['yrkesgruppenavn']) ."</option>\n";
    }
  } else {
    echo "<option value=\"NULL\">Ingen behandlere funnet</option>\n";
  }

  mysqli_close($conn);
}

function listeboksBilde() {
  include("db.php");
  $sql = "SELECT bildenr, beskrivelse FROM bilde ORDER BY bildenr DESC";
  $result = mysqli_query($conn, $sql);

  if(mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
      echo "<option value=\"". htmlspecialchars($row['bildenr']) ."\">". htmlspecialchars($row['bildenr']) ." - ". htmlspecialchars($row['beskrivelse']) ."</option>\n";
    }
  } else {
    echo "<option value=\"NULL\">Ingen bilder funnet</option>\n";
  }

  mysqli_close($conn);
}

function listeboksPasient() {
  include("db.php");
  $sql = "SELECT personnr, pasientnavn FROM pasient ORDER BY pasientnavn";
  $result = mysqli_query($conn, $sql);

  if(mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
      echo "<option value=\"". htmlspecialchars($row['personnr']) ."\">". htmlspecialchars($row['personnr']) ." - ". htmlspecialchars($row['pasientnavn']) ."</option>\n";
    }
  } else {
    echo "<option value=\"NULL\">Ingen pasienter funnet</option>\n";
  }

  mysqli_close($conn);
}

function listeboksYrkesgruppe() {
  include("db.php");
  $sql = "SELECT yrkesgruppenr, yrkesgruppenavn FROM yrkesgruppe ORDER BY yrkesgruppenavn";
  $result = mysqli_query($conn, $sql);

  if(mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
      echo "<option value=\"". htmlspecialchars($row['yrkesgruppenr']) ."\">". htmlspecialchars($row['yrkesgruppenavn']) ."</option>\n";
    }
  } else {
    echo "<option value=\"NULL\">Ingen yrkesgrupper funnet</option>\n";
  }

  mysqli_close($conn);
}
?>