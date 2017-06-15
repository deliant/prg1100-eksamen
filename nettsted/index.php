<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Bjarum Medical</title>

  <link rel="icon" href="images/favicon.ico">
  <link href="css/bootstrap.css" rel="stylesheet">
  <link href="css/style.css" rel="stylesheet">
  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body>

<?php include("libs/menu.php"); ?>
<!-- Navbar -->
<nav class="navbar navbar-default navbar-fixed-top">
  <div class="container">
    <div class="navbar-header">
      <a class="navbar-brand" href="#"><img src="images/bmlogo.png"></a>
    </div>
    <div id="navbar" class="navbar-collapse collapse">
      <ul class="nav navbar-nav">
        <li class="active"><span class="glyphicon glyphmenuadjust glyphicon-home"></span><a href="index.php">Hjem</a></li>
        <li><span class="glyphicon glyphmenuadjust glyphicon-calendar"></span><a href="timebestilling.php">Timebestilling</a></li>
        <li><span class="glyphicon glyphmenuadjust glyphicon-time"></span><a href="ukesliste.php">Ukesliste</a></li>
        <li class="dropdown">
          <span class="glyphicon glyphmenuadjust glyphicon-user"></span>
          <a href="ansatte.php" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Ansatte<span class="caret"></span></a>
          <ul class="dropdown-menu">
            <?php populateMenu(); ?>
          </ul>
        </li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <?php
        session_start();
        @$innloggetBruker = $_SESSION["personnr"];
        if(!$innloggetBruker) {
          echo "        <li><span class=\"glyphicon glyphmenuadjust glyphicon-cog\"></span><a href=\"minside.php\">Min side</a></li>";
        } else {
          echo "        <li><span class=\"glyphicon glyphmenuadjust glyphicon-cog\"></span><a href=\"minside.php\">Min side</a></li>";
          echo "        <li><span class=\"glyphicon glyphmenuadjust glyphicon-log-out\"></span><a href=\"minside.php?action=loggut\">Logg ut</a></li>";
        }
        ?>
      </ul>
    </div>
  </div>
</nav>
<!-- Jumbotron -->
<div class="jumbotron-front">
  <div class="container bg-jumbo--front">
    <h1>Bestill time</h1>
    <p>Her kan du enkelt finne oversikt og bestille ledige timer hos våre høyt kvalifiserte medarbeidere</p>
    <p>
      <a class="btn btn-success btn-lg text-center" href="timebestilling.php" role="button"><strong>Finn ledig time &raquo;</strong></a>
    </p>
  </div>
</div>
<!-- Columns -->
<div class="cover-bottom">
  <div class="container">
    <div class="bg-bottom">
      <div class="row">
        <div class="col-md-6">
          <h2>Bjarum Medical på web</h2>
          <p>Her kan du kjapt og enkelt bestille, endre og avlyse avtaler hos våre behandlere på vår kundeportal. Du finner også oversikt over når våre medarbeidere har ledige timer</p>
          <p>Vi jobber kontinuerlig med å forbedre din kundeopplevelse hos oss</p>
        </div>
        <div class="col-md-6">
          <h2>Ansatte</h2>
          <p>På Bjarum Medical har vi mange ansatte over flere yrkesgrupper, og kan garantert treffe ditt behov for legetjenester med en høy standard</p>
          <p>La våre dyktige medarbeidere ta vare på livskvaliteten din!</p>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6">
          <p><a class="btn btn-primary" href="ukesliste.php" role="button">Ukesliste &raquo;</a></p>
        </div>
        <div class="col-md-6">
          <p><a class="btn btn-primary" href="ansatte.php" role="button">Gå til ansatte &raquo;</a></p>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.js"></script>
<script src="js/bootstrap.js"></script>

</body>
</html>