<?php
  if ($_POST['password'] != $_POST['passwordConfirm']) {
    $_SESSION['alertType'] = "danger";
    $_SESSION['alertText'] = "<strong>Figyelem!</strong> A két jelszó nem egyezik!";
  } else {

    require_once 'sql/mysql_crud.php';

    //TODO regisztráció átvizsgálása

    $inputData = array(
      "name" => $_POST['name'],
      "email" => $_POST['email'],
      "password" => $_POST['password'],
      "phoneNumber" => $_POST['phoneNumber']
    );

  	$db = new Database();
  	$db->connect();
  	$db->insert('user', $inputData);
  	$db->disconnect();

    if ($_POST['contactName'] != "") {
      $inputData = array(
        "contactName" => $_POST['contactName'],
        "taxNumber" => $_POST['taxNumber'],
        "description" => $_POST['description'],
        "addressZipCode" => $_POST['addressZipCode'],
        "addressCountry" => $_POST['addressCountry'],
        "addressCity" => $_POST['addressCity'],
        "addressStreet" => $_POST['addressStreet'],
        "logo" => $_POST['logo']
      );

    	$db = new Database();
    	$db->connect();
    	$db->insert('company_profile', $inputData);
    	$db->disconnect();
    }


    $db = new Database();
    $db->connect();
    $db->select('user', 'id', null, null, null); // Table name, Column Names, JOIN, WHERE conditions,
    $res = $db->getResult();

    foreach ($res as $result) {
      $user_id = $result['id'];
    }

    $company_profile_id = 1;

    if ($_POST['contactName'] != "") {
      $db = new Database();
      $db->connect();
      $db->select('company_profile', 'id', null, null, null); // Table name, Column Names, JOIN, WHERE conditions,
      $res = $db->getResult();

      foreach ($res as $result) {
        $company_profile_id = $result['id'];
      }
    }

    $db = new Database();
    $db->connect();
    $db->select('permission', 'id, permissionName', null, null, 'permissionName="' . $_POST['userType'] . '"'); // Table name, Column Names, JOIN, WHERE conditions,
    $res = $db->getResult();

    foreach ($res as $result) {
      $permission_id = $result['id'];
    }

    $inputData = array(
      "company_profile_id" => $company_profile_id,
      "permission_id" => $permission_id,
      "user_id" => $user_id,
      "deletedAccount" => 0
    );

  	$db = new Database();
  	$db->connect();
  	$db->insert('account', $inputData);
  	$db->disconnect();

    $_SESSION['alertType'] = "success";
    $_SESSION['alertText'] = "<strong>Sikeres regisztráció!</strong>";
  }
?>
