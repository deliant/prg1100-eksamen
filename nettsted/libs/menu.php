<?php
function populateMenu() {
  include("db.php");
  $sql = "SELECT yrkesgruppenr, yrkesgruppenavn
  FROM yrkesgruppe
  ORDER BY yrkesgruppenavn";
  $result = mysqli_query($conn, $sql);

  echo "<li><a href=\"ansatte.php\">Våre ansatte</a></li>\n";
  if(mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
      $yrkesgruppenr = $row["yrkesgruppenr"];
      $sql2 = "SELECT behandlernavn
      FROM behandler
      WHERE yrkesgruppenr='$yrkesgruppenr'
      ORDER BY behandlernavn";
      $result2 = mysqli_query($conn, $sql2);

      if(mysqli_num_rows($result2) > 0) {
        echo "<li role=\"separator\" class=\"divider\"></li>\n";
        echo "<li class=\"listheader\">". $row['yrkesgruppenavn'] ."</li>\n";
      }
      while($row2 = mysqli_fetch_assoc($result2)) {
        echo "<li><a href=\"ansatte.php#". $row2['behandlernavn'] ."\">". $row2['behandlernavn'] ."</a></li>";
      }
    }
  } else {
    echo "<li><a href=\"#\">Ingen behandlere funnet</a></li>\n";
  }

  mysqli_close($conn);
}
?>