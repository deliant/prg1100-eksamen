<?php
function registrerBruker() {
  include("db.php");
  $brukernavn = mysqli_real_escape_string($conn, $_POST["brukernavn"]);
  $passord = mysqli_real_escape_string($conn, $_POST["passord"]);
  // Sjekk at tekstfeltene har input
  if(!empty($brukernavn) && !empty($passord)) {
    $sql = "SELECT * FROM bruker WHERE brukernavn='$brukernavn'";
    $result = mysqli_query($conn, $sql) or die("Kan ikke hente data fra databasen." . mysqli_error($conn));
    if(mysqli_num_rows($result) != 0){
      echo "Brukernavnet finnes fra før.";
    } else {
      $kryptert_passord = password_hash($passord, PASSWORD_DEFAULT);
      $sql = "INSERT INTO bruker VALUES('$brukernavn', '$kryptert_passord')";
      mysqli_query($conn, $sql) or die("Kan ikke registrere data i databasen." . mysqli_error($conn));
      echo "Brukeren med innlogging " . $brukernavn . " er nå registrert.<br />";
      echo "<a href='index.php'>Gå til innlogging</a>";
    }
    mysqli_close($conn);
  }
}

function endrePassord() {
  include("db.php");
  $brukernavn = mysqli_real_escape_string($conn, $_SESSION["brukernavn"]);
  $passord = mysqli_real_escape_string($conn, $_POST["endrepassord"]);
  // Sjekk at tekstfeltene har input
  if(!empty($brukernavn) && !empty($passord)) {
    $sql = "SELECT * FROM bruker WHERE brukernavn='$brukernavn'";
    $result = mysqli_query($conn, $sql) or die("Kan ikke hente data fra databasen." . mysqli_error($conn));
    if(mysqli_num_rows($result) > 0) {
      $kryptert_passord = password_hash($passord, PASSWORD_DEFAULT);
      $sql = "UPDATE bruker SET passord='$kryptert_passord' WHERE brukernavn='$brukernavn'";
      mysqli_query($conn, $sql) or die("Kan ikke registrere data i databasen." . mysqli_error($conn));
      echo "Passord for ". $brukernavn ." er oppdatert.<br/>";
      echo "<meta http-equiv=\"refresh\" content=\"1\">";
    } else {
      echo "Feil under database forespørsel: " . mysqli_error($conn);
    }
    mysqli_close($conn);
  }
}

function sjekkLogin($brukernavn, $passord) {
  include("db.php");
  $validUser = true;
  $sql = "SELECT * FROM bruker WHERE brukernavn='$brukernavn'";
  $result = mysqli_query($conn, $sql);
  if(!$result){
    $validUser = false;
  } else {
    $row = mysqli_fetch_array($result);
    $lagretBrukernavn = $row["brukernavn"];
    $lagretPassord = $row["passord"];

    if($brukernavn != $lagretBrukernavn || !password_verify($passord, $lagretPassord)){
      $validUser = false;
    }
  }
  return $validUser;
}
?>