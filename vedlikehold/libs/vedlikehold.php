<?php
function sjekkLogin($brukernavn, $passord) {
  include("db.php");
  $validUser = true;

  if(!$brukernavn || !$passord) {
    $validUser = false;
  }

  $sql = "SELECT * FROM bruker WHERE brukernavn='$brukernavn'";
  $result = mysqli_query($conn, $sql);
  if(!$result){
    $validUser = false;
  } else {
    $row = mysqli_fetch_assoc($result);
    $lagretBrukernavn = mysqli_real_escape_string($conn, $row["brukernavn"]);
    $lagretPassord = mysqli_real_escape_string($conn, $row["passord"]);

    if($brukernavn != $lagretBrukernavn || !password_verify($passord, $lagretPassord)){
      $validUser = false;
    }
  }

  mysqli_close($conn);

  return $validUser;
}

function endrePassord($brukernavn, $passord) {
  include("db.php");
  // Sjekk at tekstfeltene har input
  if(!empty($brukernavn) && !empty($passord)) {
    $sql = "SELECT * FROM bruker WHERE brukernavn='$brukernavn'";
    $result = mysqli_query($conn, $sql) or die("Kan ikke hente data fra databasen." . mysqli_error($conn));

    if(mysqli_num_rows($result) > 0) {
      $kryptert_passord = mysqli_real_escape_string($conn, password_hash($passord, PASSWORD_DEFAULT));
      $sql = "UPDATE bruker SET passord='$kryptert_passord' WHERE brukernavn='$brukernavn'";
      mysqli_query($conn, $sql) or die("Kan ikke registrere data i databasen." . mysqli_error($conn));
      echo "<div class=\"alert alert-success\">Passord for ". $brukernavn ." er oppdatert.</div>\n";
      echo "<meta http-equiv=\"refresh\" content=\"1\">\n";
    } else {
      echo "<div class=\"alert alert-danger\">Feil under database forespørsel: " . mysqli_error($conn) . "</div>\n";
    }
  } else {
    echo "<div class=\"alert alert-danger\" align=\"top\">Fyll ut alle felt. Registrering ikke godkjent</div>\n";
  }

  mysqli_close($conn);
}

function visBruker() {
  include("db.php");
  $sql = "SELECT brukernavn FROM bruker
  ORDER BY brukernavn";
  $result = mysqli_query($conn, $sql);

  if(mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
      echo "<tr>\n";
      echo "<td>". htmlspecialchars($row['brukernavn']) ."</td>\n";
      echo "</tr>\n";
    }
  } else {
    echo "<tr><td>Ingen brukere funnet</td></tr>\n";
  }

  mysqli_close($conn);
}

function registrerBruker() {
  include("db.php");
  $brukernavn = mysqli_real_escape_string($conn, $_POST["regBrukernavn"]);
  $passord = mysqli_real_escape_string($conn, $_POST["regPassord"]);

  // Sjekk at tekstfeltene har input
  if(!empty($brukernavn) && !empty($passord)) {
    $sql = "SELECT * FROM bruker WHERE brukernavn='$brukernavn'";
    $result = mysqli_query($conn, $sql) or die("Kan ikke hente data fra databasen." . mysqli_error($conn));

    if(mysqli_num_rows($result) != 0){
      echo "<div class=\"alert alert-danger\">Brukernavnet finnes fra før.</div>\n";
    } else {
      $kryptert_passord = password_hash($passord, PASSWORD_DEFAULT);
      $sql = "INSERT INTO bruker VALUES('$brukernavn', '$kryptert_passord')";
      mysqli_query($conn, $sql) or die("Kan ikke registrere data i databasen." . mysqli_error($conn));
      echo "<div class=\"alert alert-success\">Brukeren med innlogging " . $brukernavn . " er nå registrert.<br/>\n";
      echo "<a href=\"index.php\">Gå til innlogging</a></div>\n";
    }
  } else {
    echo "<div class=\"alert alert-danger\" align=\"top\">Fyll ut alle felt. Registrering ikke godkjent</div>\n";
  }

  mysqli_close($conn);
}

function slettBruker() {
  include("db.php");
  $brukernavn = mysqli_real_escape_string($conn, $_POST["slettBruker"]);

  if(!empty($brukernavn) && $brukernavn != "NULL") {
    $sql = "DELETE FROM bruker WHERE brukernavn='$brukernavn'";

    if(mysqli_query($conn, $sql)) {
      echo "<div class=\"alert alert-success\">Databasen oppdatert.</div>\n";
      echo "<meta http-equiv=\"refresh\" content=\"1\">\n";
    } else {
      echo "<div class=\"alert alert-danger\">Feil under database forespørsel: ". mysqli_error($conn) ."</div>\n";
    }
  }

  mysqli_close($conn);
}


include("db.php");
if(@$_GET["action"] == "endre") {
  $brukernavn = mysqli_real_escape_string($conn, $_GET["brukernavn"]);
  $sql = "SELECT brukernavn, passord
  FROM bruker
  WHERE brukernavn='$brukernavn'";
  $result = mysqli_query($conn, $sql);

  while($row = mysqli_fetch_assoc($result)) {
    echo "<h3>Endring</h3>\n";
    echo "<form action=\"\" method=\"post\" onsubmit=\"return validerBrukerEndring()\">\n";
    echo "<label>Brukernavn</label><input type=\"text\" name=\"endringBrukernavn\" value=\"" . htmlspecialchars($row['brukernavn']) . "\" readonly required/><br/>\n";
    echo "<label>Passord</label><input type=\"password\" id=\"endringPassord\" name=\"endringPassord\" required/><br/>\n";

    echo "</select><br/>\n";
    echo "<label>&nbsp;</label><input class=\"btn btn-primary\" type=\"submit\" value=\"Endre\" name=\"submitEndreBruker\">\n";
    echo "</form>\n";
  }

  mysqli_close($conn);
}
?>