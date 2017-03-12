<?php
//TODO Form rendes átalakítása

if (isset($_SESSION['login']) && $_SESSION['login']->getPermission()->getSettings() == 1) {
  $title = "Beállítások";

  if ($_SESSION['login']->getPermission()->getPermissionName() != "customer") {
    $form = '
    <form method="POST">

      <label><h3 class="text company">Cég adatok:</h3></label>

      <div class="row">
        <div class="col-md-4"></div>
        <div class="col-md-4"><label class="company">Cég név:</label></div>
        <div class="col-md-4"></div>
      </div>

      <div class="row">
        <div class="col-md-4"></div>
        <div class="input col-md-4"><input name="name" class="form-control" type="text" value=' . $_SESSION['login']->getUser()->getName() . 'required></div>
        <div class="col-md-4"></div>
      </div>

      <div class="row">
        <div class="col-md-4"></div>
        <div class="col-md-4"><label class="company">Kapcsolattartó neve:</label></div>
        <div class="col-md-4"></div>
      </div>

      <div class="row">
        <div class="col-md-4"></div>
        <div class="input col-md-4"><input name="contactName" class="form-control company" type="text" value=' . $_SESSION['login']->getCompanyProfile()->getContactName() . '></div>
        <div class="col-md-4"></div>
      </div>

      <div class="row">
        <div class="col-md-4"></div>
        <div class="col-md-4"><label>Telefonszám:</label></div>
        <div class="col-md-4"></div>
      </div>

      <div class="row">
        <div class="col-md-4"></div>
        <div class="input col-md-4"><input name="phoneNumber" class="form-control" type="text" value=' . $_SESSION['login']->getUser()->getPhoneNumber() . ' required></div>
        <div class="col-md-4"></div>
      </div>

      <div class="row">
        <div class="col-md-4"></div>
        <div class="col-md-4"><label class="company">Adószám:</label></div>
        <div class="col-md-4"></div>
      </div>

      <div class="row">
        <div class="col-md-4"></div>
        <div class="input col-md-4"><input name="taxNumber" class="form-control company companyInput" type="text" value="' . $_SESSION['login']->getCompanyProfile()->getTaxNumber() . '" required></div>
        <div class="col-md-4"></div>
      </div>

      <div class="row">
        <div class="col-md-4"></div>
        <div class="col-md-4"><label class="company">Leírás:</label></div>
        <div class="col-md-4"></div>
      </div>

      <div class="row">
        <div class="col-md-4"></div>
        <div class="col-md-4"><textarea name="description" class="form-control company companyInput" maxlength="500" rows="7" required>' . $_SESSION['login']->getCompanyProfile()->getDescription() . '</textarea></div>
        <div class="col-md-4"></div>
      </div>

      <div class="row">
        <div class="col-md-4"></div>
        <div class="col-md-4"><label class="company">Logó feltöltés:</label></div>
        <div class="col-md-4"></div>
      </div>

      <div class="row">
        <div class="col-md-4"></div>
        <div class="col-md-4"><input style="height: 100px;" name="logo" class="company" type="file"></div>
        <div class="col-md-4"></div>
      </div>

      <label><h3 class="text company">Székhely adatok:</h3></label>

      <div class="row">
        <div class="col-md-4"></div>
        <div class="col-md-4"><label class="company">Irányítószám:</label></div>
        <div class="col-md-4"></div>
      </div>

      <div class="row">
        <div class="col-md-4"></div>
        <div class="input col-md-4"><input name="addressZipCode" class="form-control company companyInput" type="text" value="' . $_SESSION['login']->getCompanyProfile()->getAddressZipCode() . '" required></div>
        <div class="col-md-4"></div>
      </div>

      <div class="row">
        <div class="col-md-4"></div>
        <div class="col-md-4"><label class="company">Ország:</label></div>
        <div class="col-md-4"></div>
      </div>

      <div class="row">
        <div class="col-md-4"></div>
        <div class="input col-md-4"><input name="addressCountry" class="form-control company companyInput" type="text" value="' . $_SESSION['login']->getCompanyProfile()->getAddressCountry() . '" required></div>
        <div class="col-md-4"></div>
      </div>

      <div class="row">
        <div class="col-md-4"></div>
        <div class="col-md-4"><label class="company">Város:</label></div>
        <div class="col-md-4"></div>
      </div>

      <div class="row">
        <div class="col-md-4"></div>
        <div class="input col-md-4"><input name="addressCity" class="form-control company companyInput" type="text" value="' . $_SESSION['login']->getCompanyProfile()->getAddressCity() . '" required></div>
        <div class="col-md-4"></div>
      </div>

      <div class="row">
        <div class="col-md-4"></div>
        <div class="col-md-4"><label class="company">Utca, házszám:</label></div>
        <div class="col-md-4"></div>
      </div>

      <div class="row">
        <div class="col-md-4"></div>
        <div class="input col-md-4"><input name="addressStreet" class="form-control company companyInput" type="text" value="' . $_SESSION['login']->getCompanyProfile()->getAddressStreet() . '" required></div>
        <div class="col-md-4"></div>
      </div>

      </br>
      </br>

      <label><h3 class="text company">Jelszó változtatás:</h3></label>

      <div class="row">
        <div class="col-md-4"></div>
        <div class="col-md-4"><label class="company">Új jelszó:</label></div>
        <div class="col-md-4"></div>
      </div>
      (csak akkor töltse ki, ha szeretne jelszót változtatni!)
      <div class="row">
        <div class="col-md-4"></div>
        <div class="input col-md-4"><input name="password" class="form-control company companyInput" type="password"></div>
        <div class="col-md-4"></div>
      </div>

      <div class="row">
        <div class="col-md-4"></div>
        <div class="col-md-4"><label class="company">Új jelszó mégegyszer:</label></div>
        <div class="col-md-4"></div>
      </div>

      <div class="row">
        <div class="col-md-4"></div>
        <div class="input col-md-4"><input name="passwordConfirm" class="form-control company companyInput" type="password"></div>
        <div class="col-md-4"></div>
      </div>

      </br>
      </br>

      <div class="row">
        <div class="col-md-4"></div>
        <div class="col-md-4"><label style="color: red;" class="company">Jelenlegi jelszó:</label></div>
        <div class="col-md-4"></div>
      </div>

      <div class="row">
        <div class="col-md-4"></div>
        <div class="input col-md-4"><input name="currentPassword" class="form-control company companyInput" type="password"></div>
        <div class="col-md-4"></div>
      </div>

      </br>

      <div class="row">
        <div class="col-md-5"></div>
        <input type="submit" id="submitButton" value="Módosítás" class="btn btn-default col-md-2 button"></input>
        <div class="col-md-5"></div>
      </div>

      </br>

      <input name="action" value="updateSubmit" type="hidden"></input>
    </form>
    ';
  } else {
    $form = '
    <form method="POST">

      <label class="text customer">Felhasználói adatok:</label>

      <div class="row">
        <div class="col-md-4"></div>
        <div class="col-md-4"><label class="customer">Név:</label></div>
        <div class="col-md-4"></div>
      </div>

      <div class="row">
        <div class="col-md-4"></div>
        <div class="input col-md-4"><input name="name" class="form-control" type="text" value="' . $_SESSION['login']->getUser()->getName() . '" required></div>
        <div class="col-md-4"></div>
      </div>

      <div class="row">
        <div class="col-md-4"></div>
        <div class="col-md-4"><label>Telefonszám:</label></div>
        <div class="col-md-4"></div>
      </div>

      <div class="row">
        <div class="col-md-4"></div>
        <div class="input col-md-4"><input name="phoneNumber" class="form-control" type="text" value=' . $_SESSION['login']->getUser()->getPhoneNumber() . ' required></div>
        <div class="col-md-4"></div>
      </div>

      </br>
      </br>

      <label><h3 class="text company">Jelszó változtatás:</h3></label>

      <div class="row">
        <div class="col-md-4"></div>
        <div class="col-md-4"><label class="company">Új jelszó:</label></div>
        <div class="col-md-4"></div>
      </div>
      (csak akkor töltse ki, ha szeretne jelszót változtatni!)
      <div class="row">
        <div class="col-md-4"></div>
        <div class="input col-md-4"><input name="password" class="form-control company companyInput" type="password"></div>
        <div class="col-md-4"></div>
      </div>

      <div class="row">
        <div class="col-md-4"></div>
        <div class="col-md-4"><label class="company">Új jelszó mégegyszer:</label></div>
        <div class="col-md-4"></div>
      </div>

      <div class="row">
        <div class="col-md-4"></div>
        <div class="input col-md-4"><input name="passwordConfirm" class="form-control company companyInput" type="password"></div>
        <div class="col-md-4"></div>
      </div>

      </br>
      </br>

      <div class="row">
        <div class="col-md-4"></div>
        <div class="col-md-4"><label style="color: red;" class="company">Jelenlegi jelszó:</label></div>
        <div class="col-md-4"></div>
      </div>

      <div class="row">
        <div class="col-md-4"></div>
        <div class="input col-md-4"><input name="currentPassword" class="form-control company companyInput" type="password"></div>
        <div class="col-md-4"></div>
      </div>

      </br>

      <div class="row">
        <div class="col-md-5"></div>
        <input type="submit" id="submitButton" value="Módosítás" class="btn btn-default col-md-2 button"></input>
        <div class="col-md-5"></div>
      </div>

      </br>

      <input name="action" value="updateSubmit" type="hidden"></input>
    </form>
    ';
  }
} else {
$notFound = true;
}
?>
