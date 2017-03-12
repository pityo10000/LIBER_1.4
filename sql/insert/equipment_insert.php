<?php
require_once 'sql/mysql_crud.php';

$venueName = "Nem helyhez kötött";

$db = new Database();
$db->connect();
$db->select('venue', 'id, name', null, 'id=' . $_POST['venueId'], null, null);
$res = $db->getResult();

foreach ($res as $result) {
  $venueName = $result['name'];
}


$inputData = array(
  "name" => $_POST['equipmentName'],
  "price" => $_POST['equipmentPrice'],
  "price_unit" => $_POST['equipmentPriceUnit'],
  "time" => $_POST['equipmentTime'],
  "time_unit" => $_POST['equipmentTimeUnit'],
  "amount" => $_POST['equipmentAmount'],
  "description" => $_POST['equipmentDescription'],
  "owner_id" => $_SESSION['login']->getId(),
  "owner_name" => $_SESSION['login']->getUser()->getName(),
  "venue_id" => $_POST['venueId'],
  "venue_name" => $venueName
);

$db = new Database();
$db->connect();
$db->insert('equipment', $inputData);
$db->disconnect();

$_SESSION['alertType'] = "success";
$_SESSION['alertText'] = "Sikeres Hozzáadás!";

header('Location: index.php?nav=equipments');
?>
