<?php
if (isset($_SESSION['login']) && $_SESSION['login']->getPermission()->getEquipments() == 1) {

  require_once 'sql/mysql_crud.php';
  require_once 'class/equipment.php';

  $title = "Felszereléseim";
  $itemType = "Felszerelés";
  $staticItem = true;

  function echoItem($i, $item) {
    if ($item[$i]->getOwnerId() == $_SESSION['login']->getId()) {
      echo Equipment::itemToString($i, $item);
    }
  }

  function echoItemDetails($i, $item) {
    if ($item[$i]->getOwnerId() == $_SESSION['login']->getId()) {
      echo Equipment::itemDetailsToString($i, $item);
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
            <label class="modal-title">Felszerelés hozzáadása</label>
          </div>
          <div class="modal-body">
      ';

      if ($_SESSION['login']->getPermission()->getPermissionName() != 'service') {

        echo '
          <label>Válassza ki, hogy melyik helyszínhez tartozik a felszerelés!</label></br>
          <select name="venueId" class="form-control" required>
        ';

        $db = new Database();
        $db->connect();
        $db->select('venue', 'id, name', null, 'owner_id=' . $_SESSION['login']->getId(), null, null);
        $res = $db->getResult();

        foreach ($res as $result) {
          echo '<option value="' . $result['id'] . '">' . $result['name'] . '</option>';
        }

        echo '
            <option value="0">Nem helyszínhez kötött</option>
          </select>
        ';
      } else {
        echo '<input type="hidden" name="venueId" value="0"></input>';
      }

      echo '
            </br>

            <label>Felszerlés neve</label>
            <input name="equipmentName" class="form-control" type="text" required></input>

            </br>

            <label>Hány darab áll rendelkezésre?</label></br>

            <input name="equipmentAmount" class="form-control" type="text" required></input>

            </br>

            <div class="col-md-8">
              <label>Egy darab ára?</label></br>
            </div>

            <div class="row">
              <div class="col-md-8">
                <input name="equipmentPrice" class="form-control" type="text" required></input>
              </div>
              <div class="col-md-4">
                <select name="equipmentPriceUnit" class="form-control" required>
                  <option>Forint</option>
                  <option>Euró</option>
                  <option>Dollár</option>
                </select>
              </div>
            </div>

            </br>

            <div class="col-md-8">
              <label>Mennyi időre vonatkozik az Ár?</label></br>
            </div>

            <div class="row">
              <div class="col-md-8">
                <input name="equipmentTime" class="form-control" type="text" required></input>
              </div>
              <div class="col-md-4">
                <select name="equipmentTimeUnit" class="form-control" required>
                  <option>Óra</option>
                  <option>Nap</option>
                  <option>Hét</option>
                  <option>Hónap</option>
                </select>
              </div>
            </div>

            </br>

            <label>Leírás</label>

            <textarea name="equipmentDescription" class="form-control" style="resize: none;" maxlength="1000" rows="4" required></textarea>

          </div>
          <div class="modal-footer">
            <div class="col-md-1 col-xs-12"></div>
            <input type="submit" class="btn btn-primary col-md-2 col-xs-12"></button>
            <div class="col-md-6 col-xs-12"></div>
            <button type="button" class="btn btn-default col-md-2 col-xs-12" data-dismiss="modal">Mégse</button>
            <div class="col-md-1 col-xs-12"></div>
          </div>

          <input type="hidden" name="action" value="equipmentInsert"></input>
          </form>
        </div>
      </div>
    </div>
    ';
  }

  $db = new Database();
  $db->connect();
  $db->select('equipment', '*', null, null, null, null);
  $res = $db->getResult();

  $item = array();

  foreach ($res as $result) {
      array_push($item, new Equipment($result['id'], $result['name'], $result['price'], $result['price_unit'], $result['time'], $result['time_unit'], $result['amount'], $result['description'], $result['owner_id'], $result['owner_name'], $result['venue_id'], $result['venue_name']));
  }

} else {
  $notFound = true;
}
?>
