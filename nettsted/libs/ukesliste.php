<?php
function velgDato($brukernavn, $dato) {
  include("db.php");
  setlocale(LC_TIME, "nb_NO.UTF-8");
  $year = substr($dato, 0, 4);
  $month = substr($dato, 5, 2);
  $day = substr($dato, 8, 2);
  $ukedag = ucfirst(strftime("%A", mktime(0, 0, 0, $month, $day, $year)));

  if($ukedag == "Mandag") {
    $visdato = $dato;
  } else {
    $visdato = date('Y-m-d', strtotime('this Monday', strtotime($dato)));
  }

  echo "<div class=\"panel panel-default\">\n";
  echo "<div class=\"panel-heading\"><strong>". htmlspecialchars($ukedag) ." ". htmlspecialchars($dato) ."</strong></div>\n";
  echo "<table class=\"table\">\n";
  echo "<tr>\n";
  echo "<th>Dato</th>\n";
  echo "<th>Ukedag</th>\n";
  echo "<th>Tidspunkt</th>\n";
  echo "</tr>\n";

  // Sjekk om det finnes timeinndeling for ukedag
  $sql = "SELECT tidspunkt, ukedag FROM timeinndeling
    WHERE brukernavn='$brukernavn' AND ukedag='$ukedag'";
  $result = mysqli_query($conn, $sql);

  // Sjekk timeinndeling for tider og print alle
  // if: tid og dag matcher timebestilling print som opptatt
  // else: print som ledig
  if(mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
      $sql2 = "SELECT tidspunkt
        FROM timeinndeling
        WHERE tidspunkt NOT IN ( 
        SELECT DISTINCT tidspunkt 
        FROM timebestilling
        WHERE dato='$visdato'
        )
        ORDER BY tidspunkt";
      $result2 = mysqli_query($conn, $sql2);
      $row2 = mysqli_fetch_assoc($result2);

      if($row["tidspunkt"] == $row2["tidspunkt"]) {
        echo "<tr class=\"success\">\n";
        echo "<th>". $visdato ."</th>\n";
        echo "<th>". $row['ukedag'] ."</th>\n";
        echo "<th>". $row['tidspunkt'] ."</th>\n";
        echo "</tr>\n";
      } else {
        echo "<tr class=\"danger\">\n";
        echo "<th>" . $visdato . "</th>\n";
        echo "<th>" . $row['ukedag'] . "</th>\n";
        echo "<th>" . $row['tidspunkt'] . "</th>\n";
        echo "</tr>\n";
      }

    }

  } else {
    echo "<tr>\n";
    echo "<td>Ingen timeinndeling for denne ukedagen</td>\n";
    echo "</tr>\n";
  }

  echo "</table>\n";
  echo "</div>\n";
}

function velgUkesliste($brukernavn, $dato) {
  include("db.php");
  setlocale(LC_TIME, "nb_NO.UTF-8");
  $year = substr($dato, 0, 4);
  $month = substr($dato, 5, 2);
  $day = substr($dato, 8, 2);
  $ukedag = strftime("%A", mktime(0, 0, 0, $month, $day, $year));

  if($ukedag == "Mandag") {
    $start = $dato;
  } else {
    $start = date('Y-m-d', strtotime('this Monday', strtotime($dato)));
  }

  echo "<div class=\"panel panel-default\">\n";
  for($x = 0;$x < 5;$x++) {
    if($x == 0) {
      $visdato = $start;
    } else {
      $visdato = date('Y-m-d', strtotime($start . ' +' . $x . ' day'));
    }

    $year = substr($visdato, 0, 4);
    $month = substr($visdato, 5, 2);
    $day = substr($visdato, 8, 2);
    $ukedag = ucfirst(strftime("%A", mktime(0, 0, 0, $month, $day, $year)));
    // Sjekk om det finnes timeinndeling for ukedag
    $sql = "SELECT tidspunkt, ukedag FROM timeinndeling
    WHERE brukernavn='$brukernavn' AND ukedag='$ukedag'";
    $result = mysqli_query($conn, $sql);

    // Sjekk timeinndeling for tider og print alle
    // if: tid og dag matcher timebestilling print som opptatt
    // else: print som ledig

    echo "<div class=\"panel-heading\"><strong>". $ukedag ."</strong></div>\n";
    echo "<table class=\"table\">\n";
    echo "<tr>\n";
    echo "<th>Dato</th>\n";
    echo "<th>Ukedag</th>\n";
    echo "<th>Tidspunkt</th>\n";
    echo "</tr>\n";

    if(mysqli_num_rows($result) > 0) {
      while($row = mysqli_fetch_assoc($result)) {
        $sql2 = "SELECT tidspunkt
        FROM timeinndeling
        WHERE tidspunkt NOT IN ( 
        SELECT DISTINCT tidspunkt 
        FROM timebestilling
        WHERE dato='$visdato'
        )
        ORDER BY tidspunkt";
        $result2 = mysqli_query($conn, $sql2);
        $row2 = mysqli_fetch_assoc($result2);

        if($row["tidspunkt"] == $row2["tidspunkt"]) {
          echo "<tr class=\"success\">\n";
          echo "<th>". htmlspecialchars($visdato) ."</th>\n";
          echo "<th>". htmlspecialchars($row['ukedag']) ."</th>\n";
          echo "<th>". htmlspecialchars($row['tidspunkt']) ."</th>\n";
          echo "</tr>\n";
        } else {
          echo "<tr class=\"danger\">\n";
          echo "<th>" . htmlspecialchars($visdato) . "</th>\n";
          echo "<th>" . htmlspecialchars($row['ukedag']) . "</th>\n";
          echo "<th>" . htmlspecialchars($row['tidspunkt']) . "</th>\n";
          echo "</tr>\n";
        }

      }

    } else {
      echo "<tr>\n";
      echo "<td>&nbsp;</td>\n";
      echo "<td>Ingen timeinndeling for denne ukedagen</td>\n";
      echo "<td>&nbsp;</td>\n";
      echo "</tr>\n";
    }

    echo "</table>\n";
  }

  echo "</div>\n";
}

include("db.php");
if(@$_GET["action"] == "visUkesliste") {
  $brukernavn = mysqli_real_escape_string($conn, $_GET["velgBehandler"]);
  $dato = mysqli_real_escape_string($conn, $_GET["velgDato"]);
  velgUkesliste($brukernavn, $dato);
}

if(@$_GET["action"] == "visDato") {
  $brukernavn = mysqli_real_escape_string($conn, $_GET["velgBehandler"]);
  $dato = mysqli_real_escape_string($conn, $_GET["velgDato"]);
  velgDato($brukernavn, $dato);
}
?>