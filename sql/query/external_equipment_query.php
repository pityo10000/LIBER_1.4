<?php
require('../../class/account.php');
session_name('bejelentkezes');
session_start();

include_once '../../sql/mysql_crud.php';

$permission = $_SESSION['login']->getPermission()->getPermissionName();

$flag = "";
$serviceProviderStatement = "";

switch ($permission) {
  case 'customer':
    $flag = "flag_customer";
    break;
  case 'service':
    $flag = "flag_service_provider";
    break;
  case 'organizer':
    $flag = "flag_company";
    break;
}

if ($permission == 'service')
  $serviceProviderStatement = " AND equipment.owner_id = " . $_SESSION['login']->getId();

//Felszerelések mennyiségének lekérdezése\meghatározása
$db = new Database();
$db->connect();
$db->select('event_equipment', '*, event_equipment.amount AS ev_amount', 'equipment', 'event_equipment.equipment_id = equipment.id AND event_equipment.event_id = ' . $_POST['event_id'] . ' AND event_equipment.company_id != ' . $_POST['company_id'] . ' AND ' . $flag . ' = 1' . $serviceProviderStatement, null, null);
$eqRes = $db->getResult();

$resultLength = count($eqRes);
$pagesLength = ceil($resultLength / 3);

if ($pagesLength == 0) {
  echo "<label>Nincs megjeleníthető adat!</label>";
  exit;
}
$page = 0;
if (isset($_POST['page'])) {
  $page = ($_POST['page'] - 1) * 3;
} else {
  $_POST['page'] = 1;
}

$pageButtons = '';

for ($i = 0; $i < $pagesLength; $i++) {
  $active = "";

  if ($i == $_POST['page'] - 1)
    $active .= " active";

  $pageButtons .='<li id="' . $_POST['event_id'] . '" class="ext-eq-page' . $active . '"><a class="page-link">' . ($i + 1) . '</a></li>';
}

//pagination gombok
echo '
<nav aria-label="Page navigation example">
  <ul class="pagination">
    ' . $pageButtons . '
  </ul>
</nav>
';

//Felszerelések lekérdezése
$db = new Database();
$db->connect();
$db->select('event_equipment', '*,event_equipment.id as event_equipment_id, event_equipment.amount AS ev_amount', 'equipment', 'event_equipment.equipment_id = equipment.id AND event_equipment.event_id = ' . $_POST['event_id'] . ' AND event_equipment.company_id != ' . $_POST['company_id'] . ' AND ' . $flag . ' = 1' . $serviceProviderStatement, null, $page . ', 3');
$eqRes = $db->getResult();
$equipmentsLocal = '<ul id="equipmentsLocal" class="list-group">';

foreach ($eqRes as $eqResult) {
  $eqButtons = "";
  $eqStatusName = "";
  $eqStatusAlert = "";


  switch ($eqResult['status']) {
    case 'pending':
      $eqStatusName = "Függőben lévő";
      $eqStatusAlert = "info";
      if ($eqResult['status_service_provider'] == "active") {
        if ($permission == "service") {
          $eqStatusName = "Aktíválva, Rendezvényszervező válaszára várunk!";
          $eqStatusAlert = "info";
        } else if ($permission == "organizer") {
          $eqStatusName = "Szolgáltató által aktiválva, az Ön válaszára várunk!";
          $eqStatusAlert = "info";
        } else {
          $eqStatusName = "Szolgáltató által aktiválva, a rendezvényszervező válaszára várunk!";
          $eqStatusAlert = "info";
        }
      }
      break;
    case 'active':
      $eqStatusName = "Aktív";
      $eqStatusAlert = "success";
      if ($eqResult['status_service_provider'] == "pending") {
        if ($permission == "service") {
          $eqStatusName = "Rendezvényszervező által aktiválva, az Ön válaszára várunk!";
          $eqStatusAlert = "info";
        } else if ($permission == "organizer") {
          $eqStatusName = "Aktíválva, szolgáltató válaszára várunk!";
          $eqStatusAlert = "info";
        } else {
          $eqStatusName = "Rendezvényszervező által aktiválva, az szolgáltató válaszára várunk!";
          $eqStatusAlert = "info";
        }
      }
      break;
    case 'canceled':
      $eqStatusName = "Lemondva";
      $eqStatusAlert = "danger";
      break;
  }



  //Felszerelés gombjai
  $eqButtons .= '
    <button type="button" class="dropdown-toggle btn btn-primary" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Lehetőségek<span class="caret"></span></button>
    <div style="text-align: center;" class="dropdown-menu">
  ';

  if ($eqResult['status'] != 'canceled') {
    $eqButtons .= '
      <div>
        <form>
          <input type="hidden" name="action" value="event_equipment_update">
          <input type="hidden" name="newStatus" value="canceled">
          <input type="hidden" name="event_id" value="' . $eqResult['event_id'] . '">
          <input type="hidden" name="item_id" value="' . $eqResult['event_equipment_id'] . '">
          <a class="item_update btn btn-danger"">Lemondás</a>
        </form>
      </div>
      </br>
    ';
  } else {
    $eqButtons .= '
      <div>
        <form>
          <input type="hidden" name="action" value="event_equipment_update">
          <input type="hidden" name="newStatus" value="deleted">
          <input type="hidden" name="event_id" value="' . $eqResult['event_id'] . '">
          <input type="hidden" name="item_id" value="' . $eqResult['event_equipment_id'] . '">
          <a class="item_update btn btn-danger">Törlés</a>
        </form>
      </div>
      </br>
    ';
  }

  if ((($permission == "service" && $eqResult['status_service_provider'] == 'pending') || ($permission == "organizer" && $eqResult['status'] == 'pending'))) {
    $eqButtons .= '
      <div>
        <input type="hidden" name="action" value="event_equipment_update">
        <input type="hidden" name="newStatus" value="active">
        <input type="hidden" name="event_id" value="' . $eqResult['event_id'] . '">
        <input type="hidden" name="item_id" value="' . $eqResult['event_equipment_id'] . '">
        <a class="item_update btn btn-primary">Aktiválás</a>
      </div>
    ';
  }

  $eqButtons .= '
    </div>
  ';

  //Felszerelés kiíratása
  $equipmentsLocal .= '
  <li class="list-group-item list-group-item-' . $eqStatusAlert . '">
    <div class="row">
      <div class="col-md-2">' . $eqResult['name'] . '</div>
      <div class="col-md-2">' . $eqResult['ev_amount'] . ' db</div>
      <div class="col-md-3">' . $eqResult['ev_amount'] . ' * ' . $eqResult['price'] . ' = ' . ($eqResult['ev_amount'] *  $eqResult['price']) . ' Ft</div>
      <div class="col-md-2">' . $eqStatusName . '</div>
      <div class="col-md-3">' . $eqButtons . '</div>
    </div>
  </li>
  ';
}

$equipmentsLocal .= '</ul>';

echo $equipmentsLocal;
?>
