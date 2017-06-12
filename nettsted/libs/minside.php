<?php
function registrerBruker() {
  include("db.php");
  $personnr = mysqli_real_escape_string($conn, $_POST["regPersonnr"]);
  $passord = mysqli_real_escape_string($conn, $_POST["regPassord"]);

  // Sjekk at tekstfeltene har input
  if(!empty($personnr) && !empty($passord)) {
    $sql = "SELECT * FROM pasientbruker WHERE personnr='$personnr'";
    $result = mysqli_query($conn, $sql) or die("Kan ikke hente data fra databasen." . mysqli_error($conn));

    if(mysqli_num_rows($result) != 0) {
      echo "<div class=\"alert alert-danger\">Personnummeret finnes fra før i databasen.</div>\n";
    } else {
      $kryptert_passord = password_hash($passord, PASSWORD_DEFAULT);
      $sql = "INSERT INTO pasientbruker VALUES('$personnr', '$kryptert_passord')";
      mysqli_query($conn, $sql) or die("Kan ikke registrere data i databasen." . mysqli_error($conn));
      echo "<div class=\"alert alert-success\">Brukeren med innlogging " . $personnr . " er nå registrert.<br/>\n";
      echo "<a href=\"minside.php\">Gå til innlogging</a></div>\n";
    }
  }

  mysqli_close($conn);
}

function endrePassord() {
  include("db.php");
  $personnr = mysqli_real_escape_string($conn, $_SESSION["personnr"]);
  $passord = mysqli_real_escape_string($conn, $_POST["passord"]);

  // Sjekk at tekstfeltene har input
  if(!empty($personnr) && !empty($passord)) {
    $sql = "SELECT * FROM pasientbruker WHERE personnr='$personnr'";
    $result = mysqli_query($conn, $sql) or die("Kan ikke hente data fra databasen." . mysqli_error($conn));

    if(mysqli_num_rows($result) > 0) {
      $kryptert_passord = mysqli_real_escape_string($conn, password_hash($passord, PASSWORD_DEFAULT));
      $sql = "UPDATE pasientbruker SET passord='$kryptert_passord' WHERE personnr='$personnr'";
      mysqli_query($conn, $sql) or die("Kan ikke registrere data i databasen." . mysqli_error($conn));
      echo "<div class=\"alert alert-success\">Passord for ". $personnr ." er oppdatert.</div>\n";
      echo "<meta http-equiv=\"refresh\" content=\"1\">\n";
    } else {
      echo "<div class=\"alert alert-danger\">Feil under database forespørsel: " . mysqli_error($conn) . "</div>\n";
    }
  }

  mysqli_close($conn);
}

function sjekkLogin($personnr, $passord) {
  include("db.php");
  $validUser = true;

  if(!$personnr || !$passord) {
    $validUser = false;
  }

  $sql = "SELECT * FROM pasientbruker WHERE personnr='$personnr'";
  $result = mysqli_query($conn, $sql);
  if(!$result){
    $validUser = false;
  } else {
    $row = mysqli_fetch_assoc($result);
    $lagretPersonnr = mysqli_real_escape_string($conn, $row["personnr"]);
    $lagretPassord = mysqli_real_escape_string($conn, $row["passord"]);

    if($personnr != $lagretPersonnr || !password_verify($passord, $lagretPassord)){
      $validUser = false;
    }
  }

  mysqli_close($conn);

  return $validUser;
}

if(@$_GET["action"] == "ajaxReg") {
  echo "<div class=\"form-group\">\n";
  echo "<h2>Registrering</h2>\n";
  echo "<form method=\"post\" action=\"\">\n";
  echo "<div class=\"row\">\n";
  echo "<div class=\"col-md-2\"><label>Personnr</label></div><div class=\"col-md-4\"><input type=\"text\" class=\"form-control\" name=\"regPersonnr\" required /></div>\n";
  echo "</div><div class=\"row\">\n";
  echo "<div class=\"col-md-2\"><label>Passord</label></div><div class=\"col-md-4\"><input type=\"password\" class=\"form-control\" name=\"regPassord\" required /></div>\n";
  echo "</div><div class=\"row\">\n";
  echo "<div class=\"col-md-2\"><label>&nbsp;</label></div><div class=\"col-md-4\"><input class=\"btn btn-success btn-lg\" type=\"submit\" value=\"Registrer\" name=\"submitRegBruker\"></div>\n";
  echo "</div>\n";
  echo "</div>\n";
  echo "</form>\n";
}
?>