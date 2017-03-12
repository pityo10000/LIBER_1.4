<?php
  require_once 'sql/mysql_crud.php';
  $db = new Database();
  $db->connect();
  $db->select('account', '*, account.id AS login_id', 'user, permission, company_profile', 'email="' . $_POST['loginEmail'] . '" AND account.user_id = user.id AND account.permission_id = permission.id AND account.company_profile_id = company_profile.id', null, null);
  $res = $db->getResult();
  $_SESSION['alertType'] = "danger";
  $_SESSION['alertText'] = "<strong>Figyelem!</strong> Hibás felhasználónév, vagy jelszó!";

  foreach ($res as $result) {
    if (($result['email'] == $_POST['loginEmail']) && ($result['password'] == $_POST['loginPassword'])) {
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
      $account = new Account($result['login_id'], $user, $permission, $companyProfile);

      $_SESSION['alertType'] = "success";
      $_SESSION['alertText'] = "Sikeres Bejelentkezés!";
      $_SESSION["login"] = $account;
      break;
    }
  }
?>
