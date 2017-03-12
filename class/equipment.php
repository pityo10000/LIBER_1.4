<?php
class Equipment {

  private $id;
  private $name;
  private $price;
  private $priceUnit;
  private $time;
  private $timeUnit;
  private $amount;
  private $description;
  private $ownerId;
  private $ownerName;
  private $venueId;
  private $venueName;

  function __construct(
    $id,
    $name,
    $price,
    $priceUnit,
    $time,
    $timeUnit,
    $amount,
    $description,
    $ownerId,
    $ownerName,
    $venueId,
    $venueName)
    {
      $this->id = $id;
      $this->name = $name;
      $this->price = $price;
      $this->priceUnit = $priceUnit;
      $this->time = $time;
      $this->timeUnit = $timeUnit;
      $this->amount = $amount;
      $this->description = $description;
      $this->ownerId = $ownerId;
      $this->ownerName = $ownerName;
      $this->venueId = $venueId;
      $this->venueName = $venueName;
    }

  function getId() {
    return $this->id;
  }

  function getName() {
    return $this->name;
  }

  function getAmount() {
    return $this->amount;
  }

  function getDescription() {
    return $this->description;
  }

  function getPrice() {
    return $this->price;
  }

  function getPriceUnit() {
    return $this->priceUnit;
  }

  function getTime() {
    return $this->time;
  }

  function getTimeUnit() {
    return $this->timeUnit;
  }

  function getOwnerId() {
    return $this->ownerId;
  }

  function getOwnerName() {
    return $this->ownerName;
  }

  function getVenueId() {
    return $this->venueId;
  }

  function getVenueName() {
    return $this->venueName;
  }

  static function itemToString($i, $item) {

    $actions = "";

    if ($_GET['nav'] == 'equipments') {
      $actions = '
      <div class="btn-group">
        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Műveletek <span class="caret"></span>
        </button>
        <ul class="dropdown-menu">
          <li><a href="#">Törlés</a></li>
          <li><a href="#">Módosítás</a></li>
        </ul>
      </div>
      ';
    } else if (!isset($_SESSION['login'])) {
    } else if ($item[$i]->getOwnerId() != $_SESSION['login']->getId()) {
      $db = new Database();
      $db->connect();
      $db->select('favorite', '*', null, 'item_id=' . $item[$i]->getId() . ' AND item_type="equipment" AND account_id=' . $_SESSION['login']->getId(), null, null);
      $res = $db->getResult();

        if (count($res) == 0) {
          $actions = '
          <form method="POST">
            <input type="hidden" name="action" value="favoriteInsert">
            <input type="hidden" name="itemId" value="' . $item[$i]->getId() . '">
            <input type="hidden" name="itemType" value="equipment">
            <button type="submit" class="btn btn-primary">Kedvencnek jelölöm</button>
          </form>
          ';
        } else {
          foreach ($res as $result) {
          $actions = '
          <form method="POST">
            <input type="hidden" name="action" value="favoriteDelete">
            <input type="hidden" name="favoriteId" value="' . $result['id'] . '">
            <input type="hidden" name="itemType" value="equipment">
            <button type="submit" class="btn btn-danger">Kivétel a kedvencekből</button>
          </form>
          ';
        }
      }
    }

    return '
      <div class="col-md-3 col-xs-12">
        <div class="thumbnail itemBox">
          <img class="img-thumbnail" src="img\helyszin1.jpg" width="304" height="236">
          <div class="caption">
            <h3>' . $item[$i]->getName() . '</h3>
            <p>Tulajdonos: ' . $item[$i]->getOwnerName() . '</p>
            <p>Helyszín: ' . $item[$i]->getVenueName() . '</p>
            <p>Elérhető: ' . $item[$i]->getAmount() . ' db</p>
            <p>Alapár: ' . $item[$i]->getPrice() . ' ' . $item[$i]->getPriceUnit() . ' / ' . $item[$i]->getTime() . ' ' . $item[$i]->getTimeUnit() . '</p>
            <p>
              ' . $actions . '
              <a href="" class="btn btn-default" role="button" data-toggle="modal" data-target="#itemDetails-' . $item[$i]->getId() . '">Részletek</a>
            </p>
          </div>
        </div>
      </div>
    ';
  }

  static function itemDetailsToString($i, $item) {
    $reservationForm = "";

    include 'model/equipment_reservation.php';

    return '
      <div class="modal fade" id="itemDetails-' . $item[$i]->getId() . '" role="dialog">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <label>' . $item[$i]->getName() . '</label>
            </div>
            <div class="modal-body">
              <img class="img-thumbnail" src="img\helyszin1.jpg" width="304" height="236">
              <div class="caption">
                <p>Tulajdonos: ' . $item[$i]->getOwnerName() . '</p>
                <p>Helyszín: ' . $item[$i]->getVenueName() . '</p>
                <p>Mennyiség: ' . $item[$i]->getAmount() . ' db</p>
                <p>Ár: ' . $item[$i]->getPrice() . ' ' . $item[$i]->getPriceUnit() . ' / db /' . $item[$i]->getTime() . ' ' . $item[$i]->getTimeUnit() . '</p>
                <iframe class="well well-lg" srcdoc="' . $item[$i]->getDescription() . '" width="90%" height="200" scrolling="yes">                </iframe>
              </div>
              ' . $reservationForm . '
            </div>
            <div class="modal-footer">
              <button id="close" type="button" class="btn btn-default" data-dismiss="modal">Bezár</button>
            </div>
          </div>
        </div>
      </div>
    ';
  }
}


?>
