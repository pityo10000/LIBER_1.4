<?php
require_once 'sql/mysql_crud.php';
if (isset($_POST['favoriteId'])) {
  $db = new Database();
  $db->connect();
  $db->delete('favorite', 'id=' . $_POST['favoriteId']);
  $db->disconnect();
}

//header('Location: ');
?>
