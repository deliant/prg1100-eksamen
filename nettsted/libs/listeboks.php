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
    echo "<option value=\"Ingen\">Ingen behandlere funnet</option>\n";
  }

  mysqli_close($conn);
}
?>