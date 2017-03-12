<?php
if (isset($_SESSION['login']) && $_SESSION['login']->getPermission()->getEvents() == 1) {
  include_once 'sql/mysql_crud.php';

  $title = "Rendezvényeim";
  $style = "
    .local_equipment_data, .local_service_data, .external_equipment_data, .external_service_data {
      min-height: 250px;
    }

    .loc-eq-page, .ext-eq-page, .loc-ser-page, .ext-ser-page {
      cursor: pointer;
    }
  ";
} else {
  $notFound = true;
}


?>
