<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Bjarum Medical</title>

  <link rel="icon" href="../images/favicon.ico">
  <link href="css/bootstrap.css" rel="stylesheet">
  <link href="css/style.css" rel="stylesheet">
  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script>
    $("a.tooltipLink").tooltip();
  </script>
</head>
<body>
<body>

<div id="wrapper">
  <!-- Sidebar -->
  <div id="sidebar-wrapper">
    <ul class="sidebar-nav">
      <li class="sidebar-brand"><a href="index.php">Bjarum Medical</a></li>
      <li><a href="behandler.php">Behandler</a></li>
      <li><a href="bilde.php">Bilde</a></li>
      <li><a href="pasient.php">Pasient</a></li>
      <li><a href="timebestilling.php">Timebestilling</a></li>
      <li><a href="timeinndeling.php">Timeinndeling</a></li>
      <li><a href="yrkesgruppe.php">Yrkesgruppe</a></li>
      <hr>
      <li><a href="vedlikehold.php">Vedlikehold</a></li>
      <?php
      session_start();
      @$innloggetBruker = $_SESSION["brukernavn"];
      if(!$innloggetBruker){w
        echo '<li><a href="index.php">Logg inn</a></li>';
      } else {
        echo '<li><a href="loggut.php">Logg ut</a></li>';
      }
      ?>
    </ul>
  </div>
  <!-- Page Content -->
  <div id="page-content-wrapper">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12">
          <h1>BM Vedlikehold</h1>
          <?php
          if(!$innloggetBruker){
            echo "<p>Denne siden krever innlogging.</p>";
          } else {
            include("behandler.inc.php");
          }
          ?>
        </div>
      </div>
    </div>
  </div>
</div>
</html>
</body>
</html>