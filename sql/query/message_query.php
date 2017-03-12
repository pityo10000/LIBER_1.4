<?php
  require('../../class/account.php');
  session_name('bejelentkezes');
  session_start();
  require_once '../mysql_crud.php';

  /*$partners = array();
  $partners = $_POST['partners'];*/


  if (isset($_POST['count'])) {
    $db = new Database();
    $db->connect();
    $db->select('message', 'count(*)', null, '(sender_id = ' . $_GET['partner'] . ' OR receiver_id = ' . $_GET['partner'] . ') AND (sender_id = ' . $_SESSION['login']->getId() . ' OR receiver_id = ' . $_SESSION['login']->getId() . ')', null, null);
    $res = $db->getResult();

    foreach ($res as $result) {
      echo $result['count(*)'];
    }
  } else {

    /*if (!isset($_GET['partner']) && count($partners) != 0) {
      $_GET['partner'] = $partners[0];
    }
  */
    //if (isset($_GET['partner']) && in_array($_GET['partner'], $partners)) {
    if (isset($_GET['partner'])) {
      $db = new Database();
      $db->connect();
      $db->select('account', 'account.id, account.user_id, user.id, user.name, user.name AS partner_name', 'user', 'account.id = ' . $_GET['partner'] . ' AND account.user_id = user.id', null, null);
      $res = $db->getResult();

      foreach ($res as $result) {
        $partnerName = $result['partner_name'];
      }

      $db = new Database();
      $db->connect();
      $db->select('message', 'count(*)', null, '(sender_id = ' . $_GET['partner'] . ' OR receiver_id = ' . $_GET['partner'] . ') AND (sender_id = ' . $_SESSION['login']->getId() . ' OR receiver_id = ' . $_SESSION['login']->getId() . ')', null, null);
      $res = $db->getResult();

      foreach ($res as $result) {
        $messageBlock = '
          <input type="hidden" name="count" value="' . $result['count(*)'] . '">
          <div id="messagePanel" class="row">
        ';
      }

      $db = new Database();
      $db->connect();
      $db->select('message', '*', null, '(receiver_id = ' . $_SESSION['login']->getId() . ' OR sender_id = ' . $_SESSION['login']->getId() . ') AND (receiver_id = ' . $_GET['partner'] . ' OR sender_id = ' . $_GET['partner'] . ')', null, null);
      $res = $db->getResult();

      foreach ($res as $result) {
        if ($result['sender_id'] == $_SESSION['login']->getId()) {
          $messageBlock .= '
          <div class="row">
            <div class="col-md-2 col-xs-2"></div>
            <div class="col-md-10 col-xs-10">
              <div class="row messageMe">
                <div class="row senderMe">
                  <label>Én:</label>
                </div>
                <div class="messageBody">
                  <label>' . $result['content'] . '</label>
                </div>
                <p>Elküldve: ' . $result['time'] . '</p>
              </div>
            </div>
            <div class="col-md-0 col-xs-0"></div>
          </div>
          ';
        } else {
          $messageBlock .= '
          <div class="row">
            <div class="col-md-0 col-xs-0"></div>
            <div class="col-md-10 col-xs-10">
              <div class="row messagePartner">
                <div class="row senderPartner">
                  <label>' . $partnerName . ':</label>
                </div>
                <div class="messageBody">
                  <label>' . $result['content'] . '</label>
                </div>
                <p>Elküldve: ' . $result['time'] . '</p>
              </div>
            </div>
            <div class="col-md-2 col-xs-2"></div>
          </div>
          ';
        }
      }
    } else {
      $messageBlock .= '<label>Nincs megjelenítve beszélgetés</label>';
    }

    $messageBlock .= '</div>';

    echo $messageBlock;

  }

?>
