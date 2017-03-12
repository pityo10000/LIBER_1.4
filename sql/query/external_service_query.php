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
  $serviceProviderStatement = " AND service.owner_id = " . $_SESSION['login']->getId();

//Szolgáltatások mennyiségének lekérdezése\meghatározása
$db = new Database();
$db->connect();
$db->select('event_service', '*', 'service', 'event_service.service_id = service.id AND event_service.event_id = ' . $_POST['event_id'] . ' AND event_service.company_id != ' . $_POST['company_id'] . ' AND ' . $flag . ' = 1' . $serviceProviderStatement, null, null);
$serRes = $db->getResult();

$resultLength = count($serRes);
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

  $pageButtons .='<li id="' . $_POST['event_id'] . '" class="ext-ser-page' . $active . '"><a class="page-link">' . ($i + 1) . '</a></li>';
}

//pagination gombok
echo '
<nav aria-label="Page navigation example">
  <ul class="pagination">
    ' . $pageButtons . '
  </ul>
</nav>
';

//Szolgáltatások lekérdezése
$db = new Database();
$db->connect();
$db->select('event_service', '*, event_service.id as event_service_id', 'service', 'event_service.service_id = service.id AND event_service.event_id = ' . $_POST['event_id'] . ' AND event_service.company_id != ' . $_POST['company_id'] . ' AND ' . $flag . ' = 1' . $serviceProviderStatement, null, $page . ', 3');

$serRes = $db->getResult();
$servicesExternal = '<ul id="servicesExternal" class="list-group">';

foreach ($serRes as $serResult) {
  $serButtons = "";
  $serStatusName = "";
  $serStatusAlert = "";


  switch ($serResult['status']) {
    case 'pending':
      $serStatusName = "Függőben lévő";
      $serStatusAlert = "info";
      if ($serResult['status_service_provider'] == "active") {
        if ($permission == "service") {
          $serStatusName = "Aktíválva, Rendezvényszervező válaszára várunk!";
          $serStatusAlert = "info";
        } else if ($permission == "organizer") {
          $serStatusName = "Szolgáltató által aktiválva, az Ön válaszára várunk!";
          $serStatusAlert = "info";
        } else {
          $serStatusName = "Szolgáltató által aktiválva, a rendezvényszervező válaszára várunk!";
          $serStatusAlert = "info";
        }
      }
      break;
    case 'active':
      $serStatusName = "Aktív";
      $serStatusAlert = "success";
      if ($serResult['status_service_provider'] == "pending") {
        if ($permission == "service") {
          $serStatusName = "Rendezvényszervező által aktiválva, az Ön válaszára várunk!";
          $serStatusAlert = "info";
        } else if ($permission == "organizer") {
          $serStatusName = "Aktíválva, szolgáltató válaszára várunk!";
          $serStatusAlert = "info";
        } else {
          $serStatusName = "Rendezvényszervező által aktiválva, az szolgáltató válaszára várunk!";
          $serStatusAlert = "info";
        }
      }
      break;
    case 'canceled':
      $serStatusName = "Lemondva";
      $serStatusAlert = "danger";
      break;
  }

  //Szolgáltatások gombjai
  $serButtons .= '
    <button type="button" class="dropdown-toggle btn btn-primary" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Lehetőségek<span class="caret"></span></button>
    <div style="text-align: center;" class="dropdown-menu">
  ';

  if ($serResult['status'] != 'canceled') {
    $serButtons .= '
      <div>
        <form>
          <input type="hidden" name="action" value="event_service_update">
          <input type="hidden" name="newStatus" value="canceled">
          <input type="hidden" name="event_id" value="' . $serResult['event_id'] . '">
          <input type="hidden" name="item_id" value="' . $serResult['event_service_id'] . '">
          <a class="item_update btn btn-danger"">Lemondás</a>
        </form>
      </div>
      </br>
    ';
  } else {
    $serButtons .= '
      <div>
        <form>
          <input type="hidden" name="action" value="event_service_update">
          <input type="hidden" name="newStatus" value="deleted">
          <input type="hidden" name="event_id" value="' . $serResult['event_id'] . '">
          <input type="hidden" name="item_id" value="' . $serResult['event_service_id'] . '">
          <a class="item_update btn btn-danger"">Törlés</a>
        </form>
      </div>
      </br>
    ';
  }
  if ((($permission == "service" && $serResult['status_service_provider'] == 'pending') || ($permission == "organizer" && $serResult['status'] == 'pending'))) {
    $serButtons .= '
      <div>
        <input type="hidden" name="action" value="event_service_update">
        <input type="hidden" name="newStatus" value="active">
        <input type="hidden" name="event_id" value="' . $serResult['event_id'] . '">
        <input type="hidden" name="item_id" value="' . $serResult['event_service_id'] . '">
        <a class="item_update btn btn-primary">Aktiválás</a>
      </div>
    ';
  }

  $serButtons .= '
    </div>
  ';

  //Szolgáltatások kiíratása
  $servicesExternal .= '
  <li class="list-group-item list-group-item-' . $serStatusAlert . '">
    <div class="row">
      <div class="col-md-4">' . $serResult['name'] . '</div>
      <div class="col-md-3">' . $serResult['price'] . ' Ft</div>
      <div class="col-md-2">' . $serStatusName . '</div>
      <div class="col-md-3">' . $serButtons . '</div>
    </div>
  </li>
  ';
}

$servicesExternal .= '</ul>';

echo $servicesExternal;
?>
