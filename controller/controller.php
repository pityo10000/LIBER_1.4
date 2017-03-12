<?php
if (isset($_POST['action'])) {
  switch ($_POST['action']) {
    case "loginSubmit":
      include 'sql/query/account_query.php';
      break;
    case "registrationSubmit":
      include 'sql/insert/account_insert.php';
      break;
    case "updateSubmit":
      include 'sql/update/account_update.php';
      break;
    case "venueInsert":
      include 'sql/insert/venue_insert.php';
      break;
    case "serviceInsert":
      include 'sql/insert/service_insert.php';
      break;
    case "equipmentInsert":
      include 'sql/insert/equipment_insert.php';
      break;
    case "favoriteInsert":
      include 'sql/insert/favorite_insert.php';
      break;
    case "favoriteDelete":
      include 'sql/delete/favorite_delete.php';
      break;
    case "messagePartnerInsert":
      include 'sql/insert/message_partner_insert.php';
      break;
    case "messageInsert":
      include 'sql/insert/message_insert.php';
      break;
    case "eventInsert":
      include 'sql/insert/event_insert.php';
      break;
    case "eventUpdate":
      include 'sql/update/event_update.php';
      break;
    case "eventEquipmentInsert":
      include 'sql/insert/event_equipment_insert.php';
      break;
    case "eventServiceInsert":
      include 'sql/insert/event_service_insert.php';
      break;
  }
}

if (isset($_SESSION['login'])) {
  echo "Bejelentkezve: " . $_SESSION['login']->getUser()->getName() . " , " . $_SESSION['login']->getId();
} else {
  echo "Kijelentkezve";
}

//TODO Linkek változókba tétele
$deps=simplexml_load_file("http://localhost/LIBER_1.4/controller/controller_support.xml") or die("Error: Can't load controller_support.xml file!");

if(isset($_GET["nav"])){

  $notFound = true;
  for ($i = 0; $i < count($deps); $i++) {
    if ($_GET["nav"] == $deps->dep[$i]->url) {
      $notFound = false;
      include 'model/' . $deps->dep[$i]->model;
      if (!$notFound) {
        include 'view/view_header.php';
        include 'view/' . $deps->dep[$i]->view;
        include 'view/view_footer.php';
      }
      break;
    }
  }
  if ($notFound) {
    include 'model/model_mainPage.php';
    include 'view/view_header.php';
    include 'view/view_mainPage.php';
    include 'view/view_footer.php';
  }
} else {
  if (isset($_GET["action"]) && ($_GET['action'] == "logout")) {
  	session_destroy();
  	header("Location: index.php?nav=mainPage");
  }
  include 'model/model_mainPage.php';
  include 'view/view_header.php';
  include 'view/view_mainPage.php';
  include 'view/view_footer.php';
}

?>
