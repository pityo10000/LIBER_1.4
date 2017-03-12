
    <script type="text/javascript" src="js/registration.js?version=1.0"></script>
    <script type="text/javascript">

      $(document).ready(function() {
        $('button[onclick="chooseCustomerType();"]').addClass(' active');
      });

      function chooseCustomerType() {
        $(document).ready(function() {
          $('button[onclick="chooseCustomerType();"]').addClass(' active');
          $('button[onclick="chooseOrganizerType();"]').removeClass(' active');
          $('button[onclick="chooseServiceType();"]').removeClass(' active');
        });

        <?php
          $userType = "customer";
        ?>
        document.getElementById("userType").value = "customer";
        var customers = document.getElementsByClassName('customer');
        for(var i = 0; i < customers.length; i++) {
          customers[i].style.visibility = "visible";
          customers[i].style.position = "static";
        }
        var companies = document.getElementsByClassName('company');
        for(var i = 0; i < companies.length; i++) {
          companies[i].style.visibility = "hidden";
          companies[i].style.position = "fixed";
        }
        var companyInputs = document.getElementsByClassName('companyInput');
        for(var i = 0; i < companyInputs.length; i++) {
          companyInputs[i].required = false;
        }
      }

      function chooseOrganizerType() {
        $(document).ready(function() {
          $('button[onclick="chooseCustomerType();"]').removeClass(' active');
          $('button[onclick="chooseOrganizerType();"]').addClass(' active');
          $('button[onclick="chooseServiceType();"]').removeClass(' active');
        });

        <?php
          $userType = "organizer";
        ?>
        document.getElementById("userType").value = "organizer";
        var customers = document.getElementsByClassName('customer');
        for(var i = 0; i < customers.length; i++) {
          customers[i].style.visibility = "hidden";
          customers[i].style.position = "fixed";
        }
        var companies = document.getElementsByClassName('company');
        for(var i = 0; i < companies.length; i++) {
          companies[i].style.visibility = "visible";
          companies[i].style.position = "static";
        }
        var companyInputs = document.getElementsByClassName('companyInput');
        for(var i = 0; i < companyInputs.length; i++) {
          companyInputs[i].required = true;
        }
      }
      function chooseServiceType() {
        $(document).ready(function() {
          $('button[onclick="chooseCustomerType();"]').removeClass(' active');
          $('button[onclick="chooseOrganizerType();"]').removeClass(' active');
          $('button[onclick="chooseServiceType();"]').addClass(' active');
        });

        document.getElementById("userType").value = "service";
        var customers = document.getElementsByClassName('customer');
        for(var i = 0; i < customers.length; i++) {
          customers[i].style.visibility = "hidden";
          customers[i].style.position = "fixed";
        }
        var companies = document.getElementsByClassName('company');
        for(var i = 0; i < companies.length; i++) {
          companies[i].style.visibility = "visible";
          companies[i].style.position = "static";
        }
        var companyInputs = document.getElementsByClassName('companyInput');
        for(var i = 0; i < companyInputs.length; i++) {
          companyInputs[i].required = true;
        }
      }
    </script>

    </br>
    </br>

    <label class="text" style="font-size: 20px;">Kérem, válassza ki, miként szeretne beregisztrálni!</label>

    <div class="row">
      <div class="col-md-3"></div>
        <button onclick="chooseCustomerType();" type="button" class="btn btn-default col-xs-12 col-md-2">Megrendelő</button>
        <button onclick="chooseOrganizerType();" type="button" class="btn btn-default col-xs-12 col-md-2">Rendezvényszervező cég</button>
        <button onclick="chooseServiceType();" type="button" class="btn btn-default col-xs-12 col-md-2">Szolgáltató</button>
      <div class="col-md-3"></div>
    </div>

    </br>
    </br>

    <form method="POST">
      <label class="text">Bejelentkezési adatok:</label>
      <input id="userType" name="userType" type="hidden" value="customer">

    <div class="row">
      <div class="col-md-4"></div>
      <label class="col-md-4">Email cím:</label>
      <div class="col-md-4"></div>
    </div>

    <p id="email_error" class="error"></p>

    <div class="row">
      <div class="col-md-4"></div>
      <div class="input col-md-4"><input name="email" class="form-control" type="text" required></div>
      <div class="col-md-4"></div>
    </div>

    <div class="row">
      <div class="col-md-4"></div>
      <label class="col-md-4">Jelszó:</label>
      <div class="col-md-4"></div>
    </div>

    <p style="font-style: italic;">Legalább 8 karakter, 1 kis betű, 1 nagy betű, 1 szám</p>

    <p id="password_error" class="error"></p>

    <div class="row">
      <div class="col-md-4"></div>
      <div class="input col-md-4"><input name="password" class="form-control" type="password" required></div>
      <div class="col-md-4"></div>
    </div>

    <div class="row">
      <div class="col-md-4"></div>
      <label class="col-md-4">Jelszó megerősítése:</label>
      <div class="col-md-4"></div>
    </div>

    <p id="passwordConfirm_error" class="error"></p>

    <div class="row">
      <div class="col-md-4"></div>
      <div class="input col-md-4"><input name="passwordConfirm" class="form-control" type="password" required></div>
      <div class="col-md-4"></div>
    </div>

    </br>
    </br>

    <label class="text company">Cég adatok:</label>
    <label class="text customer">Felhasználói adatok:</label>

    <div class="row">
      <div class="col-md-4"></div>
      <div class="col-md-4"><label class="company">Cég név:</label></div>
      <div class="col-md-4"></div>
    </div>

    <div class="row">
      <div class="col-md-4"></div>
      <div class="col-md-4"><label class="customer">Név:</label></div>
      <div class="col-md-4"></div>
    </div>

    <p id="name_error" class="error"></p>

    <div class="row">
      <div class="col-md-4"></div>
      <div class="input col-md-4"><input name="name" class="form-control" type="text" required></div>
      <div class="col-md-4"></div>
    </div>

    <div class="row">
      <div class="col-md-4"></div>
      <div class="col-md-4"><label class="company">Kapcsolattartó neve:</label></div>
      <div class="col-md-4"></div>
    </div>

    <p id="contactName_error" class="error"></p>

    <div class="row">
      <div class="col-md-4"></div>
      <div class="input col-md-4"><input name="contactName" class="form-control company" type="text"></div>
      <div class="col-md-4"></div>
    </div>

    <div class="row">
      <div class="col-md-4"></div>
      <div class="col-md-4"><label>Telefonszám:</label></div>
      <div class="col-md-4"></div>
    </div>

    <p id="phoneNumber_error" class="error"></p>

    <div class="row">
      <div class="col-md-4"></div>
      <div class="input col-md-4"><input name="phoneNumber" class="form-control" type="text" required></div>
      <div class="col-md-4"></div>
    </div>

    <div class="row">
      <div class="col-md-4"></div>
      <div class="col-md-4"><label class="company">Adószám:</label></div>
      <div class="col-md-4"></div>
    </div>

    <p id="taxNumber_error" class="error"></p>

    <div class="row">
      <div class="col-md-4"></div>
      <div class="input col-md-4"><input name="taxNumber" class="form-control company companyInput" type="text"></div>
      <div class="col-md-4"></div>
    </div>

    <div class="row">
      <div class="col-md-4"></div>
      <div class="col-md-4"><label class="company">Leírás:</label></div>
      <div class="col-md-4"></div>
    </div>

    <p id="description_error" class="error"></p>

    <div class="row">
      <div class="col-md-4"></div>
      <div class="col-md-4"><textarea name="description" class="form-control company companyInput" maxlength="500" rows="7"></textarea></div>
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

    <label class="text company">Székhely adatok:</label>

    <div class="row">
      <div class="col-md-4"></div>
      <div class="col-md-4"><label class="company">Irányítószám:</label></div>
      <div class="col-md-4"></div>
    </div>

    <p id="addressZipCode_error" class="error"></p>

    <div class="row">
      <div class="col-md-4"></div>
      <div class="input col-md-4"><input name="addressZipCode" class="form-control company companyInput" type="text"></div>
      <div class="col-md-4"></div>
    </div>

    <div class="row">
      <div class="col-md-4"></div>
      <div class="col-md-4"><label class="company">Ország:</label></div>
      <div class="col-md-4"></div>
    </div>

    <p id="addressCountry_error" class="error"></p>

    <div class="row">
      <div class="col-md-4"></div>
      <div class="input col-md-4"><input name="addressCountry" class="form-control company companyInput" type="text"></div>
      <div class="col-md-4"></div>
    </div>

    <div class="row">
      <div class="col-md-4"></div>
      <div class="col-md-4"><label class="company">Város:</label></div>
      <div class="col-md-4"></div>
    </div>

    <p id="addressCity_error" class="error"></p>

    <div class="row">
      <div class="col-md-4"></div>
      <div class="input col-md-4"><input name="addressCity" class="form-control company companyInput" type="text"></div>
      <div class="col-md-4"></div>
    </div>

    <div class="row">
      <div class="col-md-4"></div>
      <div class="col-md-4"><label class="company">Utca, házszám:</label></div>
      <div class="col-md-4"></div>
    </div>

    <p id="addressStreet_error" class="error"></p>

    <div class="row">
      <div class="col-md-4"></div>
      <div class="input col-md-4"><input name="addressStreet" class="form-control company companyInput" type="text"></div>
      <div class="col-md-4"></div>
    </div>

    </br>
    </br>

    <div class="row">
      <div class="col-md-3"></div>
      <div class="col-md-6"><label>Figyelem! A regisztrációval elfogadja <a href="privacyStatement.php">adatvédelmi és felhasználási</a> nyilatkozatunkat!</label></div>
      <div class="col-md-3"></div>
    </div>

    </br>

    <div class="row">
      <div class="col-md-3"></div>
      <input type="submit" id="submitButton" value="Regisztráció" class="btn btn-default col-md-2 button"></input>
      <div class="col-md-2"></div>
      <div onclick="redirect(&quot;index.php&quot;);" class="btn btn-default col-md-2 button">vissza</div>
      <div class="col-md-3"></div>
    </div>

    </br>

    <input name="action" value="registrationSubmit" type="hidden"></input>
  </form>


  </div>
