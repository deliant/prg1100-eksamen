<ul class="nav nav-tabs">
  <li class="active"><a data-toggle="tab" href="#sok"><span class="glyphicon glyphminiadjust glyphicon-search"></span>Søk</a></li>
</ul>

<div id="validering"></div>
<div class="tab-content">
  <div id="sok" class="tab-pane fade in active">
    <h3>
      Søk
      <a data-toggle="tooltip" class="tooltipLink">
        <span class="glyphicon glyphicon-info-sign icon_info" title="Søk i databasen etter objekter"></span>
      </a>
    </h3>
    <p>
      <?php
      include("libs/sok.php");
      ?>
    </p>
  </div>
</div>