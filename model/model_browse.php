<?php
require_once 'sql/mysql_crud.php';
require_once 'class/account.php';
require_once 'class/venue.php';
require_once 'class/equipment.php';
require_once 'class/service.php';

$title = "Böngészés";
$itemType = "Helyszín";
$staticItem = false;
$style = '
#reservationsTable {
  overflow-y: scroll;
  overflow-x: hidden;
  height:auto;
  max-height: 130px;
}
';

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
      $db->select('venue', '*', null, null, null, null);
      $res = $db->getResult();

      $item = array();

      foreach ($res as $result) {
          array_push($item, new Venue($result['id'], $result['name'], $result['description'], $result['price'], $result['price_unit'], $result['time'], $result['time_unit'], $result['owner_id'], $result['owner_name']));
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
      $db->select('equipment', '*', null, null, null, null);
      $res = $db->getResult();

      $item = array();

      foreach ($res as $result) {
          array_push($item, new Equipment($result['id'], $result['name'], $result['price'], $result['price_unit'], $result['time'], $result['time_unit'], $result['amount'], $result['description'], $result['owner_id'], $result['owner_name'], $result['venue_id'], $result['venue_name']));
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
      $db->select('service', '*', null, null, null, null);
      $res = $db->getResult();

      $item = array();

      foreach ($res as $result) {
          array_push($item, new Service($result['id'], $result['name'], $result['price'], $result['price_unit'], $result['time'], $result['time_unit'], $result['description'], $result['owner_id'], $result['owner_name'], $result['venue_id'], $result['venue_name']));
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
      $db->select('account', '*, account.id AS account_id', 'user, permission, company_profile', 'permission.permissionName = "service" AND account.user_id = user.id AND account.permission_id = permission.id AND account.company_profile_id = company_profile.id', null, null);
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
    case 'organizer':
      $organizer = "active";

      $db = new Database();
      $db->connect();
      $db->select('account', '*, account.id AS account_id', 'user, permission, company_profile', 'permission.permissionName = "organizer" AND account.user_id = user.id AND account.permission_id = permission.id AND account.company_profile_id = company_profile.id', null, null);
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
    $db->select('venue', '*', null, null, null, null);
    $res = $db->getResult();

    $item = array();

    foreach ($res as $result) {
        array_push($item, new Venue($result['id'], $result['name'], $result['description'], $result['price'], $result['price_unit'], $result['time'], $result['time_unit'], $result['owner_id'], $result['owner_name']));
    }

    function echoItem($i, $item) {
      echo Venue::itemToString($i, $item);
    }

    function echoItemDetails($i, $item) {
      echo Venue::itemDetailsToString($i, $item);
    }
  }
?>
