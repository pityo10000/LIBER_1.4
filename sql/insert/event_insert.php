<?php
include_once ('../../class/account.php');
session_name('bejelentkezes');
session_start();
require_once 'sql/mysql_crud.php';

$inputData = array(
  "time_start" => $_POST['time_start'],
  "time_end" => $_POST['time_end'],
  "organizer_id" => $_POST['organizer_id'],
  "customer_id" => $_SESSION['login']->getId(),
  "venue_id" => $_POST['venue_id'],
  "status" => 'pending'
);

$db = new Database();
$db->connect();
$db->insert('event', $inputData);
$db->disconnect();

header('Location: index.php?nav=events');
?>
