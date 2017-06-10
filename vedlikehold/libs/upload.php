<?php
$target_dir = "../bilder/";
$target_file = $target_dir . basename($_FILES["regFilnavn"]["name"]);
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

// Check if image file is a actual image or fake image
if(isset($_POST["submitRegBilde"])) {
  $check = getimagesize($_FILES["regFilnavn"]["tmp_name"]);
  if($check !== false) {
    $uploadOk = 1;
  } else {
    echo "Filen er ikke ett gyldig bilde.<br/>";
    $uploadOk = 0;
  }
}

// Check if file already exists
if(file_exists($target_file)) {
  echo "Filen eksisterer allerede.<br/>";
  $uploadOk = 0;
}

// Check file size
if($_FILES["regFilnavn"]["size"] > 500000) {
  echo "Filen er for stor. (over 0,5MB)<br/>";
  $uploadOk = 0;
}

// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
  echo "Filen er ikke gyldig format (kun jpg, jpeg, png eller gif).<br/>";
  $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if($uploadOk == 0) {
  echo "Filen ble ikke lastet opp.";
  // if everything is ok, try to upload file
} else {
  if(move_uploaded_file($_FILES["regFilnavn"]["tmp_name"], $target_file)) {
    echo "Filen ". basename($_FILES['regFilnavn']['name']) ." har blitt lastet opp.<br/>";
  } else {
    $uploadOk = 0;
    echo "Beklager, det var en feil med opplastning av bildefil.<br/>";
  }
}
?>
