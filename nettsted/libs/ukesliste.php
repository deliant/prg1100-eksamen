<?php
function velgDato($brukernavn, $dato) {
  if(!empty($brukernavn) && !empty($dato)) {
    include("db.php");
    setlocale(LC_TIME, "nb_NO.UTF-8");
    $year = substr($dato, 0, 4);
    $month = substr($dato, 5, 2);
    $day = substr($dato, 8, 2);
    $ukedag = ucfirst(strftime("%A", mktime(0, 0, 0, $month, $day, $year)));

    echo "<div class=\"panel panel-default\">\n";
    echo "<div class=\"panel-heading\"><strong>". htmlspecialchars($ukedag) ." ". htmlspecialchars($dato) ."</strong></div>\n";
    echo "<table class=\"table\">\n";
    echo "<tr>\n";
    echo "<th>Dato</th>\n";
    echo "<th>Ukedag</th>\n";
    echo "<th>Tidspunkt</th>\n";
    echo "</tr>\n";

    // Sjekk timebestillinger for aktuelle datoer
    $sql2 = "SELECT tidspunkt
    FROM timeinndeling
    WHERE tidspunkt NOT IN ( 
    SELECT DISTINCT tidspunkt 
      FROM timebestilling
      WHERE dato='$dato'
      )
    GROUP BY tidspunkt";
    $result2 = mysqli_query($conn, $sql2);
    $array = array();
    while($row2 = mysqli_fetch_assoc($result2)) {
      $array[] = $row2["tidspunkt"];
    }

    // Sjekk om det finnes timeinndeling for ukedag
    $sql = "SELECT tidspunkt, ukedag FROM timeinndeling
    WHERE brukernavn='$brukernavn' AND ukedag='$ukedag'";
    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) > 0) {
      while($row = mysqli_fetch_assoc($result)) {
        if(array_intersect($array, $row)) {
          echo "<tr class=\"success\">\n";
          echo "<th>" . $dato . "</th>\n";
          echo "<th>" . $row['ukedag'] . "</th>\n";
          echo "<th>" . $row['tidspunkt'] . "</th>\n";
          echo "</tr>\n";
        } else {
          echo "<tr class=\"danger\">\n";
          echo "<th>" . $dato . "</th>\n";
          echo "<th>" . $row['ukedag'] . "</th>\n";
          echo "<th>" . $row['tidspunkt'] . "</th>\n";
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
    echo "</div>\n";

    mysqli_close($conn);
  } else {
    echo "Fyll ut behandler og datofelt";
  }
}

function velgUkesliste($brukernavn, $dato) {
  if(!empty($brukernavn) && !empty($dato)) {
    include("db.php");
    setlocale(LC_TIME, "nb_NO.UTF-8");
    $year = substr($dato, 0, 4);
    $month = substr($dato, 5, 2);
    $day = substr($dato, 8, 2);
    $ukedag = strftime("%A", mktime(0, 0, 0, $month, $day, $year));

    if($ukedag == "Mandag") {
      $start = $dato;
    } else {
      $start = date('Y-m-d', strtotime('monday this week', strtotime($dato)));
    }

    echo "<div class=\"panel panel-default\">\n";

    for($x = 0;$x < 5;$x++) {
      if($x > 0) {
        $visdato = date('Y-m-d', strtotime($start . ' +' . $x . ' day'));
      } else {
        $visdato = $start;
      }

      $year = substr($visdato, 0, 4);
      $month = substr($visdato, 5, 2);
      $day = substr($visdato, 8, 2);
      $ukedag = ucfirst(strftime("%A", mktime(0, 0, 0, $month, $day, $year)));

      // Sjekk timebestillinger for aktuelle datoer
      $sql2 = "SELECT tidspunkt
      FROM timeinndeling
      WHERE tidspunkt NOT IN ( 
      SELECT DISTINCT tidspunkt 
        FROM timebestilling
        WHERE dato='$visdato'
        )
      GROUP BY tidspunkt";
      $result2 = mysqli_query($conn, $sql2);
      $array = array();
      while($row2 = mysqli_fetch_assoc($result2)) {
        $array[] = $row2["tidspunkt"];
      }

      echo "<div class=\"panel-heading\"><strong>". htmlspecialchars($ukedag) ." ". htmlspecialchars($visdato) ."</strong></div>\n";
      echo "<table class=\"table\">\n";

      // Sjekk om det finnes timeinndeling for ukedag
      $sql = "SELECT tidspunkt, ukedag FROM timeinndeling
    WHERE brukernavn='$brukernavn' AND ukedag='$ukedag'";
      $result = mysqli_query($conn, $sql);

      if(mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
          if(array_intersect($array, $row)) {
            echo "<tr class=\"success\">\n";
            echo "<th>" . $row['ukedag'] . "</th>\n";
            echo "<th>" . $visdato . "</th>\n";
            echo "<th>" . $row['tidspunkt'] . "</th>\n";
            echo "</tr>\n";
          } else {
            echo "<tr class=\"danger\">\n";
            echo "<th>" . $row['ukedag'] . "</th>\n";
            echo "<th>" . $visdato . "</th>\n";
            echo "<th>" . $row['tidspunkt'] . "</th>\n";
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
    mysqli_close($conn);
  } else {
    echo "Fyll ut behandler og datofelt";
  }
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