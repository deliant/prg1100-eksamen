<?php
function visAnsatte() {
  include("db.php");
  $sql = "SELECT b.behandlernavn, yrkesgruppe.yrkesgruppenavn, bilde.filnavn
  FROM behandler AS b
  LEFT JOIN yrkesgruppe ON b.yrkesgruppenr = yrkesgruppe.yrkesgruppenr
  LEFT JOIN bilde ON b.bildenr = bilde.bildenr
  ORDER BY yrkesgruppenavn, behandlernavn";
  $result = mysqli_query($conn, $sql);

  if(mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
      echo "<tr id=\"". $row["behandlernavn"] ."\">\n";
      echo "<td><img class=\"thumbnail-bilde\" src=\"D:\\Sites\\home.hbv.no\\phptemp\\web-prg11v10/" . htmlspecialchars($row['filnavn']) . "\"></td>\n";
      echo "<td>" . htmlspecialchars($row['behandlernavn']) . "</td>\n";
      echo "<td>" . htmlspecialchars($row['yrkesgruppenavn']) . "</td>\n";
      echo "</tr>\n";
    }
  }
  else {
    echo "<tr><td>Ingen timebestillinger funnet</td></tr>\n";
  }

  mysqli_close($conn);
}
?>