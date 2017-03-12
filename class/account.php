<?php
class Account {
  private $id;
  private $user;
  private $permission;
  private $companyProfile;

  function __construct($id, $user, $permission, $companyProfile)
  {
    $this->id = $id;
    $this->user = $user;
    $this->permission = $permission;
    $this->companyProfile = $companyProfile;
  }

  public function getId(){
    return $this->id;
  }

  public function getUser(){
    return $this->user;
  }

  public function getPermission(){
    return $this->permission;
  }

  public function getCompanyProfile(){
    return $this->companyProfile;
  }

  static function itemToString($i, $item) {
    switch ($item[$i]->getPermission()->getPermissionName()) {
      case 'organizer':
        $companyType = "Rendezvényszervező";
        $itemType = "organizer";
        break;
      case 'service':
        $companyType = "Szolgáltató";
        $itemType = "serviceProvider";
        break;
      default:
        $companyType = "Rendezvényszervező";
        $itemType = "organizer";
        break;
    }

    $actions = "";

    if (isset($_SESSION['login']) && $item[$i]->getId() != $_SESSION['login']->getId()) {
      $db = new Database();
      $db->connect();
      $db->select('favorite', '*', null, 'item_id=' . $item[$i]->getId() . ' AND item_type="' . $itemType . '" AND account_id=' . $_SESSION['login']->getId(), null, null);
      $res = $db->getResult();

        if (count($res) == 0) {
          $actions = '
          <form method="POST">
            <input type="hidden" name="action" value="favoriteInsert">
            <input type="hidden" name="itemId" value="' . $item[$i]->getId() . '">
            <input type="hidden" name="itemType" value="' . $itemType . '">
            <button type="submit" class="btn btn-primary">Kedvencnek jelölöm</button>
          </form>
          ';
        } else {
          foreach ($res as $result) {
          $actions = '
          <form method="POST">
            <input type="hidden" name="action" value="favoriteDelete">
            <input type="hidden" name="favoriteId" value="' . $result['id'] . '">
            <input type="hidden" name="itemType" value="' . $itemType . '">
            <button type="submit" class="btn btn-danger">Kivétel a kedvencekből</button>
          </form>
          ';
        }
      }
    }

    $actions .= '
    <a href="" class="btn btn-default" role="button" data-toggle="modal" data-target="#itemDetails-' . $item[$i]->getId() . '">Részletek</a>
    <form method="POST">
      <input type="hidden" name="action" value="messagePartnerInsert">
      <input type="hidden" name="partnerName" value="' . $item[$i]->getUser()->getName() . '">
      <input type="hidden" name="partnerId" value="' . $item[$i]->getId() . '">
      <button type="submit" class="btn btn-primary">Üzenet</button>
    </form>
    ';

    return '
      <div class="col-md-3 col-xs-12">
        <div class="thumbnail" style="height: 380px;">
          <img class="img-thumbnail" src="img\helyszin1.jpg" width="304" height="236">
          <div class="caption">
            <h3>' . $item[$i]->getUser()->getName() . '</h3>
            <p>' . $item[$i]->getCompanyProfile()->getFullAddress() . '</p>
            <p>: ' . $companyType . '</p>
            <p>
              ' . $actions . '
            </p>
          </div>
        </div>
      </div>
    ';
  }

  static function itemDetailsToString($i, $item) {
    switch ($item[$i]->getPermission()->getPermissionName()) {
      case 'organizer':
        $companyType = "Rendezvényszervező";
        break;
      case 'service':
        $companyType = "Szolgáltató";
        break;
      default:
        $companyType = "Rendezvényszervező";
        break;
    }

    $str = "";

    if ($item[$i]->getPermission()->getPermissionName() == 'organizer') {

      $str = '
      <p>
        <button class="btn btn-primary col-md-12 col-xs-12" type="button" data-toggle="collapse" data-target="#venues" aria-expanded="false" aria-controls="venues">
          Helyszínek
        </button>
      </p>
      <div class="collapse" id="venues">
      ';

        $db = new Database();
        $db->connect();
        $db->select('venue', '*', null, 'owner_id=' . $item[$i]->getId(), null, null);
        $res = $db->getResult();

        $venues = array();
        $count = 0;

        if (count($res) == 0) {
          $str .= '
            <div class="card card-block">
              Jelenleg nincs még helyszín!
            </div>
          ';
        } else {
          $str .= '
          <div class="card card-block">
          <table class="table">
          ';

          foreach ($res as $result) {
          $str .= '
              <tr>
                <td>' . $result['name'] . '</td>
                <td>' . $result['price'] . ' ' . $result['price_unit'] . ' / ' . $result['time'] . ' ' . $result['time_unit'] . '</td>
                <td><a class="btn btn-default" role="button" data-toggle="modal" data-target="#venueDetails-' . $result['id'] . '">Részletek</a></td>
              </tr>
          ';

          array_push($venues, new Venue($result['id'], $result['name'], $result['description'], $result['price'], $result['price_unit'], $result['time'], $result['time_unit'], $result['owner_id'], $result['owner_name']));

          echo Venue::itemDetailsToString($count++, $venues);
        }

        $str .= '</table>';
    }

    $str .= '
            </div>
          </div>
          ';
    }

    return '
      <div class="modal fade" id="itemDetails-' . $item[$i]->getId() . '" role="dialog">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <label>' . $item[$i]->getUser()->getName() . '</label>
            </div>
            <div class="modal-body">
              <img class="img-thumbnail" src="img\helyszin1.jpg" width="304" height="236">
              <div class="caption">
                <p>' . $item[$i]->getCompanyProfile()->getFullAddress() . '</p>
                <p>Székhely: ' . $companyType . '</p>
                <p>Kapcsolattartó: ' . $item[$i]->getCompanyProfile()->getContactName() . '</p>
                <p>Telefonszám: ' . $item[$i]->getUser()->getPhoneNumber() . '</p>
                <p>E-mail cím: ' . $item[$i]->getUser()->getEmail() . '</p>
                <p>Adószám: ' . $item[$i]->getCompanyProfile()->getTaxNumber() . '</p>
                <iframe class="well well-lg" srcdoc="' . $item[$i]->getCompanyProfile()->getDescription() . '" width="90%" height="200" scrolling="yes">                </iframe>
              </div>
              ' . $str . '
              <p>
                <button class="btn btn-primary col-md-12 col-xs-12" type="button" data-toggle="collapse" data-target="#services" aria-expanded="false" aria-controls="services">
                  Szolgáltatások
                </button>
              </p>
              <div class="collapse" id="services">
                <div class="card card-block">
                  Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident.
                </div>
              </div>
              <p>
                <button class="btn btn-primary col-md-12 col-xs-12" type="button" data-toggle="collapse" data-target="#equipments" aria-expanded="false" aria-controls="equipments">
                  Felszerelések
                </button>
              </p>
              <div class="collapse" id="equipments">
                <div class="card card-block">
                  Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident.
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Bezár</button>
            </div>
          </div>
        </div>
      </div>
    ';
  }
}

class User {
  private $name;
  private $email;
  private $phoneNumber;

  function __construct($name, $email, $phoneNumber)
  {
    $this->name =$name;
    $this->email =$email;
    $this->phoneNumber =$phoneNumber;
  }

  public function getName(){
    return $this->name;
  }

  public function getEmail(){
    return $this->email;
  }

  public function getPhoneNumber(){
    return $this->phoneNumber;
  }

}

class CompanyProfile {

  private $contactName;
  private $taxNumber;
  private $description;
  private $addressZipCode;
  private $addressCountry;
  private $addressCity;
  private $addressStreet;
  private $logo;

  function __construct(
    $contactName,
    $taxNumber,
    $description,
    $addressZipCode,
    $addressCountry,
    $addressCity,
    $addressStreet,
    $logo)
  {
    $this->contactName =$contactName;
    $this->taxNumber =$taxNumber;
    $this->description =$description;
    $this->addressZipCode =$addressZipCode;
    $this->addressCountry =$addressCountry;
    $this->addressCity =$addressCity;
    $this->addressStreet =$addressStreet;
    $this->logo =$logo;
  }

  public function getContactName(){
    return $this->contactName;
  }

  public function getTaxNumber(){
    return $this->taxNumber;
  }

  public function getDescription(){
    return $this->description;
  }

  public function getAddressZipCode(){
    return $this->addressZipCode;
  }

  public function getAddressCountry(){
    return $this->addressCountry;
  }

  public function getAddressCity(){
    return $this->addressCity;
  }

  public function getAddressStreet(){
    return $this->addressStreet;
  }

  public function getFullAddress(){
    return $this->getAddressCountry() . ", " . $this->getAddressZipCode() . ", " .  $this->getAddressCity() . ", " . $this->getAddressStreet();
  }

  public function getLogo(){
    return $this->logo;
  }
}

class Permission {
  private $permissionName;
  private $venue;
  private $service;
  private $equipments;
  private $messages;
  private $settings;
  private $browse;
  private $favorites;
  private $events;
  private $block;
  private $userManage;
  private $confirm;

  function __construct(
    $permissionName,
    $venues,
    $services,
    $equipments,
    $messages,
    $settings,
    $browse,
    $favorites,
    $events,
    $block,
    $userManage,
    $confirm)
  {
    $this->permissionName =$permissionName;
    $this->venues =$venues;
    $this->services =$services;
    $this->equipments =$equipments;
    $this->messages =$messages;
    $this->settings =$settings;
    $this->browse =$browse;
    $this->favorites =$favorites;
    $this->events =$events;
    $this->block =$block;
    $this->userManage =$userManage;
    $this->confirm =$confirm;
  }

  public function getPermissionName(){
    return $this->permissionName;
  }

  public function getVenues(){
    return $this->venues;
  }

  public function getServices(){
    return $this->services;
  }

  public function getEquipments(){
    return $this->equipments;
  }

  public function getMessages(){
    return $this->messages;
  }

  public function getSettings(){
    return $this->settings;
  }

  public function getBrowse(){
    return $this->browse;
  }

  public function getFavorites(){
    return $this->favorites;
  }

  public function getEvents(){
    return $this->events;
  }

  public function getBlock(){
    return $this->block;
  }

  public function getUserManage(){
    return $this->userManage;
  }

  public function getConfirm(){
    return $this->confirm;
  }
}



?>
