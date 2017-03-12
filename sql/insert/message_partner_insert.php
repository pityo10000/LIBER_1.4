<?php
require_once 'sql/mysql_crud.php';

$db = new Database();
$db->connect();
$db->select('messagePartner', '*', null, 'master_id = ' .$_SESSION['login']->getId() . ' && partner_id = ' . $_POST['partnerId'], null, null);
$res = $db->getResult();

if (count($res) == 0) {
  $db = new Database();
  $db->connect();

  $inputData = array(
    "master_id" => $_SESSION['login']->getId(),
    "partner_id" => $_POST['partnerId']
  );

  $db->insert('messagePartner', $inputData);
}

$db = new Database();
$db->connect();
$db->select('messagePartner', '*', null, 'master_id = ' . $_POST['partnerId'] . ' && partner_id = ' . $_SESSION['login']->getId(), null, null);
$res = $db->getResult();

if (count($res) == 0) {
  $inputData = array(
    "master_id" => $_POST['partnerId'],
    "partner_id" => $_SESSION['login']->getId()
  );

  $db->insert('messagePartner', $inputData);
}

$db->disconnect();

header('Location: index.php?nav=messages');
?>
