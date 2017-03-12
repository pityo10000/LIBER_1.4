<?php
//TODO Jelszóváltásnál kijelentkeztetés
//TODO Emailcím váltás

require_once 'sql/mysql_crud.php';
$db = new Database();
$db->connect();
$db->select('account', '*', 'user, permission, company_profile', 'email="' . $_SESSION["login"]->getUser()->getEmail() . '" AND account.user_id = user.id AND account.permission_id = permission.id AND account.company_profile_id = company_profile.id', null, null);
$res = $db->getResult();

$_SESSION['alertType'] = "danger";
$_SESSION['alertText'] = "<strong>Figyelem!</strong> Hibás jelszó! Próbálja újra!";

$userId = null;
$companyProfileId = null;

foreach ($res as $result) {
  if ($result['password'] == $_POST['currentPassword']) {
    $_SESSION['alertType'] = "success";
    $_SESSION['alertText'] = "<strong>Sikeres Módosítás!</strong>";
    $userId = $result['user_id'];
    $companyProfileId = $result['company_profile_id'];
    if ($_POST['password'] == "") {
      $_POST['password'] = $result['password'];
      $_POST['passwordConfirm'] = $result['password'];
    }
    break;
  }
}

if ($_POST['password'] != $_POST['passwordConfirm']) {
  $_SESSION['alertType'] = "danger";
  $_SESSION['alertText'] = "<strong>Figyelem!</strong> A két jelszó nem egyezik!";
} else {
  if ($_SESSION['login']->getPermission()->getPermissionName() == "customer") {
    $inputData = array(
      "name" => $_POST['name'],
      "phoneNumber" => $_POST['phoneNumber'],
      "password" => $_POST['password']
    );

  	$db = new Database();
  	$db->connect();
  	$db->update('user', $inputData, "user.id=" . $userId);
  	$db->disconnect();
  } else {
    $inputData = array(
      "name" => $_POST['name'],
      "phoneNumber" => $_POST['phoneNumber'],
      "password" => $_POST['password'],
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
  	$db->update('user, company_profile', $inputData, "user.id=" . $userId . " AND company_profile.id=" . $companyProfileId);
  	$db->disconnect();
  }

  $db = new Database();
  $db->connect();
  $db->select('account', '*', 'user, permission, company_profile', 'email="' . $_SESSION["login"]->getUser()->getEmail() . '" AND account.user_id = user.id AND account.permission_id = permission.id AND account.company_profile_id = company_profile.id', null, null);
  $res = $db->getResult();

  foreach ($res as $result) {
    if ($result['password'] == $_POST['currentPassword']) {
      var_dump($result['permissionName']);
      $user = new User($result['name'], $result['email'], $result['phoneNumber']);
      $permission = new Permission(
        $result['permissionName'],
        $result['venues'],
        $result['services'],
        $result['equipments'],
        $result['messages'],
        $result['settings'],
        $result['browse'],
        $result['favorites'],
        $result['events'],
        $result['block'],
        $result['userManage'],
        $result['confirm']
      );
      $companyProfile = new CompanyProfile(
        $result['contactName'],
        $result['taxNumber'],
        $result['description'],
        $result['addressZipCode'],
        $result['addressCountry'],
        $result['addressCity'],
        $result['addressStreet'],
        $result['logo']
      );

      $account = new Account($result['id'], $user, $permission, $companyProfile);

      $_SESSION["login"] = $account;
      break;
    }
  }
}
