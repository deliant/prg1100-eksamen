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
      <a class="navbar-brand" href="#">Bjarum Medical</a>
    </div>
    <div id="navbar" class="navbar-collapse collapse">
      <ul class="nav navbar-nav">
        <li><span class="glyphicon glyphmenuadjust glyphicon-home"></span><a href="index.php">Hjem</a></li>
        <li><span class="glyphicon glyphmenuadjust glyphicon-calendar"></span><a href="timebestilling.php">Timebestilling</a></li>
        <li class="active"><span class="glyphicon glyphmenuadjust glyphicon-time"></span><a href="ukesliste.php">Ukesliste</a></li>
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
<?php
//include("libs/timebestilling.php");
include("libs/listeboks.php");
?>
<!-- Jumbotron -->
<div class="jumbotron-timebestilling">
  <div class="container bg-jumbo">
    <h1>Ukesliste</h1>
    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
      <div class="form-group">
        <label>Behandler</label>
        <select class="form-control" id="velgBehandler" name="velgBehandler" onchange="listeboksRegTimebestillingBehandler(this.value)">
          <option>Hvem ønsker du ukesliste for?</option>
          <?php listeboksBehandler(); ?>
        </select>
        <label>Dato</label>
        <input type="text" class="form-control" id="velgDato" name="velgDato" onchange="listeboksRegTimebestillingDato(this.value)" required />
        <input class="btn btn-primary btn-lg" type="submit" name="submitVelgUkesliste" role="button" value="Søk &raquo;">
      </div>
    </form>
  </div>
</div>
<!-- Columns -->
<div class="cover-bottom">
  <div class="container">
    <div class="bg-bottom">
      <?php
      if(isset($_POST["submitVelgUkesliste"])) {
        //velgUkesliste();
      }
      ?>
    </div>
  </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="js/bootstrap.js"></script>
<script src="js/ajax.js"></script>
<script>
  $(function() {
    $('#velgDato').datepicker({
      dateFormat: 'yy-mm-dd',
      prevText:'',
      nextText:'',
      minDate: "+0",
      maxDate: "+365"
    });
  });
</script>

</body>
</html>