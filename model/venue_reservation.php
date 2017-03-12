<?php
$reservations = '';
  $db = new Database();
  $db->connect();
  $db->select('event', '*', null, 'venue_id = ' . $item[$i]->getId() . ' AND status = "active"', null, null);
  $res = $db->getResult();

  foreach ($res as $result) {
    $reservations .= '
      <tr>
        <td class="agenda-time">
          ' . $result['time_start'] . '
        </td>
        <td class="agenda-events">
          ' . $result['time_end'] . '
        </td>
      </tr>
    ';
  }


  $reservationForm .= '
  <h3><label>Eddigi foglalások</label></h3>
  <div class="row">
    <div class="col-md-1 col-xs-12"></div>
    <div class="col-md-10 col-xs-12">
      <div id="reservationsTable">
        <table class="table table-condensed table-bordered">
          <thead>
            <tr>
              <th>Foglalás kezdete</th>
              <th>Foglalás vége</th>
            </tr>
          </thead>
            <tbody>
            ' . $reservations . '
            </tbody>
        </table>
      </div>
    </div>
    <div class="col-md-1 col-xs-12"></div>
  </div>
  <br>
';


if ($_SESSION['login']->getPermission()->getPermissionName() == 'customer') {
  $reservationForm .= '
  <h3><label>Foglalás</label></h3>

  </br>
  <form method="POST">
    <label>Válassza ki a foglalás kezdetét!</label>
    </br>
    <div class="row">
      <div class="col-md-1 col-xs-12"></div>
      <div class="col-md-10 col-xs-12"><input name="time_start" type="datetime-local" class="form-control"></input></div>
      <div class="col-md-1 col-xs-12"></div>
    </div>
    </br>
    <label>Válassza ki a foglalás végét!</label>
    </br>
    <div class="row">
      <div class="col-md-1 col-xs-12"></div>
      <div class="col-md-10 col-xs-12"><input name="time_end" type="datetime-local" class="form-control"></input></div>
      <div class="col-md-1 col-xs-12"></div>
    </div>
    </br>
    </br>
    <input type="hidden" id="action" name="action" value="eventInsert"/>
    <input type="hidden" id="organizer_id" name="organizer_id" value="' . $item[$i]->getOwnerId() . '"/>
    <input type="hidden" id="venue_id" name="venue_id" value="' . $item[$i]->getId() . '"/>
    <div class="row">
      <div class="col-md-3 col-xs-12"></div>
      <div class="col-md-6 col-xs-12"><input type="submit" class="form-control btn btn-primary" value="Foglalás"/></div>
      <div class="col-md-3 col-xs-12"></div>
    </div>
  </form>
  ';
}

/*$db = new Database();
$db->connect();
$db->select('favorite', '*', null, where, null, null);
$res = $db->getResult();*/

?>
