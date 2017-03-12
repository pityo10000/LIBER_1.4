<?php
include_once ('../../class/account.php');
session_name('bejelentkezes');
session_start();
require_once '../mysql_crud.php';

$db = new Database();
$db->connect();

$inputData = array(
  "content" => $_POST['message_content'],
  "sender_id" => $_SESSION['login']->getId(),
  "receiver_id" => $_POST['partner_id']
);

$db->insert('message', $inputData);
$db->disconnect();
?>
