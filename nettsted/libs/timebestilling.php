<?php
include("db.php");
if(@$_GET["action"] == "listeboksReg") {
  $brukernavn = mysqli_real_escape_string($conn, $_GET["regBehandler"]);
  $dato = mysqli_real_escape_string($conn, $_GET["regDato"]);
  setlocale(LC_TIME, "nb_NO.UTF-8");
  $year = substr($dato, 0, 4);
  $month = substr($dato, 5, 2);
  $day = substr($dato, 8, 2);
  $ukedag = strftime("%A", mktime(0, 0, 0, $month, $day, $year));

  // Sjekk om det finnes timebestillinger for dato
  $sql = "SELECT timebestillingnr FROM timebestilling
  WHERE brukernavn='$brukernavn' AND dato='$dato'";
  $result = mysqli_query($conn, $sql);
  if(mysqli_num_rows($result) == 0) {
    // Sjekk om det finnes timeinndeling for ukedag
    $sql = "SELECT timeinndelingnr FROM timeinndeling
    WHERE brukernavn='$brukernavn' AND ukedag='$ukedag'";
    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) == 0) {
      echo "<option value=\"NULL\">Ingen timeinndeling for denne ukedagen</option>\n";
    } else {
      // List select options fra timeinndeling hvis ingen timebestillinger
      $sql = "SELECT timeinndelingnr, tidspunkt FROM timeinndeling
      WHERE brukernavn='$brukernavn' AND ukedag='$ukedag'";
      $result = mysqli_query($conn, $sql);
      echo "<option selected=\"selected\">-Velg tidspunkt-</option>";
      while ($row = mysqli_fetch_assoc($result)) {
        echo "<option value=\"" . htmlspecialchars($row['tidspunkt']) . "\">" . htmlspecialchars($row['tidspunkt']) . "</option>\n";
      }
    }

  } else {
    $sql = "SELECT tidspunkt
    FROM timeinndeling
    WHERE tidspunkt NOT IN ( 
    SELECT DISTINCT tidspunkt 
      FROM timebestilling
      WHERE dato='$dato' )";

    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) > 0) {
      echo "<option selected=\"selected\">-Velg tidspunkt-</option>";
      while($row = mysqli_fetch_assoc($result)) {
        echo "<option value=\"" . htmlspecialchars($row['tidspunkt']) . "\">". htmlspecialchars($row['tidspunkt']) ."</option>\n";
      }
    } else {
      echo "<option value=\"NULL\">Ingen ledige timebestillinger</option>\n";
    }
  }
}
?>