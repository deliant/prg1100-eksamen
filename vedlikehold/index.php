<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Bjarum Medical</title>

  <link rel="icon" type="image/x-icon" href="/images/favicon.ico">
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
      if(!$innloggetBruker){
        echo "<li><a href=\"index.php\">Logg inn</a></li>";
      } else {
        echo "<li><a href=\"loggut.php\">Logg ut</a></li>";
      }
      ?>
    </ul>
  </div>
  <!-- Page Content -->
  <div id="page-content-wrapper">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12">
          <h1>Vedlikehold</h1>
          <p>
          <h3>
            Logg inn
            <a data-toggle="tooltip" class="tooltipLink">
              <span class="glyphicon glyphicon-info-sign icon_info" title="Logg inn for å registrere eller endre data"></span>
            </a>
          </h3>
          <form method="post" id="login" name="login" action="">
            <label>Brukernavn</label><input type="text" id="brukernavn" name="brukernavn" required /><br />
            <label>Passord</label><input type="password" id="passord" name="passord" required /><br />
            <label>&nbsp;</label><input class="btn btn-default" type="submit" value="Logg inn" name="submitLogin"><br /><br />
          </form>
          </p>
          <?php
          include("libs/bruker.php");
          if(isset($_POST["submitLogin"])) {
            $brukernavn = trim($_POST["brukernavn"]);
            $passord = trim($_POST["passord"]);
            if(!sjekkLogin($brukernavn, $passord)) {
              echo "Feil brukernavn eller passord.";
            } else {
              $_SESSION["brukernavn"] = $brukernavn;
              echo "<meta http-equiv=\"refresh\" content=\"0;url=vedlikehold.php\">";
            }
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