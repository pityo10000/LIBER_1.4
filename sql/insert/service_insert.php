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
  "name" => $_POST['serviceName'],
  "price" => $_POST['servicePrice'],
  "price_unit" => $_POST['servicePriceUnit'],
  "time" => $_POST['serviceTime'],
  "time_unit" => $_POST['serviceTimeUnit'],
  "description" => $_POST['serviceDescription'],
  "owner_id" => $_SESSION['login']->getId(),
  "owner_name" => $_SESSION['login']->getUser()->getName(),
  "venue_id" => $_POST['venueId'],
  "venue_name" => $venueName
);

$db = new Database();
$db->connect();
$db->insert('service', $inputData);
$db->disconnect();

$_SESSION['alertType'] = "success";
$_SESSION['alertText'] = "Sikeres Hozzáadás!";

header('Location: index.php?nav=services');
?>
