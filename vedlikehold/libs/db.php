<?php
$servername = "localhost";
$username = "webdev";
$password = "webdev123";
$dbname = "prg1100v-eksamen";
$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
  die("Database tilknytning gikk galt: " . mysqli_connect_error());
}
?>