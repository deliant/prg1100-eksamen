<?php
function listeboksBehandler() {
  include("db.php");
  @$personnr = $_SESSION["personnr"];
  $sql = "SELECT brukernavn, behandlernavn, yrkesgruppenavn FROM behandler
  LEFT JOIN yrkesgruppe ON behandler.yrkesgruppenr = yrkesgruppe.yrkesgruppenr
  ORDER BY behandlernavn";
  $result = mysqli_query($conn, $sql);

  $sql2 = "SELECT brukernavn FROM pasient
  WHERE personnr='$personnr'";
  $result2 = mysqli_query($conn, $sql2);

  if(mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
      $row2 = mysqli_fetch_assoc($result2);
      if($row["brukernavn"] == $row2["brukernavn"]) {
        echo "<option value=\"". htmlspecialchars($row['brukernavn']) ."\" selected=\"selected\">". htmlspecialchars($row['behandlernavn']) ." - ". htmlspecialchars($row['yrkesgruppenavn']) ."</option>\n";
      } else {
        echo "<option value=\"". htmlspecialchars($row['brukernavn']) ."\">". htmlspecialchars($row['behandlernavn']) ." - ". htmlspecialchars($row['yrkesgruppenavn']) ."</option>\n";
      }
    }
  } else {
    echo "<option value=\"Ingen\">Ingen behandlere funnet</option>\n";
  }

  mysqli_close($conn);
}

function listeboksTimebestilling() {
  include("db.php");
  if(!isset($_SESSION["personnr"])) {
    session_start();
  }
  $personnr = mysqli_real_escape_string($conn, $_SESSION["personnr"]);
  $sql = "SELECT * FROM timebestilling WHERE personnr='$personnr'";
  $result = mysqli_query($conn, $sql);

  if(mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
      echo "<option value=\"" . htmlspecialchars($row['timebestillingnr']) . "\">". htmlspecialchars($row['dato']) ." (". htmlspecialchars($row['tidspunkt']) .")</option>\n";
    }
  } else {
    echo "<option value=\"NULL\">Ingen timebestillinger funnet</option>\n";
  }

  mysqli_close($conn);
}
?>