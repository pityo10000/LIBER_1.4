<?php
require('../../class/account.php');
session_name('bejelentkezes');
session_start();
require_once '../mysql_crud.php';

$partnerName = null;
$partnerlist = "";
$partners = array();

$db = new Database();
$db->connect();
$db->select('messagePartner', '*', 'account, user', 'master_id = ' . $_SESSION['login']->getId() . ' && partner_id = account.id && account.user_id = user.id', null, null);
$res = $db->getResult();

if (count($res)) {
  foreach ($res as $result) {
    if ($result['partner_id'] != $_SESSION['login']->getId()) {
      $partnerlist .= '
        <a href="index.php?nav=messages&partner=' . $result['partner_id'] . '">
          <div class="row messagePartners">
            <label>' . $result['name'] . '</label>
          </div>
        </a>
      ';

      array_push($partners, $result['partner_id']);
    }
  }
} else {
  $partnerlist .= "</br><label>Nincs megjeleníthető partner</label>";
}

echo $partnerlist;

?>
