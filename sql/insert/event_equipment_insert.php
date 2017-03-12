<?php
include_once ('../../class/account.php');
session_name('bejelentkezes');
session_start();
require_once '../mysql_crud.php';

$errorMessage = "";
$error = false;
$organizer_id = "";
$external = false;
$update = false;
$actual_time_start = new DateTime();
$actual_time_end = new DateTime();

//Kiválasztott rendezvény adatainak lekérdezése
$db = new Database();
$db->connect();
$db->select('event', '*', null, 'event.id = ' . $_POST['event_id'], null, null);
$res = $db->getResult();

foreach ($res as $result) {
  $actual_time_start = new DateTime($result['time_start']);
  $actual_time_end = new DateTime($result['time_end']);
  $organizer_id = $result['organizer_id'];
}

//Postolt és az elérhető mennyiség összehasonlítása
$db = new Database();
$db->connect();
$db->select('equipment', '*', null, 'equipment.id = ' . $_POST['equipment_id'], null, null);
$res = $db->getResult();

foreach ($res as $result) {
  if ($result['amount'] < $_POST['amount']) {
    $errorMessage = "Maximum mennyiség: " . $result['amount'] . "!\n";
    $error = true;
  }

  if ($organizer_id != $result['owner_id']) {
    $external = true;
  }
}

//Foglalások ellenőrzése
$db = new Database();
$db->connect();
$db->select('equipment', '*, equipment.amount AS eq_amount, event_equipment.amount AS reserved_amount, event.id AS event_id', 'event_equipment, event', 'event_equipment.event_id = event.id AND event_equipment.equipment_id = equipment.id AND event_equipment.status != "canceled" AND equipment.id = ' . $_POST['equipment_id'], null, null);
$res = $db->getResult();

foreach ($res as $result) {

  $time_start = new DateTime($result['time_start']);
  $time_end = new DateTime($result['time_end']);

  if (($time_start < $actual_time_end && $time_end > $actual_time_start)) {
    $max = ($result['eq_amount'] - $result['reserved_amount']);

    if ($max < $_POST['amount']) {
      $errorMessage = "Ebben az időszakban már levan foglalva a felszerelésből\nMaximum foglalható mennyiség: " . $max;
      $error = true;
    }

  }

  if ($result['event_id'] == $_POST['event_id']) {
    $_POST['amount'] +=  $result['reserved_amount'];
    $update = true;
    break;
  }

}


if (!$error) {

  if ($update) {
    $inputData = array(
      "amount" => $_POST['amount'],
      "status" => 'pending'
    );

    if ($_SESSION['login']->getPermission()->getPermissionName() == "service") {
      $inputData = array(
        "amount" => $_POST['amount'],
        "status" => 'pending',
        "status_service_provider" => 'pending'
      );
    }

    $db = new Database();
    $db->connect();
    $db->update('event_equipment', $inputData, "equipment_id = " . $_POST['equipment_id'] . " AND event_id = " . $_POST['event_id']);
    $db->disconnect();
  } else {
    $inputData = array(
      "equipment_id" => $_POST['equipment_id'],
      "event_id" => $_POST['event_id'],
      "company_id" => $_POST['company_id'],
      "amount" => $_POST['amount']
    );

    if ($external) {
      $inputData = array(
        "equipment_id" => $_POST['equipment_id'],
        "event_id" => $_POST['event_id'],
        "company_id" => $_POST['company_id'],
        "amount" => $_POST['amount'],
        "status_service_provider" => 'pending'
      );
    }

    $db = new Database();
    $db->connect();
    $db->insert('event_equipment', $inputData);
    $db->disconnect();
  }
}

echo $errorMessage;

?>
