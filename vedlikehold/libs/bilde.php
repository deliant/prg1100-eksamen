<?php
function visBilde() {
  include("db.php");
  $sql = "SELECT * FROM bilde";
  $result = mysqli_query($conn, $sql);

  if(mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
      echo "<tr>\n";
      echo "<td>". $row['bildenr'] ."</td>\n";
      echo "<td>". $row['opplastingsdato'] ."</td>\n";
      echo "<td>". $row['filnavn'] ."</td>\n";
      echo "<td>". $row['beskrivelse'] ."</td>\n";
      echo "<td><form action=". $_SERVER['PHP_SELF'] ." method=\"post\">\n";
      echo "<input type=\"hidden\" name=\"edit_id\" value=". $row['bildenr'] ." />\n";
      echo "<button class=\"btn btn-primary btn-xs\" type=\"submit\" title=\"Endre\"><span class=\"glyphicon glyphicon-edit\"></span></button>\n";
      echo "</form></td>\n";
      echo "<td><form action=". $_SERVER['PHP_SELF'] ." method=\"post\">\n";
      echo "<input type=\"hidden\" name=\"delete_id\" value=". $row['bildenr'] ." />\n";
      echo "<button class=\"btn btn-danger btn-xs\" type=\"submit\" title=\"Slett\"><span class=\"glyphicon glyphicon-trash\"></span></button>\n";
      echo "</form></td>\n";
      echo "</tr>\n";
    }
  } else {
    echo "<tr><td>Ingen bilder funnet</td><td>&nbsp;</td></tr>\n";
  }
  mysqli_close($conn);
}

function registrerBilde() {
  include("db.php");
  $filnavn = basename($_FILES["filnavn"]["name"]);
  $beskrivelse = mysqli_real_escape_string($conn, $_POST["beskrivelse"]);
  $dato = date("Y-m-d");
  // Sjekk at tekstfeltene har input
  if(!empty($filnavn) && !empty($beskrivelse)) {
    // Sett inn i databasen
    $sql = "INSERT INTO bilde (opplastingsdato, filnavn, beskrivelse)
    VALUES ('$dato', '$filnavn', '$beskrivelse')";

    if(mysqli_query($conn, $sql)) {
      echo "$beskrivelse registrert i bilde databasen.";
      //echo "<meta http-equiv=\"refresh\" content=\"1\">";
    } else {
      echo "Feil under database forespørsel: " . mysqli_error($conn);
    }
    mysqli_close($conn);
  }
}

function slettBilde() {
  include("db.php");
  $bildenr = mysqli_real_escape_string($conn, $_POST["velgBildenr"]);
  $sql = "DELETE FROM bilde WHERE bildenr='$bildenr'";
  if(mysqli_query($conn, $sql)) {
    echo "Databasen oppdatert.<br/><br />";
    echo "<meta http-equiv=\"refresh\" content=\"1\">";
  } else {
    echo "Feil under database forespørsel: " . mysqli_error($conn);
  }
  mysqli_close($conn);
}

function slettBildeFraVis() {
  include("db.php");
  $bildenr = mysqli_real_escape_string($conn, $_POST["delete_id"]);
  if(!empty($bildenr)) {
    $sql = "DELETE FROM bilde WHERE bildenr='$bildenr'";

    if(mysqli_query($conn, $sql)) {
      echo "Databasen oppdatert.<br/><br />";
      echo "<meta http-equiv=\"refresh\" content=\"1\">";
    } else {
      echo "Feil under database forespørsel: " . mysqli_error($conn);
    }
    mysqli_close($conn);
  }
}
?>