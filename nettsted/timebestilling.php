<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Timebestilling | Bjarum Medical</title>

  <link rel="icon" href="images/favicon.ico">
  <link href="css/bootstrap.css" rel="stylesheet">
  <link href="css/style.css" rel="stylesheet">
  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
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
        <li><span class="glyphicon glyphmenuadjust glyphicon-home"></span><a href="index.php">Hjem</a></li>
        <li class="active"><span class="glyphicon glyphmenuadjust glyphicon-calendar"></span><a href="timebestilling.php">Timebestilling</a></li>
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
<div id="validering"></div>
<?php
include("libs/listeboks.php");
include("libs/timebestilling.php");
?>
<!-- Jumbotron -->
<div class="jumbotron-timebestilling">
  <div class="container bg-jumbo">
    <h1>Bestill time</h1>
    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" onsubmit="return validerTimebestillingRegistrering()">
      <div class="form-group">
        <label>Behandler</label>
        <select class="form-control" id="regBehandler" name="regBehandler" onchange="listeboksRegTimebestillingBehandler(this.value)">
          <option>Hvem ønsker du time hos?</option>
          <?php listeboksBehandler(); ?>
        </select>
        <label>Dato</label>
        <input type="text" class="form-control" id="regDato" name="regDato" onchange="listeboksRegTimebestillingDato(this.value)" required />
        <label>Tidspunkt</label>
        <select class="form-control" id="regTidspunkt" name="regTidspunkt">
          <option value="NULL">Velg behandler og dato</option>
        </select><br/>
          <input class="btn btn-success btn-lg text-center" type="submit" name="submitRegTimebestilling" role="button" value="Bestill time &raquo;">
      </div>
    </form>
    <?php
    if(!$innloggetBruker) {
      echo "<p>Du må være <a href=\"minside.php\" role=\"button\">innlogget</a> for å registrere time</p>\n";
    }
    ?>
  </div>
</div>
<!-- Columns -->
<div class="cover-bottom">
  <div class="container">
    <div class="bg-bottom" id="ajax">
      <div class="row">
        <div class="col-md-6">
          <h2>Bestill time</h2>
          <p>Her kan du enkelt finne oversikt og bestille ledige timer hos våre høyt kvalifiserte medarbeidere over mange yrkesgrupper. Din trygghet er vår suksess!</p>
        </div>
        <div class="col-md-6">
          <h2>Kjerneverdier</h2>
          <ul class="list-group">
            <li class="list-group-item">Ærlighet</li>
            <li class="list-group-item">Dyktighet</li>
            <li class="list-group-item">Omsorg</li>
            <li class="list-group-item">Service</li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>

<?php
if(isset($_POST["submitRegTimebestilling"])) {
  registrerTimebestilling();
}
?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="js/bootstrap.js"></script>
<script src="js/ajax.js"></script>
<script src="js/validering.js"></script>
<script src="js/datepicker.js"></script>
<script src="js/datepicker-no.js"></script>

</body>
</html>