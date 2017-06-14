<?php
@$sokeKnapp = $_POST["submitSok"];
if($sokeKnapp) {
  include("db.php");
  $sokestreng = $_POST["sokestreng"];
  echo "Leter opp søkestreng i databasen: <strong>$sokestreng</strong><br/><br/>\n";
  $sql = "SELECT brukernavn, behandlernavn, yrkesgruppenavn
  FROM behandler as b
  LEFT JOIN yrkesgruppe ON b.yrkesgruppenr = yrkesgruppe.yrkesgruppenr
  WHERE brukernavn LIKE '%$sokestreng%' OR behandlernavn LIKE '%$sokestreng%' 
  OR yrkesgruppenavn LIKE '%$sokestreng%'";
  $result = mysqli_query($conn, $sql);

  if(mysqli_num_rows($result) > 0) {
    echo "Treff i <strong>&quot;behandler&quot;</strong> databasen<br/></br>\n";

    while($row = mysqli_fetch_assoc($result)) {
      $brukernavn = $row["brukernavn"];
      $behandlernavn = $row["behandlernavn"];
      $yrkesgruppe = $row["yrkesgruppenavn"];

      $tekst = "Navn: " .htmlspecialchars($behandlernavn). " - Brukernavn: " .htmlspecialchars($brukernavn). "<br/>Yrkesgruppe: " .htmlspecialchars($yrkesgruppe). "<br/><br/>\n";
      $tekstlengde = strlen($tekst);
      $sokestrenglengde = strlen($sokestreng);
      $startpos = stripos($tekst, $sokestreng);

      $hode = substr($tekst, 0, $startpos);
      $sok = substr($tekst, $startpos, $sokestrenglengde);
      $hale = substr($tekst, $startpos + $sokestrenglengde, $tekstlengde - $startpos - $sokestrenglengde);

      echo $hode . "<strong>" . $sok . "</strong>" . $hale;
    }
  } else {
    echo "Ingen treff i <strong>&quot;behandler&quot;</strong> databasen<br/><br/>\n";
  }


  $sql = "SELECT * FROM pasient 
  WHERE personnr LIKE '%$sokestreng%' OR pasientnavn LIKE '%$sokestreng%'";
  $result = mysqli_query($conn, $sql);

  if(mysqli_num_rows($result) > 0) {
    echo "Treff i <strong>&quot;pasient&quot;</strong> databasen<br/></br>\n";

    while($row = mysqli_fetch_assoc($result)) {
      $brukernavn = $row["brukernavn"];
      $navn = $row["pasientnavn"];
      $personnr = $row["personnr"];

      $tekst = "Navn: " . htmlspecialchars($navn) . " - Personnr: " . htmlspecialchars($personnr) . "<br/>Fastlege: " . htmlspecialchars($brukernavn) . "<br/><br/>\n";
      $tekstlengde = strlen($tekst);
      $sokestrenglengde = strlen($sokestreng);
      $startpos = stripos($tekst, $sokestreng);

      $hode = substr($tekst, 0, $startpos);
      $sok = substr($tekst, $startpos, $sokestrenglengde);
      $hale = substr($tekst, $startpos + $sokestrenglengde, $tekstlengde - $startpos - $sokestrenglengde);

      echo $hode . "<strong>" . $sok . "</strong>" . $hale;
    }
  } else {
    echo "Ingen treff i <strong>&quot;pasient&quot;</strong> databasen<br/></br>\n";
  }


  $sql = "SELECT dato, tidspunkt, behandlernavn, pasientnavn, t.brukernavn, t.personnr
  FROM timebestilling AS t
  LEFT JOIN behandler ON t.brukernavn = behandler.brukernavn
  LEFT JOIN pasient ON t.personnr = pasient.personnr
  WHERE t.personnr LIKE '%$sokestreng%' OR pasientnavn LIKE '%$sokestreng%' 
  OR t.brukernavn LIKE '%$sokestreng%' OR behandlernavn LIKE '%$sokestreng%' 
  OR dato LIKE '%$sokestreng%' OR tidspunkt LIKE '%$sokestreng%'";
  $result = mysqli_query($conn, $sql);

  if(mysqli_num_rows($result) > 0) {
    echo "Treff i <strong>&quot;timebestilling&quot;</strong> databasen<br/></br>\n";

    while($row = mysqli_fetch_assoc($result)) {
      $brukernavn = $row["brukernavn"];
      $behandlernavn = $row["behandlernavn"];
      $pasientnavn = $row["pasientnavn"];
      $personnr = $row["personnr"];
      $dato = $row["dato"];
      $tidspunkt = $row["tidspunkt"];

      $tekst = "Fastlege: ". htmlspecialchars($behandlernavn) ." - Brukernavn: ". htmlspecialchars($brukernavn) ."<br/>
      Personnr: ". htmlspecialchars($personnr) ." - Navn: ". htmlspecialchars($pasientnavn) ."<br/>
      Dato: ". htmlspecialchars($dato) ." - Tidspunkt: ". htmlspecialchars($tidspunkt) ."<br/><br/>\n";
      $tekstlengde = strlen($tekst);
      $sokestrenglengde = strlen($sokestreng);
      $startpos = stripos($tekst, $sokestreng);

      $hode = substr($tekst,0,$startpos);
      $sok = substr($tekst,$startpos,$sokestrenglengde);
      $hale = substr($tekst,$startpos+$sokestrenglengde,$tekstlengde-$startpos-$sokestrenglengde);

      echo $hode. "<strong>".$sok."</strong>" .$hale;
    }
  } else {
    echo "Ingen treff i <strong>&quot;timebestilling&quot;</strong> databasen<br/></br>\n";
  }

}
?>