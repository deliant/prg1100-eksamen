<?php
function listeboksBehandler() {
  include("db.php");
  $sql = "SELECT brukernavn, behandlernavn, yrkesgruppe FROM behandler ORDER BY behandlernavn";
  $result = mysqli_query($conn, $sql);

  if(mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
      echo "<option value=". htmlspecialchars($row['brukernavn']) .">". htmlspecialchars($row['behandlernavn']) ." - ". htmlspecialchars($row['yrkesgruppe']) ."</option>\n";
    }
  } else {
    echo "<option value=\"Ingen\">Ingen behandlere funnet</option>\n";
  }
  mysqli_close($conn);
}

function listeboksBilde() {
  include("db.php");
  $sql = "SELECT bildenr, beskrivelse FROM bilde ORDER BY bildenr DESC";
  $result = mysqli_query($conn, $sql);

  if(mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
      echo "<option value=". htmlspecialchars($row['bildenr']) .">". htmlspecialchars($row['beskrivelse']) ."</option>\n";
    }
  } else {
    echo "<option value=\"Ingen\">Ingen bilder funnet</option>\n";
  }
  mysqli_close($conn);
}

function listeboksPasient() {
  include("db.php");
  $sql = "SELECT personnr, pasientnavn FROM pasient ORDER BY pasientnavn";
  $result = mysqli_query($conn, $sql);

  if(mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
      echo "<option value=". htmlspecialchars($row['personnr']) .">". htmlspecialchars($row['personnr']) ." - ". htmlspecialchars($row['pasientnavn']) ."</option>\n";
    }
  } else {
    echo "<option value=\"Ingen\">Ingen pasienter funnet</option>\n";
  }
  mysqli_close($conn);
}

function listeboksTimebestilling() {
  include("db.php");
  $sql = "SELECT t.timebestillingnr, t.dato, t.brukernavn, t.personnr
  FROM timebestilling AS t
  LEFT JOIN behandler AS b ON t.brukernavn = b.brukernavn
  LEFT JOIN pasient AS p ON t.personnr = p.personnr
  ORDER BY t.dato";
  $result = mysqli_query($conn, $sql);

  if(mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
      echo "<option value=". htmlspecialchars($row['personnr']) .">". htmlspecialchars($row['personnr']) ." - ". htmlspecialchars($row['pasientnavn']) ."</option>\n";
    }
  } else {
    echo "<option value=\"Ingen\">Ingen timebestillinger funnet</option>\n";
  }
  mysqli_close($conn);
}

function listeboksTimeinndeling() {
  include("db.php");
  $brukernavn = mysqli_real_escape_string($conn, $_POST["velgTimeinndelingBehandler"]);
  $ukedag = mysqli_real_escape_string($conn, $_POST["velgTimeinndelingUkedag"]);
  $sql = "SELECT * FROM timeinndeling WHERE brukernavn='$brukernavn' AND ukedag='$ukedag'";
  $result = mysqli_query($conn, $sql);

  if(mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
      echo "<option value=". htmlspecialchars($row['tidspunkt']) .">". htmlspecialchars($row['tidspunkt']) ."</option>\n";
    }
  } else {
    echo "<option value=\"Ingen\">Ingen timeinndelinger funnet</option>\n";
  }
  mysqli_close($conn);
}

function listeboksYrkesgruppe() {
  include("db.php");
  $sql = "SELECT yrkesgruppe FROM yrkesgruppe";
  $result = mysqli_query($conn, $sql);

  if(mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
      echo "<option value=". htmlspecialchars($row['yrkesgruppe']) .">". htmlspecialchars($row['yrkesgruppe']) ."</option>\n";
    }
  } else {
    echo "<option value=\"Ingen\">Ingen yrkesgrupper funnet</option>\n";
  }
  mysqli_close($conn);
}
?>