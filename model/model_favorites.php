<?php
if (isset($_SESSION['login']) && $_SESSION['login']->getPermission()->getFavorites() == 1) {
  require_once 'sql/mysql_crud.php';
  require_once 'class/account.php';
  require_once 'class/venue.php';
  require_once 'class/equipment.php';
  require_once 'class/service.php';

  $title = "Kedvenceim";
  $staticItem = false;

  $venue = "";
  $organizer = "";
  $serviceProvider = "";
  $equipment = "";
  $service = "";


  if (isset($_POST['itemType'])) {
    switch ($_POST['itemType']) {
      case 'venue':
        $venue = "active";

        $db = new Database();
        $db->connect();
        $db->select('venue', '*, venue.id AS venue_id', 'favorite', 'account_id=' . $_SESSION['login']->getId() . ' AND item_type="venue" AND favorite.item_id=venue.id', null, null);
        $res = $db->getResult();

        $item = array();

        foreach ($res as $result) {
            array_push($item, new Venue($result['venue_id'], $result['name'], $result['description'], $result['price'], $result['price_unit'], $result['time'], $result['time_unit'], $result['owner_id'], $result['owner_name']));
        }

        function echoItem($i, $item) {
          echo Venue::itemToString($i, $item);
        }

        function echoItemDetails($i, $item) {
          echo Venue::itemDetailsToString($i, $item);
        }

        break;
      case 'equipment':
        $equipment = "active";

        $db = new Database();
        $db->connect();
        $db->select('equipment', '*, equipment.id AS equipment_id', 'favorite', 'account_id=' . $_SESSION['login']->getId() . ' AND item_type="equipment" AND favorite.item_id=equipment.id', null, null);
        $res = $db->getResult();

        $item = array();

        foreach ($res as $result) {
            array_push($item, new Equipment($result['equipment_id'], $result['name'], $result['price'], $result['price_unit'], $result['time'], $result['time_unit'], $result['amount'], $result['description'], $result['owner_id'], $result['owner_name'], $result['venue_id'], $result['venue_name']));
        }

        function echoItem($i, $item) {
          echo Equipment::itemToString($i, $item);
        }

        function echoItemDetails($i, $item) {
          echo Equipment::itemDetailsToString($i, $item);
        }

        break;
      case 'service':
        $service = "active";

        $db = new Database();
        $db->connect();
        $db->select('service', '*, service.id AS service_id', 'favorite', 'account_id=' . $_SESSION['login']->getId() . ' AND item_type="service" AND favorite.item_id=service.id', null, null);
        $res = $db->getResult();

        $item = array();

        foreach ($res as $result) {
            array_push($item, new Service($result['service_id'], $result['name'], $result['price'], $result['price_unit'], $result['time'], $result['time_unit'], $result['description'], $result['owner_id'], $result['owner_name'], $result['venue_id'], $result['venue_name']));
        }

        function echoItem($i, $item) {
          echo Service::itemToString($i, $item);
        }

        function echoItemDetails($i, $item) {
          echo Service::itemDetailsToString($i, $item);
        }

        break;
      case 'serviceProvider':
        $serviceProvider = "active";

        $db = new Database();
        $db->connect();
        $db->select('account', '*, company_profile.id AS cp_id', 'user, permission, company_profile, favorite', 'permission.permissionName = "service" AND account.user_id = user.id AND account.permission_id = permission.id AND account.company_profile_id = company_profile.id AND account_id=' . $_SESSION['login']->getId() . ' AND item_type="serviceProvider" AND favorite.item_id=account.id', null, null);
        $res = $db->getResult();

        $item = array();

        foreach ($res as $result) {
          $user = new User($result['name'], $result['email'], $result['phoneNumber']);
          $permission = new Permission(
            $result['permissionName'],
            $result['venues'],
            $result['services'],
            $result['equipments'],
            $result['messages'],
            $result['settings'],
            $result['browse'],
            $result['favorites'],
            $result['events'],
            $result['block'],
            $result['userManage'],
            $result['confirm']
          );
          $companyProfile = new CompanyProfile(
            $result['contactName'],
            $result['taxNumber'],
            $result['description'],
            $result['addressZipCode'],
            $result['addressCountry'],
            $result['addressCity'],
            $result['addressStreet'],
            $result['logo']
          );

          array_push($item, new Account($result['cp_id'], $user, $permission, $companyProfile));

        }

        function echoItem($i, $item) {
          echo Account::itemToString($i, $item);
        }

        function echoItemDetails($i, $item) {
          echo Account::itemDetailsToString($i, $item);
        }
        break;
      case 'organizer':
        $organizer = "active";

        $db = new Database();
        $db->connect();
        $db->select('account', '*, account.id AS account_id', 'user, permission, company_profile, favorite', 'permission.permissionName = "organizer" AND account.user_id = user.id AND account.permission_id = permission.id AND account.company_profile_id = company_profile.id AND account_id=' . $_SESSION['login']->getId() . ' AND item_type="organizer" AND favorite.item_id=account.id', null, null);
        $res = $db->getResult();

        $item = array();

        foreach ($res as $result) {
          $user = new User($result['name'], $result['email'], $result['phoneNumber']);
          $permission = new Permission(
            $result['permissionName'],
            $result['venues'],
            $result['services'],
            $result['equipments'],
            $result['messages'],
            $result['settings'],
            $result['browse'],
            $result['favorites'],
            $result['events'],
            $result['block'],
            $result['userManage'],
            $result['confirm']
          );
          $companyProfile = new CompanyProfile(
            $result['contactName'],
            $result['taxNumber'],
            $result['description'],
            $result['addressZipCode'],
            $result['addressCountry'],
            $result['addressCity'],
            $result['addressStreet'],
            $result['logo']
          );

          array_push($item, new Account($result['account_id'], $user, $permission, $companyProfile));
        }

        function echoItem($i, $item) {
          echo Account::itemToString($i, $item);
        }

        function echoItemDetails($i, $item) {
          echo Account::itemDetailsToString($i, $item);
        }
        break;
      }
    } else {
      $venue = "active";

      $db = new Database();
      $db->connect();
      $db->select('venue', '*, venue.id AS venue_id', 'favorite', 'account_id=' . $_SESSION['login']->getId() . ' AND item_type="venue" AND favorite.item_id=venue.id', null, null);
      $res = $db->getResult();

      $item = array();

      foreach ($res as $result) {
          array_push($item, new Venue($result['venue_id'], $result['name'], $result['description'], $result['price'], $result['price_unit'], $result['time'], $result['time_unit'], $result['owner_id'], $result['owner_name']));
      }

      function echoItem($i, $item) {
        echo Venue::itemToString($i, $item);
      }

      function echoItemDetails($i, $item) {
        echo Venue::itemDetailsToString($i, $item);
      }
    }
} else {
  $notFound = true;
}
?>
