<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Ansatte | Bjarum Medical</title>

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
include("libs/ansatte.php");
include("libs/listeboks.php");
?>
<!-- Jumbotron -->
<div class="jumbotron-ansatte">
  <div class="container bg-jumbo">
    <h1>Ansatte</h1>
    <p>Bjarum Medical har mange dyktige medarbeidere over flere yrkesgrupper og kan garantert hjelpe deg med dine behov</p>
    <p>
      <a class="btn btn-success btn-lg" href="timebestilling.php" type="submit" role="button">Finn ledig time &raquo;</a>
    </p>
  </div>
</div>
<!-- Columns -->
<div class="cover-bottom">
  <div class="container">
    <div class="bg-bottom" id="ajax">
      <div class="panel panel-default">
        <div class="panel-heading">Ansatte</div>
        <table class="table">
          <tr>
            <th></th>
            <th>Navn</th>
            <th>Yrkesgruppe</th>
          </tr>
          <?php
          visAnsatte();
          ?>
        </table>
      </div>
    </div>
  </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.js"></script>
<script src="js/bootstrap.js"></script>
<script src="js/ajax.js"></script>

</body>
</html>