<?php
  include_once ('../../class/account.php');
  session_name('bejelentkezes');
  session_start();

  include_once '../../sql/mysql_crud.php';


  //Alapértelmezett értékek
  $events = '';
  $userType = "event.customer_id";
  $partnerType = "event.organizer_id";
  $customerDataDisplay = false; //Ha false akkor a partner adatait céges adatként jeleníti meg
  $customerHeader = "";

  switch ($_SESSION['login']->getPermission()->getPermissionName()) {
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

  //Bejelentkezett felhasználó jogosultságának azonosítása
  switch ($_SESSION['login']->getPermission()->getPermissionName()) {
    case 'customer':
      $userType = "event.customer_id";
      $partnerType = "event.organizer_id";
      $customerDataDisplay = false;
      $customerHeader = "Cég";
      break;
    case 'organizer':
      $userType = "event.organizer_id";
      $partnerType = "event.customer_id";
      $customerDataDisplay = true;
      $customerHeader = 'Megrendelő';
      break;
  }

  //Rendezvények lekérdezése az adatbázisból
  $db = new Database();
  $db->connect();
  if ($_SESSION['login']->getPermission()->getPermissionName() != "service") {
    $db->select('event', '*, event.id AS event_id, user.id AS user_id, user.name AS user_name, venue.name AS venue_name, event.status AS event_status', 'venue, account, user', 'event.venue_id = venue.id AND ' . $userType . ' = ' . $_SESSION['login']->getId() . ' AND ' . $partnerType . ' = account.id AND account.user_id = user.id AND event.' . $flag . " = 1", null, null);
  } else {
    $db->select('event', '*, event.id AS event_id, user.id AS user_id, user.name AS user_name, venue.name AS venue_name, event.status AS event_status', 'event_equipment, venue, account, user', 'event.venue_id = venue.id AND event_equipment.company_id = ' . $_SESSION['login']->getId() . ' AND event_equipment.company_id = account.id AND account.user_id = user.id AND event.id = event_equipment.event_id AND event.' . $flag . " = 1", null, null);
  }
  $res = $db->getResult();

  //Ha nincs rendezvény, akkor ezt az üzenetet írja ki
  if (count($res) == 0) {
    $events = '</br><h1>Nincs megjeleníthető rendezvény! :(</h1></br></br>';
  }

  foreach ($res as $result) {
    //Alapértelmezett értékek rendezvényenként
    $equipmentsLocal = ""; //Helyi felszerelések
    $equipmentsExternal = ""; //Külsős rendezvények
    $statusName = "";
    $statusAlert = "";
    $partners = ""; //Rendezvényen résztvevő partnerek adatai
    $content = ""; //Felszerelések, szolgáltatások tartalma
    $buttons = '
    <div class="row">
      <div class="col-md-4">
        <a class="btn btn-primary"
          data-toggle="collapse"
          data-parent="#eventsPanel-' . $result['event_id'] . '"
          href="#event-' . $result['event_id'] . '">Részletek</a>
      </div>
    ';

    //Státusz alapján beállítja az értékeket
    switch ($result['event_status']) {
      case 'pending':
        $statusName = "Függőben lévő";
        $statusAlert = "info";

        if ($customerDataDisplay) {
          $buttons .= '
            <div class="col-md-4">
                <form>
                  <input type="hidden" name="newStatus" value="active">
                  <input type="hidden" name="event_id" value="' . $result['event_id'] . '">
                  <a class="change_status btn btn-primary">Aktiválás</a>
                </form>
              </div>
          ';
        }
        break;
      case 'active':
        $statusName = "Aktív";
        $statusAlert = "success";

        if ($customerDataDisplay)
          $buttons .= '<div class="col-md-4"><button type="submit" class="btn btn-primary disabled">Aktiválás</button></div>';

        break;
      case 'canceled':
        $statusName = "Lemondva";
        $statusAlert = "danger";

        if ($customerDataDisplay)
          $buttons .= '<div class="col-md-4"><a type="submit" class="btn btn-primary disabled">Aktiválás</a></div>';

          $buttons .= '
            <div class="col-md-4">
              <form>
                <input type="hidden" name="newStatus" value="deleted">
                <input type="hidden" name="event_id" value="' . $result['event_id'] . '">
                <a class="change_status btn btn-danger">Törlés</a>
              </form>
            </div>
            ';
        break;
    }

    if ($result['event_status'] != 'canceled') {
      $buttons .= '
        <div class="col-md-4">
          <form>
            <input type="hidden" name="newStatus" value="canceled">
            <input type="hidden" name="event_id" value="' . $result['event_id'] . '">
            <a class="change_status btn btn-danger">Lemondás</a>
          </form>
        </div>
        ';
    }

    //buttonsben a row lezárása
    $buttons .= "</div>";

    if ($_SESSION['login']->getPermission()->getPermissionName() == "service") {
      $content .= '

      <div class="row">
        <div class="col-md-6">
          <div class="panel panel-primary">
            <div class="panel-heading">
              <h3 class="panel-title"><label>Felszerelések</label></h3>
            </div>
            <div class="panel-body">
              <div id="external_equipment_' . $result['event_id'] . '" class="external_equipment_data"></div>
            </div>
          </div>
        </div>

        <div class="col-md-6">
          <div class="panel panel-primary">
            <div class="panel-heading">
              <h3 class="panel-title"><label>Szolgáltatások</label></h3>
            </div>
            <div class="panel-body">
              <div id="external_service_' . $result['event_id'] . '" class="external_service_data"></div>
            </div>
          </div>
        </div>
      </div>
      ';
    } else {
      $content .= '
      <div class="row">
        <div class="col-md-6">
          <div class="panel panel-primary">
            <div class="panel-heading">
              <h3 class="panel-title"><label>Céges felszerelések</label></h3>
            </div>
            <div class="panel-body">
              <div id="local_equipment_' . $result['event_id'] . '" class="local_equipment_data"></div>
            </div>
          </div>
        </div>

        <div class="col-md-6">
          <div class="panel panel-primary">
            <div class="panel-heading">
              <h3 class="panel-title"><label>Külsős felszerelések</label></h3>
            </div>
            <div class="panel-body">
              <div id="external_equipment_' . $result['event_id'] . '" class="external_equipment_data"></div>
            </div>
          </div>
        </div>
      </div>

      </br>

      <div class="row"></div>

      <div class="row">
        <div class="col-md-6">
          <div class="panel panel-primary">
            <div class="panel-heading">
              <h3 class="panel-title"><label>Céges szolgáltatások</label></h3>
            </div>
            <div class="panel-body">
              <div id="local_service_' . $result['event_id'] . '" class="local_service_data"></div>
            </div>
          </div>
        </div>

        <div class="col-md-6">
          <div class="panel panel-primary">
            <div class="panel-heading">
              <h3 class="panel-title"><label>Külsős szolgáltatások</label></h3>
            </div>
            <div class="panel-body">
              <div id="external_service_' . $result['event_id'] . '" class="external_service_data"></div>
            </div>
          </div>
        </div>

      </div>
      ';
    }

    //A rendezvényben résztvevő partnerek adatai
    if ($_SESSION['login']->getPermission()->getPermissionName() != "service") {
      $partners .= '
      <div class="row">
        <div class="col-md-12">
          <div class="panel panel-primary">
            <div class="panel-heading">
              <h4 class="panel-title"><label>Partner adatai</label></h4>
            </div>
            <div class="panel-body"">
              <div class="row">
                <div class="col-md-2"><label>Név: </label></div>
                <div class="col-md-2">' . $result['user_name'] . '</div>
                <div class="col-md-2"><label>Telefonszám: </label></div>
                <div class="col-md-2">' . $result['phoneNumber'] . '</div>
                <div class="col-md-2"><label>Email-cím: </label></div>
                <div class="col-md-2">' . $result['email'] . '</div>
              </div>
            </div>
          </div>
        </div>
      </div>
      ';
    } else {
      $db = new Database();
      $db->connect();

      //Megrendelő adatainak lekérése
      $db->select('account', 'account.user_id, account.id, user.name, user.email, user.phoneNumber', 'user', 'account.user_id = user.id AND account.id = ' . $result['customer_id'], null, null);
      $partnerRes = $db->getResult();

      foreach($partnerRes AS $partnerResult) {
        $partners .= '
        <div class="row">
          <div class="col-md-12">
            <div class="panel panel-primary">
              <div class="panel-heading">
                <h4 class="panel-title"><label>Megrendelő adatai</label></h4>
              </div>
              <div class="panel-body"">
                <div class="row">
                  <div class="col-md-2"><label>Név: </label></div>
                  <div class="col-md-2">' . $partnerResult['name'] . '</div>
                  <div class="col-md-2"><label>Telefonszám: </label></div>
                  <div class="col-md-2">' . $partnerResult['phoneNumber'] . '</div>
                  <div class="col-md-2"><label>Email-cím: </label></div>
                  <div class="col-md-2">' . $partnerResult['email'] . '</div>
                </div>
              </div>
            </div>
          </div>
        </div>

        </br>
        ';
      }

      //Megrendelő adatainak lekérése
      $db->select('account', 'account.user_id, account.id, user.name, user.email, user.phoneNumber', 'user', 'account.user_id = user.id AND account.id = ' . $result['organizer_id'], null, null);
      $partnerRes = $db->getResult();

      foreach($partnerRes AS $partnerResult) {
        $partners .= '
        <div class="row">
          <div class="col-md-12">
            <div class="panel panel-primary">
              <div class="panel-heading">
                <h4 class="panel-title"><label>Rendezvényszervező adatai</label></h4>
              </div>
              <div class="panel-body"">
                <div class="row">
                  <div class="col-md-2"><label>Név: </label></div>
                  <div class="col-md-2">' . $partnerResult['name'] . '</div>
                  <div class="col-md-2"><label>Telefonszám: </label></div>
                  <div class="col-md-2">' . $partnerResult['phoneNumber'] . '</div>
                  <div class="col-md-2"><label>Email-cím: </label></div>
                  <div class="col-md-2">' . $partnerResult['email'] . '</div>
                </div>
              </div>
            </div>
          </div>
        </div>
        ';
      }
    }

    $events .= '
    <div class="panel-group" id="eventsPanel' . $result['event_id'] . '">
      <div class="panel panel-' . $statusAlert . '">
        <div class="panel-heading">

          <div class="row hidden-xs hidden-sm">
            <div class="col-md-2"><label>' . $result['user_name'] . '</label></div>
            <div class="col-md-2"><label>' . $result['venue_name'] . '</label></div>
            <div class="col-md-2"><label>' . $result['time_start'] . '</br>' . $result['time_end'] . '</label></div>
            <div class="col-md-2"><label>' . $statusName . '</label></div>
            <div class="col-md-4">
              ' . $buttons . '
            </div>
          </div>

          <div class="row hidden-md hidden-lg">
            <div class="col-md-2"><label>Név</label></br>' . $result['user_name'] . '</div></br>
            <div class="col-md-2"><label>Helyszín</label></br>' . $result['venue_name'] . '</div></br>
            <div class="col-md-2"><label>Foglalás kezdete\vége</label></br>' . $result['time_start'] . '</br>' . $result['time_end'] . '</div></br>
            <div class="col-md-2"><label>Státusz</label></br>' . $statusName . '</div></br>
            <div class="col-md-4">
              ' . $buttons . '
            </div>
          </div>
        </div>

        <div id="event-' . $result['event_id'] . '" class="panel-collapse collapse">
          <div class="panel-body">
          <input type="hidden" class="get_event_id" value="' . $result['event_id'] . '">
          <input type="hidden" class="get_company_id" value="' . $result['organizer_id'] . '">


            ' . $partners . '

            </br>

            ' . $content . '

          </div>

        </div>
      </div>
    </div>
    ';


  }

  echo $events;

  ?>
