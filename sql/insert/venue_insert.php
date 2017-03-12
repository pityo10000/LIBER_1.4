<?php
require_once 'sql/mysql_crud.php';

$inputData = array(
  "name" => $_POST['venueName'],
  "price" => $_POST['venuePrice'],
  "price_unit" => $_POST['venuePriceUnit'],
  "time" => $_POST['venueTime'],
  "time_unit" => $_POST['venueTimeUnit'],
  "description" => $_POST['venueDescription'],
  "owner_id" => $_SESSION['login']->getId(),
  "owner_name" => $_SESSION['login']->getUser()->getName()
);

$db = new Database();
$db->connect();
$db->insert('venue', $inputData);
$db->disconnect();

$_SESSION['alertType'] = "success";
$_SESSION['alertText'] = "Sikeres Hozzáadás!";

header('Location: index.php?nav=venues');
?>
