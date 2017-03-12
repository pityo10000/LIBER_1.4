<div id="info"></div>

<script type="text/javascript" src="js/browse.js?version=1.1"></script>

<?php

    if (isset($_SESSION['alertType']) && isset($_SESSION['alertText'])) {
      echo '<div class="alert alert-' . $_SESSION['alertType'] . '">
        ' . $_SESSION['alertText'] . '
      </div>';
      $_SESSION['alertType'] = null;
      $_SESSION['alertText'] = null;
    }

    if (isset($_GET['keywords'])) {

      echo '
        <div class="alert alert-info">
          <h4><strong>Keresett kifejezés: ' . $_GET['keywords'] . '</strong></h4>
        </div>
      ';
    }


    if (!$staticItem) {
      echo '
        <form method="POST">
    			<div class="row">
    				<div class="col-md-1 col-xs-12"></div>
    				<button class="col-md-2 col-xs-12 btn btn-default ' . $venue . '" type="submit" name="itemType" value="venue"/>Helyszín</button>
    				<button class="col-md-2 col-xs-12 btn btn-default ' . $organizer . '" type="submit" name="itemType" value="organizer"/>Rendezvényszervezőcég</button>
            <button class="col-md-2 col-xs-12 btn btn-default ' . $serviceProvider . '" type="submit" name="itemType" value="serviceProvider"/>Szolgáltató</button>
    				<button class="col-md-2 col-xs-12 btn btn-default ' . $equipment . '" type="submit" name="itemType" value="equipment"/>Felszerelések</button>
    				<button class="col-md-2 col-xs-12 btn btn-default ' . $service . '" type="submit" name="itemType" value="service"/>Szolgáltatások</button>
    				<div class="col-md-1 col-xs-12"></div>
    			</div>
    		</form>

    		<div class="btn-group row scrollButtons" role="group" aria-label="...">
    			<button type="button" class="btn btn-default"><span class="glyphicon glyphicon-step-backward"></span></button>
    			<button type="button" class="btn btn-default"><span class="glyphicon glyphicon-chevron-left"></span></button>
    			<button type="button" class="btn btn-default">...</button>
    			<button type="button" class="btn btn-default">4</button>
    			<button type="button" class="btn btn-default">5</button>
    			<button type="button" class="btn btn-default">6</button>
    			<button type="button" class="btn btn-default">7</button>
    			<button type="button" class="btn btn-default">...</button>
    			<button type="button" class="btn btn-default"><span class="glyphicon glyphicon-chevron-right"></span></button>
    			<button type="button" class="btn btn-default"><span class="glyphicon glyphicon-step-forward"></span></button>
    		</div>

        </br>
      ';
    } else {
      echo '
        </br>

        <div class="row">
          <div class="col-md-4 col-xs-2"></div>
          <button class="btn btn-default col-md-4 col-xs-8" style="height: 50px; border-radius: 25px;" data-toggle="modal" data-target="#addItem"><label>' . $itemType . ' hozzáadása</label></div>
          <div class="col-md-4 col-xs-2"></div>
        </div>

        </br>
      ';
      echoItemInsert();
      }
    ?>

    <div class="row">

    <?php
    for ($i = 0; $i < count($item); $i++) {
      echoItem($i, $item);
    }
    ?>

    </div>
    <?php
    for ($i = 0; $i < count($item); $i++) {
      echoItemDetails($i, $item);
    }

    if (!$staticItem) {
      echo '
    		<div class="btn-group row scrollButtons" role="group" aria-label="...">
    			<button type="button" class="btn btn-default"><span class="glyphicon glyphicon-step-backward"></span></button>
    			<button type="button" class="btn btn-default"><span class="glyphicon glyphicon-chevron-left"></span></button>
    			<button type="button" class="btn btn-default">...</button>
    			<button type="button" class="btn btn-default">4</button>
    			<button type="button" class="btn btn-default">5</button>
    			<button type="button" class="btn btn-default">6</button>
    			<button type="button" class="btn btn-default">7</button>
    			<button type="button" class="btn btn-default">...</button>
    			<button type="button" class="btn btn-default"><span class="glyphicon glyphicon-chevron-right"></span></button>
    			<button type="button" class="btn btn-default"><span class="glyphicon glyphicon-step-forward"></span></button>
    		</div>
      ';
    }
    ?>
