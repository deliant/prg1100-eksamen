<?php
$target_dir = "D:\\Sites\\home.hbv.no\\phptemp\\web-prg11v10/";
$target_file = $target_dir . basename($_FILES["regFilnavn"]["name"]);
$uploadOk = 1;
$bildeFiltype = pathinfo($target_file,PATHINFO_EXTENSION);

// Sjekk om fake
if(isset($_POST["submitRegBilde"])) {
  $sjekk = getimagesize($_FILES["regFilnavn"]["tmp_name"]);
  if($sjekk !== false) {
    $uploadOk = 1;
  } else {
    echo "Filen er ikke ett gyldig bilde.<br/>";
    $uploadOk = 0;
  }
}

// Sjekk om filen eksisterer
if(file_exists($target_file)) {
  echo "<div class=\"alert alert-danger\">Filen eksisterer allerede.</div>\n";
  $uploadOk = 0;
}

// Sjekk filstørrelse
if($_FILES["regFilnavn"]["size"] > 500000) {
  echo "<div class=\"alert alert-danger\">Filen er for stor. (over 0,5MB)</div>\n";
  $uploadOk = 0;
}

// Sjekk filformat
if($bildeFiltype != "jpg" && $bildeFiltype != "png" && $bildeFiltype != "jpeg" && $bildeFiltype != "gif" ) {
  echo "<div class=\"alert alert-danger\">Filen er ikke gyldig format (kun jpg, jpeg, png eller gif).</div>\n";
  $uploadOk = 0;
}

if($uploadOk == 0) {
  echo "<div class=\"alert alert-danger\">Filen ble ikke lastet opp.</div>";
  // Upload
} else {
  if(move_uploaded_file($_FILES["regFilnavn"]["tmp_name"], $target_file)) {
    echo "<div class=\"alert alert-success\">Filen ". basename($_FILES['regFilnavn']['name']) ." har blitt lastet opp.</div>\n";
  } else {
    $uploadOk = 0;
    echo "<div class=\"alert alert-danger\">Beklager, det var en feil med opplastning av bildefil.</div>\n";
  }
}
?>
