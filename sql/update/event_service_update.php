<?php
include_once ('../../class/account.php');
session_name('bejelentkezes');
session_start();
require_once '../mysql_crud.php';
$inputData = array();

if ($_POST['newStatus'] != 'deleted') {
  if ($_POST['newStatus'] == "active" && $_SESSION['login']->getPermission()->getPermissionName() == "service") {
    $inputData = array(
      "status_service_provider" => $_POST['newStatus']
    );
  } else {
    $inputData = array(
      "status" => $_POST['newStatus']
    );
  }
} else {

  switch ($_SESSION['login']->getPermission()->getPermissionName()) {
    case 'customer':
      $inputData = array(
        "flag_customer" => 0
      );
      break;
    case 'organizer':
      $inputData = array(
        "flag_company" => 0
      );
      break;
    case 'service':
      $inputData = array(
        "flag_service_provider" => 0
      );
      break;
  }
}

$db = new Database();
$db->connect();
$db->update('event_service', $inputData, "id = " . $_POST['item_id'] . " AND event_id = " . $_POST['event_id']);
$db->disconnect();
?>
