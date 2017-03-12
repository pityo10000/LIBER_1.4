<?php
require_once 'sql/mysql_crud.php';


$inputData = array(
  "account_id" => $_SESSION['login']->getId(),
  "item_id" => $_POST['itemId'],
  "item_type" => $_POST['itemType']
);

$db = new Database();
$db->connect();
$db->insert('favorite', $inputData);
$db->disconnect();

//header('Location: ');
?>
