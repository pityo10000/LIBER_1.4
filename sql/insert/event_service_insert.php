<?php
include_once ('../../class/account.php');
session_name('bejelentkezes');
session_start();
require_once '../mysql_crud.php';

$errorMessage = "";
$error = false;
$organizer_id = "";
$external = false;

//Kiválasztott rendezvény szervezőjének lekérdezése
$db = new Database();
$db->connect();
$db->select('event', '*', null, 'event.id = ' . $_POST['event_id'], null, null);
$res = $db->getResult();

foreach ($res as $result) {
  $organizer_id = $result['organizer_id'];
}

//Postolt és az elérhető mennyiség összehasonlítása
$db = new Database();
$db->connect();
$db->select('service', '*', null, 'service.id = ' . $_POST['service_id'], null, null);
$res = $db->getResult();

foreach ($res as $result) {
  if ($organizer_id != $result['owner_id']) {
    $external = true;
  }
}

//Foglalások ellenőrzése
$db = new Database();
$db->connect();
$db->select('service', '*, event.id AS event_id, service.owner_id as service_owner_id', 'event_service, event', 'event_service.event_id = event.id AND event_service.service_id = service.id AND event_service.status != "canceled" AND service.id = ' . $_POST['service_id'], null, null);
$res = $db->getResult();

foreach ($res as $result) {
  if ($result['event_id'] == $_POST['event_id']) {
    $errorMessage = "Erre a rendezvényre, már levan foglalva ez a szolgáltatás";
    $error = true;
    break;
  }
}


if (!$error) {
  $inputData = array(
    "service_id" => $_POST['service_id'],
    "event_id" => $_POST['event_id'],
    "company_id" => $_POST['company_id']
  );

  if ($external) {
    $inputData = array(
      "service_id" => $_POST['service_id'],
      "event_id" => $_POST['event_id'],
      "company_id" => $_POST['company_id'],
      "status_service_provider" => 'pending'
    );
  }

  $db = new Database();
  $db->connect();
  $db->insert('event_service', $inputData);
  $db->disconnect();
}

echo $errorMessage;

?>
