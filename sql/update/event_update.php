<?php
include_once ('../../class/account.php');
session_name('bejelentkezes');
session_start();
require_once '../mysql_crud.php';

$serviceProviderStatement = "";
$inputData = array();

if ($_POST['newStatus'] != "deleted") {

  if ($_SESSION['login']->getPermission()->getPermissionName() == "service") {
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
$db->update('event', $inputData, "event.id = " . $_POST['event_id']);
$db->disconnect();


if ($_POST['newStatus'] == "canceled" || $_POST['newStatus'] == "deleted") {
  //Lemondás

  //Ha szolgáltató mondja le, akkor az Ő felszerelése és szolgáltatása lelesz mondva
  //Egyébként minden felszerelés és szolgáltatás lemondásra kerül ami az eseményhez tartozik
	if ($_SESSION['login']->getPermission()->getPermissionName() == "service") {
		$serviceProviderStatement = ' AND company_id = ' . $_SESSION['login']->getId();
	}

  if ($_POST['newStatus'] != "deleted") {
    $inputData = array(
      "status" => $_POST['newStatus']
    );
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
	$db->update('event_equipment', $inputData, "event_id = " . $_POST['event_id'] . $serviceProviderStatement);
	$db->disconnect();

	$db = new Database();
	$db->connect();
	$db->update('event_service', $inputData, "event_id = " . $_POST['event_id'] . $serviceProviderStatement);
	$db->disconnect();

}
?>
