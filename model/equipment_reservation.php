<?php

$reservations = '';

$db = new Database();
$db->connect();
$db->select('event_equipment', '*', 'event', 'event_equipment.equipment_id = ' . $item[$i]->getId() . ' AND event_equipment.status != "canceled" AND event_equipment.event_id = event.id AND event.status != "canceled"', null, null);
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
      <td class="agenda-events">
        ' . $result['amount'] . '
      </td>
    </tr>
  ';
}

if (count($res) == 0) {
  $reservations = '<tr><td style="text-align: center;" colspan="3"><label>Nincs lefoglalt időpont!</label></td></tr>';
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
            <th>Mennyiség</th>
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

if ($_SESSION['login']->getPermission()->getPermissionName() == "customer") {
  $reservationForm .= '

    <h3><label>Foglalás</label></h3>

    </br>
    <form method="POST">
      <label>Válassza ki a rendezvényt!</label>
      </br>
      ';



    $db = new Database();
    $db->connect();
    $db->select('event', '*, event.id AS event_id', 'venue', 'customer_id = ' . $_SESSION['login']->getId() . ' AND status != "canceled" AND event.venue_id = venue.id', null, null);
    $res = $db->getResult();

    if (count($res) != 0) {
      $events = '
      <select class="form-control" name="event_id">
      ';

      foreach ($res as $result) {
        $events .= '
          <option value="' . $result['event_id'] . '">' . $result['name'] . ' (' . $result['time_start'] . ' - ' . $result['time_end'] . ')</option>
        ';
      }

      $events .= '
      </select>
      ';

      $reservationForm .= '
      <div class="row">
        <div class="col-md-1 col-xs-12"></div>
        <div class="col-md-10 col-xs-12">' . $events . '</div>
        <div class="col-md-1 col-xs-12"></div>
      </div>
      </br>
      <label>Hány darabot szeretne lefoglalni?</label>
      </br>
      <div class="row">
        <div class="col-md-1 col-xs-12"></div>
        <div class="col-md-10 col-xs-12"><input name="amount" type="text" class="form-control"></input></div>
        <div class="col-md-1 col-xs-12"></div>
      </div>
      </br>
      <p style="color: red;" class="error_message"></p>
      </br>
      <input type="hidden" id="action" name="action" value="event_equipment_insert"/>
      <input type="hidden" id="company_id" name="company_id" value="' . $item[$i]->getOwnerId() . '"/>
      <input type="hidden" id="equipment_id" name="item_id" value="' . $item[$i]->getId() . '"/>
      <div class="row">
        <div class="col-md-3 col-xs-12"></div>
        <div class="col-md-6 col-xs-12"><a id="reservation" class="form-control btn btn-primary">Foglalás</a></div>
        <div class="col-md-3 col-xs-12"></div>
      </div>
    ';
  } else {
    $reservationForm .= '<label style="color: red">Nem található rendezvény</label>';
  }

  $reservationForm .= '</form>';
}

?>
