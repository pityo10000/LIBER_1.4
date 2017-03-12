<?php
if (isset($_SESSION['login']) && $_SESSION['login']->getPermission()->getVenues() == 1) {

  require_once 'sql/mysql_crud.php';
  require_once 'class/venue.php';

  $title = "Helyszíneim";
  $itemType = "Helyszín";
  $staticItem = true;

  function echoItem($i, $item) {
    if ($item[$i]->getOwnerId() == $_SESSION['login']->getId()) {
      echo Venue::itemToString($i, $item);
    }
  }

  function echoItemDetails($i, $item) {
    if ($item[$i]->getOwnerId() == $_SESSION['login']->getId()) {
      echo Venue::itemDetailsToString($i, $item);
    }
  }

  function echoItemInsert() {
    echo '
    <div class="modal fade" id="addItem" role="dialog">
      <div class="modal-dialog">
        <div class="modal-content">
        <form method="POST">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <label class="modal-title">Helyszín hozzáadása</label>
          </div>
          <div class="modal-body">
            <label>Helyszín</label>
            <input name="venueName" class="form-control" type="text" required></input>

            </br>

            <div class="col-md-8">
              <label>Alapár</label></br>
            </div>

            <div class="row">
              <div class="col-md-8">
                <input name="venuePrice" class="form-control" type="text" required></input>
              </div>
              <div class="col-md-4">
                <select name="venuePriceUnit" class="form-control" required>
                  <option>Forint</option>
                  <option>Euró</option>
                  <option>Dollár</option>
                </select>
              </div>
            </div>

            </br>

            <div class="col-md-8">
              <label>Mennyi időre vonatkozik az alapár?</label></br>
            </div>

            <div class="row">
              <div class="col-md-8">
                <input name="venueTime" class="form-control" type="text" required></input>
              </div>
              <div class="col-md-4">
                <select name="venueTimeUnit" class="form-control" required>
                  <option>Óra</option>
                  <option>Nap</option>
                  <option>Hét</option>
                  <option>Hónap</option>
                </select>
              </div>
            </div>

            </br>

            <label>Leírás</label>

            <textarea name="venueDescription" class="form-control" style="resize: none;" maxlength="1000" rows="4" required></textarea>

          </div>
          <div class="modal-footer">
            <div class="col-md-1 col-xs-12"></div>
            <input type="submit" class="btn btn-primary col-md-2 col-xs-12"></button>
            <div class="col-md-6 col-xs-12"></div>
            <button type="button" class="btn btn-default col-md-2 col-xs-12" data-dismiss="modal">Mégse</button>
            <div class="col-md-1 col-xs-12"></div>
          </div>

          <input type="hidden" name="action" value="venueInsert"></input>
          </form>
        </div>
      </div>
    </div>
    ';
  }

  $db = new Database();
  $db->connect();
  $db->select('venue', '*', null, null, null, null);
  $res = $db->getResult();

  $item = array();

  foreach ($res as $result) {
      array_push($item, new Venue($result['id'], $result['name'], $result['description'], $result['price'], $result['price_unit'], $result['time'], $result['time_unit'], $result['owner_id'], $result['owner_name']));
  }

} else {
  $notFound = true;
}
?>
